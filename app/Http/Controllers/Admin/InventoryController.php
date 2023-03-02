<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\InventoryRequest;
use App\Models\Inventory;
use App\Models\Manager;
use App\Models\Product;
use App\Models\Provider;
use App\Models\Subsidiary;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
                $stocks = Inventory::whereIn('subsidiary_id', $subsidiaries)->orWhere('subsidiary_id', null)->get();
                break;
            default:
                $stocks = Inventory::get();
                break;
        }

        if ($request->ajax()) {
            return Datatables::of($stocks)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-xs btn-success mx-1 shadow" title="Visualizar" href="stocks/' . $row->id . '"><i class="fa fa-lg fa-fw fa-eye"></i></a>' . '<a class="btn btn-xs btn-primary mx-1 shadow" title="Editar" href="stocks/' . $row->id . '/edit"><i class="fa fa-lg fa-fw fa-pen"></i></a>' . '<a class="btn btn-xs btn-danger mx-1 shadow" title="Excluir" href="stocks/destroy/' . $row->id . '" onclick="return confirm(\'Confirma a exclusão desta movimentação?\')"><i class="fa fa-lg fa-fw fa-trash"></i></a>';
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

        $products = Product::all('id', 'name');
        $providers = Provider::all('id', 'alias_name');

        return view('admin.stocks.create', \compact('products', 'subsidiaries', 'providers'));
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

    public function show($id)
    {
        if (!Auth::user()->hasPermissionTo('Listar Movimentações')) {
            abort(403, 'Acesso não autorizado');
        }

        $stock = Inventory::find($id);

        if (!$stock) {
            abort(403, 'Acesso não autorizado');
        }

        return view('admin.stocks.show', compact('stock'));
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
                $stock = Inventory::where(function ($query) use ($managers) {
                    $query->whereIn('subsidiary_id', $managers)->orWhere('subsidiary_id', null);
                })->where('id', $id)->first();
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

        $products = Product::all('id', 'name');
        $providers = Provider::all('id', 'alias_name');

        return view('admin.stocks.edit', compact('stock', 'subsidiaries', 'products', 'providers'));
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
                $stock = Inventory::where(function ($query) use ($subsidiaries) {
                    $query->whereIn('subsidiary_id', $subsidiaries)->orWhere('subsidiary_id', null);
                })->where('id', $id)->first();
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
                $stock = Inventory::where(function ($query) use ($subsidiaries) {
                    $query->whereIn('subsidiary_id', $subsidiaries)->orWhere('subsidiary_id', null);
                })->where('id', $id)->first();
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

    public function pdf($id)
    {
        if (!Auth::user()->hasPermissionTo('Listar Movimentações')) {
            abort(403, 'Acesso não autorizado');
        }

        $stock = Inventory::find($id);

        if (!$stock) {
            abort(403, 'Acesso não autorizado');
        }

        return view('admin.stocks.pdf', compact('stock'));
    }

    public function consolidated(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('Listar Movimentações')) {
            abort(403, 'Acesso não autorizado');
        }

        $year = date('Y');
        if (isset($request->year)) {
            $year = $request->year;
        }

        $products = Product::select('id', 'name')->orderBy('name')->get();
        $stocks = [];
        foreach ($products as $product) {
            $items = [];
            for ($i = 1; $i <= 12; $i++) {
                $inventories = Inventory::select(DB::raw('sum(input - output) as total'))
                    ->where('product_id', $product->id)
                    ->whereMonth('day', $i)
                    ->whereYear('day', $year)
                    ->first();

                $items[$i] = $inventories->total ?? 0;
            }
            $stocks[] = [
                'product' => $product->name,
                'months' => $items
            ];
        }

        return view('admin.stocks.consolidated', compact('stocks', 'year'));
    }
}
