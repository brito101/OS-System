<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProviderRequest;
use App\Imports\ProviderImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Provider;
use App\Models\Views\Provider as ViewsProvider;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('Listar Fornecedores')) {
            abort(403, 'Acesso não autorizado');
        }

        $providers = ViewsProvider::all();

        if (Auth::user()->hasRole(['Gerente'])) {
            if ($request->ajax()) {
                return Datatables::of($providers)
                    ->addIndexColumn()
                    ->orderColumn('alias_name')
                    ->addColumn('action', function ($row) {
                        $btn = '<a class="btn btn-xs btn-success mx-1 shadow" title="Visualizar" href="providers/' . $row->id . '/show"><i class="fa fa-lg fa-fw fa-eye"></i></a>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
        } else {
            if ($request->ajax()) {
                return Datatables::of($providers)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $btn = '<a class="btn btn-xs btn-success mx-1 shadow" title="Visualizar" href="providers/' . $row->id . '"><i class="fa fa-lg fa-fw fa-eye"></i></a>' . '<a class="btn btn-xs btn-primary mx-1 shadow" title="Editar" href="providers/' . $row->id . '/edit"><i class="fa fa-lg fa-fw fa-pen"></i></a>' . '<a class="btn btn-xs btn-danger mx-1 shadow" title="Excluir" href="providers/destroy/' . $row->id . '" onclick="return confirm(\'Confirma a exclusão deste fornecedor?\')"><i class="fa fa-lg fa-fw fa-trash"></i></a>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
        }

        return view('admin.providers.index');
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

        return view('admin.providers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProviderRequest $request)
    {
        if (!Auth::user()->hasPermissionTo('Criar Fornecedores')) {
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

        $provider = Provider::create($data);

        if ($provider->save()) {
            return redirect()
                ->route('admin.providers.index')
                ->with('success', 'Cadastro realizado!');
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Erro ao cadastrar!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!Auth::user()->hasPermissionTo('Acessar Fornecedores')) {
            abort(403, 'Acesso não autorizado');
        }

        $provider = Provider::find($id);

        if (!$provider) {
            abort(403, 'Acesso não autorizado');
        }

        return view('admin.providers.show', compact('provider'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Auth::user()->hasPermissionTo('Editar Fornecedores')) {
            abort(403, 'Acesso não autorizado');
        }

        $provider = Provider::find($id);

        if (!$provider) {
            abort(403, 'Acesso não autorizado');
        }

        return view('admin.providers.edit', compact('provider'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProviderRequest $request, $id)
    {
        if (!Auth::user()->hasPermissionTo('Editar Fornecedores')) {
            abort(403, 'Acesso não autorizado');
        }

        $provider = Provider::find($id);

        if (!$provider) {
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

        if ($provider->update($data)) {
            return redirect()
                ->route('admin.providers.index')
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
        if (!Auth::user()->hasPermissionTo('Excluir Fornecedores')) {
            abort(403, 'Acesso não autorizado');
        }

        $provider = Provider::find($id);

        if (!$provider) {
            abort(403, 'Acesso não autorizado');
        }

        if ($provider->delete()) {
            return redirect()
                ->route('admin.providers.index')
                ->with('success', 'Exclusão realizada!');
        } else {
            return redirect()
                ->back()
                ->with('error', 'Erro ao excluir!');
        }
    }

    public function pdf($id)
    {
        if (!Auth::user()->hasPermissionTo('Acessar Fornecedores')) {
            abort(403, 'Acesso não autorizado');
        }

        $provider = Provider::find($id);

        if (!$provider) {
            abort(403, 'Acesso não autorizado');
        }

        return view('admin.providers.pdf', compact('provider'));
    }

    public function fileImport(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('Criar Fornecedores')) {
            abort(403, 'Acesso não autorizado');
        }

        if (!$request->file()) {
            return redirect()
                ->back()
                ->with('error', 'Nenhum arquivo selecionado!');
        }

        Excel::import(new ProviderImport, $request->file('file')->store('temp'));
        return back()->with('success', 'Importação realizada!');
    }
}
