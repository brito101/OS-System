<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ClientRequest;
use App\Models\Client;
use App\Models\Views\Client as ViewsClient;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Auth;
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

        $clients = ViewsClient::all();

        if ($request->ajax()) {
            return Datatables::of($clients)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-xs btn-primary mx-1 shadow" title="Editar" href="clients/' . $row->id . '/edit"><i class="fa fa-lg fa-fw fa-pen"></i></a>' . '<a class="btn btn-xs btn-danger mx-1 shadow" title="Excluir" href="clients/destroy/' . $row->id . '" onclick="return confirm(\'Confirma a exclusão deste cliente?\')"><i class="fa fa-lg fa-fw fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
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

        return view('admin.clients.create');
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

        $observations = $request->observations;
        $dom = new \DOMDocument();
        $dom->loadHTML($observations, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD | LIBXML_NOERROR | LIBXML_NOWARNING);
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

        $client = Client::create($data);

        if ($client->save()) {
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

        $client = Client::find($id);

        if (!$client) {
            abort(403, 'Acesso não autorizado');
        }

        return view('admin.clients.edit', compact('client'));
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

        $client = Client::find($id);

        if (!$client) {
            abort(403, 'Acesso não autorizado');
        }

        $data = $request->all();

        $observations = $request->observations;
        $dom = new \DOMDocument();
        $dom->loadHTML($observations, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD | LIBXML_NOERROR | LIBXML_NOWARNING);
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

        $client = Client::find($id);

        if (!$client) {
            abort(403, 'Acesso não autorizado');
        }

        if ($client->delete()) {
            return redirect()
                ->route('admin.clients.index')
                ->with('success', 'Exclusão realizada!');
        } else {
            return redirect()
                ->back()
                ->with('error', 'Erro ao excluir!');
        }
    }
}
