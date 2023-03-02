<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Imports\ProductImport;
use App\Models\Product;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('Listar Produtos')) {
            abort(403, 'Acesso não autorizado');
        }

        $products = Product::query();

        if ($request->ajax()) {
            return Datatables::of($products)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-xs btn-primary mx-1 shadow" title="Editar" href="products/' . $row->id . '/edit"><i class="fa fa-lg fa-fw fa-pen"></i></a>' . '<a class="btn btn-xs btn-danger mx-1 shadow" title="Excluir" href="products/destroy/' . $row->id . '" onclick="return confirm(\'Confirma a exclusão deste produto?\')"><i class="fa fa-lg fa-fw fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.products.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->hasPermissionTo('Criar Produtos')) {
            abort(403, 'Acesso não autorizado');
        }

        return view('admin.products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        if (!Auth::user()->hasPermissionTo('Criar Produtos')) {
            abort(403, 'Acesso não autorizado');
        }

        $data = $request->all();
        $data['user_id'] = Auth::user()->id;

        $product = Product::create($data);

        if ($product->save()) {
            return redirect()
                ->route('admin.products.index')
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
        if (!Auth::user()->hasPermissionTo('Editar Produtos')) {
            abort(403, 'Acesso não autorizado');
        }

        $product = Product::find($id);

        if (!$product) {
            abort(403, 'Acesso não autorizado');
        }

        return view('admin.products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {
        if (!Auth::user()->hasPermissionTo('Editar Produtos')) {
            abort(403, 'Acesso não autorizado');
        }

        $data = $request->all();
        $data['user_id'] = Auth::user()->id;

        $product = Product::find($id);

        if (!$product) {
            abort(403, 'Acesso não autorizado');
        }

        if ($product->update($data)) {
            return redirect()
                ->route('admin.products.index')
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
        if (!Auth::user()->hasPermissionTo('Excluir Produtos')) {
            abort(403, 'Acesso não autorizado');
        }

        $product = Product::find($id);

        if (!$product) {
            abort(403, 'Acesso não autorizado');
        }

        if ($product->delete()) {
            return redirect()
                ->route('admin.products.index')
                ->with('success', 'Exclusão realizada!');
        } else {
            return redirect()
                ->back()
                ->with('error', 'Erro ao excluir!');
        }
    }

    public function fileImport(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('Criar Produtos')) {
            abort(403, 'Acesso não autorizado');
        }

        if (!$request->file()) {
            return redirect()
                ->back()
                ->with('error', 'Nenhum arquivo selecionado!');
        }

        Excel::import(new ProductImport, $request->file('file')->store('temp'));
        return back()->with('success', 'Importação realizada!');
    }
}
