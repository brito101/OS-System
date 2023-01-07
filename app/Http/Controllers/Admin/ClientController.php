<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ClientRequest;
use App\Imports\ClientImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Client;
use App\Models\ClientFile;
use App\Models\ClientHistory;
use App\Models\Collaborator;
use App\Models\Manager;
use App\Models\Seller;
use App\Models\Subsidiary;
use App\Models\Views\Client as ViewsClient;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('Listar Clientes')) {
            abort(403, 'Acesso não autorizado');
        }

        $role = Auth::user()->roles->first()->name;

        switch ($role) {
            case 'Colaborador':
            case 'Colaborador-NI':
                $subsidiaries = Collaborator::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                $clients = ViewsClient::where('trade_status', '!=', 'Restrito')->whereIn('subsidiary_id', $subsidiaries)->orWhere('subsidiary_id', null)->get();
                break;
            case 'Gerente':
                $subsidiaries = Manager::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                $clients = ViewsClient::where('trade_status', '!=', 'Restrito')->whereIn('subsidiary_id', $subsidiaries)->orWhere('subsidiary_id', null)->get();
                break;
            default:
                $clients = ViewsClient::all();
                break;
        }

        if ($request->ajax()) {
            return Datatables::of($clients)
                ->addIndexColumn()
                ->addColumn('trade_status', function ($row) {
                    switch ($row->trade_status) {
                        case 'Restrito':
                            $trade_status = '<span class="btn btn-danger font-weight-bold">' . $row->trade_status . '</span>';
                            break;
                        default:
                            $trade_status = $row->trade_status;
                            break;
                    }

                    return $trade_status;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-xs btn-dark mx-1 shadow" title="Timeline" href="clients/timeline/' . $row->id . '"><i class="fa fa-lg fa-fw fa-clock"></i></a>' . '<a class="btn btn-xs btn-success mx-1 shadow" title="Visualizar" href="clients/' . $row->id . '"><i class="fa fa-lg fa-fw fa-eye"></i></a>' . '<a class="btn btn-xs btn-primary mx-1 shadow" title="Editar" href="clients/' . $row->id . '/edit"><i class="fa fa-lg fa-fw fa-pen"></i></a>' . '<a class="btn btn-xs btn-danger mx-1 shadow" title="Excluir" href="clients/destroy/' . $row->id . '" onclick="return confirm(\'Confirma a exclusão deste cliente?\')"><i class="fa fa-lg fa-fw fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action', 'trade_status'])
                ->make(true);
        }

        return view('admin.clients.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->hasPermissionTo('Criar Clientes')) {
            abort(403, 'Acesso não autorizado');
        }

        $role = Auth::user()->roles->first()->name;

        switch ($role) {
            case 'Colaborador':
            case 'Colaborador-NI':
                $collaborators = Auth::user()->collaborators->pluck('subsidiary_id');
                $subsidiaries = Subsidiary::whereIn('id', $collaborators)->get();
                break;
            case 'Gerente':
                $managers = Auth::user()->managers->pluck('subsidiary_id');
                $subsidiaries = Subsidiary::whereIn('id', $managers)->get();
                break;
            default:
                $subsidiaries = Subsidiary::all();
                break;
        }

        $sellers = Seller::all();

        return view('admin.clients.create', compact('subsidiaries', 'sellers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientRequest $request)
    {
        if (!Auth::user()->hasPermissionTo('Criar Clientes')) {
            abort(403, 'Acesso não autorizado');
        }

        $data = $request->all();

        $role = Auth::user()->roles->first()->name;

        switch ($role) {
            case 'Colaborador':
            case 'Colaborador-NI':
                $collaborators = Auth::user()->collaborators->pluck('subsidiary_id');
                $subsidiary = Subsidiary::whereIn('id', $collaborators)->where('id', $data['subsidiary_id'])->first();
                break;
            case 'Gerente':
                $managers = Auth::user()->managers->pluck('subsidiary_id');
                $subsidiary = Subsidiary::whereIn('id', $managers)->where('id', $data['subsidiary_id'])->first();
                break;
            default:
                $subsidiary = Subsidiary::where('id', $data['subsidiary_id'])->first();
                break;
        }

        if (!$subsidiary) {
            abort(403, 'Acesso não autorizado');
        }

        if ($request->observations) {
            $observations = $request->observations;
            $dom = new \DOMDocument();
            $dom->encoding = 'utf-8';
            $dom->loadHTML(utf8_decode($observations), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD | LIBXML_NOERROR | LIBXML_NOWARNING);
            $imageFile = $dom->getElementsByTagName('img');

            foreach ($imageFile as $item => $image) {
                $img = $image->getAttribute('src');
                if (filter_var($img, FILTER_VALIDATE_URL) == false) {
                    list($type, $img) = explode(';', $img);
                    list(, $img) = explode(',', $img);
                    $imageData = base64_decode($img);
                    $image_name =  Str::slug($request->title) . '-' . time() . $item . '.png';
                    $path = storage_path() . '/app/public/observations/' . $image_name;
                    file_put_contents($path, $imageData);
                    $image->removeAttribute('src');
                    $image->removeAttribute('data-filename');
                    $image->setAttribute('alt', $request->title);
                    $image->setAttribute('src', url('storage/observations/' . $image_name));
                }
            }

            $observations = $dom->saveHTML();
            $data['observations'] = $observations;
        }

        $data['user_id'] = Auth::user()->id;

        $client = Client::create($data);

        $files = null;
        if ($request->file('attached_documents') != null) {
            $validator = Validator::make($request->only('attached_documents'), ['attached_documents.*' => 'file|mimes:pdf|max:125000']);

            if ($validator->fails() === true) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Todos os arquivos devem ser pdf com no máximo 1GB total');
            }
            $files = $request->file('attached_documents');
        }

        if ($client->save()) {
            if ($files) {
                foreach ($files as $file) {
                    $clientFile = new ClientFile();
                    $clientFile->client_id = $client->id;
                    $path = Storage::putFile('clients/files', $file);
                    $clientFile->file = $path;
                    $clientFile->user_id = Auth::user()->id;
                    $clientFile->save();
                    unset($clientFile);
                }
            }

            return redirect()
                ->route('admin.clients.index')
                ->with('success', 'Cadastro realizado!');
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Erro ao cadastrar!');
        }
    }

    public function show($id)
    {
        if (!Auth::user()->hasPermissionTo('Acessar Clientes')) {
            abort(403, 'Acesso não autorizado');
        }

        $role = Auth::user()->roles->first()->name;

        switch ($role) {
            case 'Colaborador':
            case 'Colaborador-NI':
                $client = Client::where('trade_status', '!=', 'Restrito')->where(function ($query) {
                    $collaborators = Auth::user()->collaborators->pluck('subsidiary_id');
                    $query->whereIn('subsidiary_id', $collaborators)
                        ->orWhere('subsidiary_id', null);
                })->where('id', $id)->first();
                break;
            case 'Gerente':
                $client = Client::where('trade_status', '!=', 'Restrito')->where(function ($query) {
                    $managers = Auth::user()->managers->pluck('subsidiary_id');
                    $query->whereIn('subsidiary_id', $managers)
                        ->orWhere('subsidiary_id', null);
                })->where('id', $id)->first();
                break;
            default:
                $client = Client::find($id);
                break;
        }

        if (!$client) {
            abort(403, 'Acesso não autorizado');
        }

        return view('admin.clients.show', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Auth::user()->hasPermissionTo('Editar Clientes')) {
            abort(403, 'Acesso não autorizado');
        }

        $role = Auth::user()->roles->first()->name;

        switch ($role) {
            case 'Colaborador':
            case 'Colaborador-NI':
                $collaborators = Auth::user()->collaborators->pluck('subsidiary_id');
                $subsidiaries = Subsidiary::whereIn('id', $collaborators)->get();
                $client = Client::where('trade_status', '!=', 'Restrito')->where(function ($query) {
                    $collaborators = Auth::user()->collaborators->pluck('subsidiary_id');
                    $query->whereIn('subsidiary_id', $collaborators)
                        ->orWhere('subsidiary_id', null);
                })->where('id', $id)->first();
                break;
            case 'Gerente':
                $managers = Auth::user()->managers->pluck('subsidiary_id');
                $subsidiaries = Subsidiary::whereIn('id', $managers)->get();
                $client = Client::where('trade_status', '!=', 'Restrito')->where(function ($query) {
                    $managers = Auth::user()->managers->pluck('subsidiary_id');
                    $query->whereIn('subsidiary_id', $managers)
                        ->orWhere('subsidiary_id', null);
                })->where('id', $id)->first();
                break;
            default:
                $subsidiaries = Subsidiary::all();
                $client = Client::find($id);
                break;
        }

        if (!$client) {
            abort(403, 'Acesso não autorizado');
        }

        $sellers = Seller::all();

        return view('admin.clients.edit', compact('client', 'subsidiaries', 'sellers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ClientRequest $request, $id)
    {
        if (!Auth::user()->hasPermissionTo('Editar Clientes')) {
            abort(403, 'Acesso não autorizado');
        }

        $data = $request->all();

        $role = Auth::user()->roles->first()->name;

        switch ($role) {
            case 'Colaborador':
            case 'Colaborador-NI':
                $collaborators = Auth::user()->collaborators->pluck('subsidiary_id');
                $subsidiary = Subsidiary::whereIn('id', $collaborators)->where('id', $data['subsidiary_id'])->first();
                $client = Client::where('trade_status', '!=', 'Restrito')->where(function ($query) {
                    $collaborators = Auth::user()->collaborators->pluck('subsidiary_id');
                    $query->whereIn('subsidiary_id', $collaborators)
                        ->orWhere('subsidiary_id', null);
                })->where('id', $id)->first();
                break;
            case 'Gerente':
                $managers = Auth::user()->managers->pluck('subsidiary_id');
                $subsidiary = Subsidiary::whereIn('id', $managers)->where('id', $data['subsidiary_id'])->first();
                $client = Client::where('trade_status', '!=', 'Restrito')->where(function ($query) {
                    $managers = Auth::user()->managers->pluck('subsidiary_id');
                    $query->whereIn('subsidiary_id', $managers)
                        ->orWhere('subsidiary_id', null);
                })->where('id', $id)->first();
                break;
            default:
                $subsidiary = Subsidiary::where('id', $data['subsidiary_id'])->first();
                $client = Client::find($id);
                break;
        }

        if (!$subsidiary) {
            abort(403, 'Acesso não autorizado');
        }

        if (!$client) {
            abort(403, 'Acesso não autorizado');
        }

        if ($request->observations) {
            $observations = $request->observations;
            $dom = new \DOMDocument();
            $dom->encoding = 'utf-8';
            $dom->loadHTML(utf8_decode($observations), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD | LIBXML_NOERROR | LIBXML_NOWARNING);
            $imageFile = $dom->getElementsByTagName('img');

            foreach ($imageFile as $item => $image) {
                $img = $image->getAttribute('src');
                if (filter_var($img, FILTER_VALIDATE_URL) == false) {
                    list($type, $img) = explode(';', $img);
                    list(, $img) = explode(',', $img);
                    $imageData = base64_decode($img);
                    $image_name =  Str::slug($request->title) . '-' . time() . $item . '.png';
                    $path = storage_path() . '/app/public/observations/' . $image_name;
                    file_put_contents($path, $imageData);
                    $image->removeAttribute('src');
                    $image->removeAttribute('data-filename');
                    $image->setAttribute('alt', $request->title);
                    $image->setAttribute('src', url('storage/observations/' . $image_name));
                }
            }

            $observations = $dom->saveHTML();
            $data['observations'] = $observations;
        }

        if ($request->file('attached_documents') != null) {
            $validator = Validator::make($request->only('attached_documents'), ['attached_documents.*' => 'file|mimes:pdf|max:125000']);

            if ($validator->fails() === true) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Todos os arquivos devem ser pdf com no máximo 1GB total');
            }

            $files = $request->file('attached_documents');

            foreach ($files as $file) {
                $clientFile = new ClientFile();
                $clientFile->client_id = $client->id;
                $path = Storage::putFile('clients/files', $file);
                $clientFile->file = $path;
                $clientFile->user_id = Auth::user()->id;
                $clientFile->save();
                unset($clientFile);
            }
        }

        if ($client->update($data)) {
            return redirect()
                ->route('admin.clients.index')
                ->with('success', 'Atualização realizada!');
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Erro ao atualizar!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Auth::user()->hasPermissionTo('Excluir Clientes')) {
            abort(403, 'Acesso não autorizado');
        }

        $role = Auth::user()->roles->first()->name;

        switch ($role) {
            case 'Colaborador':
            case 'Colaborador-NI':
                $client = Client::where('trade_status', '!=', 'Restrito')->where(function ($query) {
                    $collaborators = Auth::user()->collaborators->pluck('subsidiary_id');
                    $query->whereIn('subsidiary_id', $collaborators)
                        ->orWhere('subsidiary_id', null);
                })->where('id', $id)->first();
                break;
            case 'Gerente':
                $client = Client::where('trade_status', '!=', 'Restrito')->where(function ($query) {
                    $managers = Auth::user()->managers->pluck('subsidiary_id');
                    $query->whereIn('subsidiary_id', $managers)
                        ->orWhere('subsidiary_id', null);
                })->where('id', $id)->first();
                break;
            default:
                $client = Client::find($id);
                break;
        }

        if (!$client) {
            abort(403, 'Acesso não autorizado');
        }

        if ($client->delete()) {
            ClientFile::where('client_id', $client->id)->delete();
            return redirect()
                ->route('admin.clients.index')
                ->with('success', 'Exclusão realizada!');
        } else {
            return redirect()
                ->back()
                ->with('error', 'Erro ao excluir!');
        }
    }

    public function pdf($id)
    {
        if (!Auth::user()->hasPermissionTo('Acessar Clientes')) {
            abort(403, 'Acesso não autorizado');
        }

        $role = Auth::user()->roles->first()->name;

        switch ($role) {
            case 'Colaborador':
            case 'Colaborador-NI':
                $client = Client::where('trade_status', '!=', 'Restrito')->where(function ($query) {
                    $collaborators = Auth::user()->collaborators->pluck('subsidiary_id');
                    $query->whereIn('subsidiary_id', $collaborators)
                        ->orWhere('subsidiary_id', null);
                })->where('id', $id)->first();
                break;
            case 'Gerente':
                $client = Client::where('trade_status', '!=', 'Restrito')->where(function ($query) {
                    $managers = Auth::user()->managers->pluck('subsidiary_id');
                    $query->whereIn('subsidiary_id', $managers)
                        ->orWhere('subsidiary_id', null);
                })->where('id', $id)->first();
                break;
            default:
                $client = Client::find($id);
                break;
        }

        if (!$client) {
            abort(403, 'Acesso não autorizado');
        }

        return view('admin.clients.pdf', compact('client'));
    }

    public function fileImport(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('Criar Clientes')) {
            abort(403, 'Acesso não autorizado');
        }

        if (!$request->file()) {
            return redirect()
                ->back()
                ->with('error', 'Nenhum arquivo selecionado!');
        }

        Excel::import(new ClientImport, $request->file('file')->store('temp'));
        return back()->with('success', 'Importação realizada!');
    }

    public function timeline($id)
    {
        if (!Auth::user()->hasPermissionTo('Acessar Clientes')) {
            abort(403, 'Acesso não autorizado');
        }

        $role = Auth::user()->roles->first()->name;

        switch ($role) {
            case 'Colaborador':
            case 'Colaborador-NI':
                $client = Client::where('trade_status', '!=', 'Restrito')->where(function ($query) {
                    $collaborators = Auth::user()->collaborators->pluck('subsidiary_id');
                    $query->whereIn('subsidiary_id', $collaborators)
                        ->orWhere('subsidiary_id', null);
                })->where('id', $id)->first();
                break;
            case 'Gerente':
                $client = Client::where('trade_status', '!=', 'Restrito')->where(function ($query) {
                    $managers = Auth::user()->managers->pluck('subsidiary_id');
                    $query->whereIn('subsidiary_id', $managers)
                        ->orWhere('subsidiary_id', null);
                })->where('id', $id)->first();
                break;
            default:
                $client = Client::find($id);
                break;
        }

        if (!$client) {
            abort(403, 'Acesso não autorizado');
        }

        $histories = ClientHistory::where('client_id', $client->id)
            ->orderBy('created_at', 'desc')
            ->with('client')
            ->with('subsidiary')
            ->get();

        return view('admin.clients.history', compact('client', 'histories'));
    }

    public function fileDelete(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('Editar Clientes')) {
            abort(403, 'Acesso não autorizado');
        }

        $file = ClientFile::find($request->id);
        if ($file) {
            $file->delete();
            return response()->json(['message' => 'success']);
        } else {
            return response()->json(['message' => 'fail']);
        }
    }
}
