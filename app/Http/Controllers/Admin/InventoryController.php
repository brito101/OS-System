<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\InventoryRequest;
use App\Models\Inventory;
use App\Models\Manager;
use App\Models\Product;
use App\Models\Subsidiary;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('Listar Movimentações')) {
            abort(403, 'Acesso não autorizado');
        }

        $role = Auth::user()->roles->first()->name;

        switch ($role) {
            case 'Gerente':
                $subsidiaries = Manager::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                $stocks = Inventory::whereIn('subsidiary_id', $subsidiaries)->get();
                break;
            default:
                $stocks = Inventory::get();
                break;
        }

        if ($request->ajax()) {
            return Datatables::of($stocks)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-xs btn-primary mx-1 shadow" title="Editar" href="stocks/' . $row->id . '/edit"><i class="fa fa-lg fa-fw fa-pen"></i></a>' . '<a class="btn btn-xs btn-danger mx-1 shadow" title="Excluir" href="stocks/destroy/' . $row->id . '" onclick="return confirm(\'Confirma a exclusão desta movimentação?\')"><i class="fa fa-lg fa-fw fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.stocks.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->hasPermissionTo('Criar Movimentações')) {
            abort(403, 'Acesso não autorizado');
        }

        $role = Auth::user()->roles->first()->name;

        switch ($role) {
            case 'Gerente':
                $managers = Auth::user()->managers->pluck('subsidiary_id');
                $subsidiaries = Subsidiary::whereIn('id', $managers)->get();
                break;
            default:
                $subsidiaries = Subsidiary::select('id', 'alias_name')->get();
                break;
        }

        $products = Product::select('id', 'name')->get();

        return view('admin.stocks.create', \compact('products', 'subsidiaries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InventoryRequest $request)
    {
        if (!Auth::user()->hasPermissionTo('Criar Movimentações')) {
            abort(403, 'Acesso não autorizado');
        }

        $data = $request->all();

        $data['user_id'] = Auth::user()->id;

        $stock = Inventory::create($data);

        if ($stock->save()) {
            return redirect()
                ->route('admin.stocks.index')
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
        if (!Auth::user()->hasPermissionTo('Editar Movimentações')) {
            abort(403, 'Acesso não autorizado');
        }

        $role = Auth::user()->roles->first()->name;

        switch ($role) {
            case 'Gerente':
                $managers = Manager::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                $stock = Inventory::whereIn('subsidiary_id', $managers)->where('id', $id)->first();
                $subsidiaries = Subsidiary::whereIn('id', $managers)->get();
                break;
            default:
                $stock = Inventory::find($id);
                $subsidiaries = Subsidiary::select('id', 'alias_name')->get();
                break;
        }


        if (!$stock) {
            abort(403, 'Acesso não autorizado');
        }

        $products = Product::select('id', 'name')->get();

        return view('admin.stocks.edit', compact('stock', 'subsidiaries', 'products'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(InventoryRequest $request, $id)
    {
        if (!Auth::user()->hasPermissionTo('Editar Movimentações')) {
            abort(403, 'Acesso não autorizado');
        }

        $data = $request->all();
        $data['user_id'] = Auth::user()->id;

        $role = Auth::user()->roles->first()->name;

        switch ($role) {
            case 'Gerente':
                $subsidiaries = Manager::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                $stock = Inventory::whereIn('subsidiary_id', $subsidiaries)->where('id', $id)->first();
                break;
            default:
                $stock = Inventory::find($id);
                break;
        }

        if (!$stock) {
            abort(403, 'Acesso não autorizado');
        }

        if ($stock->update($data)) {
            return redirect()
                ->route('admin.stocks.index')
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
        if (!Auth::user()->hasPermissionTo('Excluir Movimentações')) {
            abort(403, 'Acesso não autorizado');
        }

        $role = Auth::user()->roles->first()->name;

        switch ($role) {
            case 'Gerente':
                $subsidiaries = Manager::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                $stock = Inventory::whereIn('subsidiary_id', $subsidiaries)->where('id', $id)->first();
                break;
            default:
                $stock = Inventory::find($id);
                break;
        }

        if (!$stock) {
            abort(403, 'Acesso não autorizado');
        }

        if ($stock->delete()) {
            return redirect()
                ->route('admin.stocks.index')
                ->with('success', 'Exclusão realizada!');
        } else {
            return redirect()
                ->back()
                ->with('error', 'Erro ao excluir!');
        }
    }
}
