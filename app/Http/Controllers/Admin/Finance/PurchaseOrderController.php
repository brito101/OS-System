<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PurchaseOrderRequest;
use App\Models\Manager;
use App\Models\Material;
use App\Models\Provider;
use App\Models\PurchaseOrder;
use App\Models\Subsidiary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use DataTables;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('Listar Ordens de Compra')) {
            abort(403, 'Acesso não autorizado');
        }

        $role = Auth::user()->roles->first()->name;

        switch ($role) {
            case 'Colaborador':
            case 'Financeiro':
                $purchases = PurchaseOrder::where('user_id', Auth::user()->id)->get();
                break;
            case 'Gerente':
                $subsidiaries = Manager::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                $purchases = PurchaseOrder::whereIn('subsidiary_id', $subsidiaries)->orWhere('subsidiary_id', null)->get();
                break;
            default:
                $purchases = PurchaseOrder::all();
                break;
        }

        if ($request->ajax()) {
            return Datatables::of($purchases)
                ->addIndexColumn()
                ->addColumn('btnStatus', function ($row) {
                    $executedLink = '';
                    if ($row->status == 'executada') {
                        $executedLink = '<a class="btn btn-xs btn-success mx-1 shadow" title="Alterar para não executada" href="finance-purchase-orders/unexecuted/' . $row->id . '"><i class="fa fa-lg fa-fw fa-thumbs-up"></i></a>';
                    }
                    if ($row->status == 'não executada') {
                        $executedLink = '<a class="btn btn-xs btn-danger mx-1 shadow" title="Alterar para executada" href="finance-purchase-orders/executed/' . $row->id . '"><i class="fa fa-lg fa-fw fa-thumbs-down"></i></a>';
                    }
                    return $executedLink;
                })
                ->addColumn('action', function ($row) {
                    $fileLink = '';
                    if ($row->file) {
                        $fileLink = '<a class="btn btn-xs btn-secondary mx-1 shadow" title="Anexo" download="anexo" href="' .  Storage::url($row->file)  . '"><i class="fa fa-lg fa-fw fa-download"></i></a>';
                    }
                    $btn = $fileLink . '<a class="btn btn-xs btn-success mx-1 shadow" title="Visualizar" href="finance-purchase-orders/' . $row->id . '"><i class="fa fa-lg fa-fw fa-eye"></i></a>' . '<a class="btn btn-xs btn-primary mx-1 shadow" title="Editar" href="finance-purchase-orders/' . $row->id . '/edit"><i class="fa fa-lg fa-fw fa-pen"></i></a>' . '<a class="btn btn-xs btn-danger mx-1 shadow" title="Excluir" href="finance-purchase-orders/destroy/' . $row->id . '" onclick="return confirm(\'Confirma a exclusão deste lançamento?\')"><i class="fa fa-lg fa-fw fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['btnStatus', 'action'])
                ->make(true);
        }

        return view('admin.finance.purchase_order.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->hasPermissionTo('Criar Ordens de Compra')) {
            abort(403, 'Acesso não autorizado');
        }

        $role = Auth::user()->roles->first()->name;

        switch ($role) {
            case 'Colaborador':
            case 'Financeiro':
                $collaborators = Auth::user()->collaborators->pluck('subsidiary_id');
                $subsidiaries = Subsidiary::whereIn('id', $collaborators)->get();
                $states = array_unique($subsidiaries->pluck('state')->toArray());
                sort($states);
                $statesSearch = implode(',', $states);
                $providers = Provider::where('coverage', 'like', '%' . $statesSearch . '%')->orWhere('coverage', null)->get();
                break;
            case 'Gerente':
                $managers = Auth::user()->managers->pluck('subsidiary_id');
                $subsidiaries = Subsidiary::whereIn('id', $managers)->get();
                $states = array_unique($subsidiaries->pluck('state')->toArray());
                sort($states);
                $statesSearch = implode(',', $states);
                $providers = Provider::where('coverage', 'like', '%' . $statesSearch . '%')->orWhere('coverage', null)->get();
                break;
            default:
                $subsidiaries = Subsidiary::all();
                $providers = Provider::all();
                break;
        }

        return view('admin.finance.purchase_order.create', compact('subsidiaries', 'providers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PurchaseOrderRequest $request)
    {
        if (!Auth::user()->hasPermissionTo('Criar Ordens de Compra')) {
            abort(403, 'Acesso não autorizado');
        }

        $subsidiary = Subsidiary::where('id', $request->subsidiary_id)->first();
        if (!$subsidiary) {
            abort(403, 'Acesso não autorizado');
        }

        $data = $request->all();
        $materials = [];
        foreach ($data as $key => $value) {
            if (preg_match("/material_(\d)/", $key)) {
                if (strlen($value) > 0) {
                    $materials[$key] = Str::limit($value, 191);
                }
            }
        }

        $data['user_id'] = Auth::user()->id;

        $purchaseOrders = PurchaseOrder::whereYear('created_at', date('Y'))->count();
        $data['number_series'] = $purchaseOrders + 1 . '/' . date('Y');

        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $path = $request->file('file')->store('finance/purchase');
            $data['file'] = $path;
        }

        $purchase = PurchaseOrder::create($data);

        if ($purchase->save()) {
            foreach ($materials as $material) {
                $item = new Material();
                $item->description = $material;
                $item->user_id = Auth::user()->id;
                $item->purchase_orders_id = $purchase->id;
                $item->save();
            }

            return redirect()
                ->route('admin.finance-purchase-orders.index')
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
        if (!Auth::user()->hasPermissionTo('Listar Ordens de Compra')) {
            abort(403, 'Acesso não autorizado');
        }

        $role = Auth::user()->roles->first()->name;

        switch ($role) {
            case 'Colaborador':
            case 'Financeiro':
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

        $purchase = PurchaseOrder::where('id', $id)->whereIn('subsidiary_id', $subsidiaries->pluck('id'))->first();

        if (!$purchase) {
            abort(403, 'Acesso não autorizado');
        }

        $materials = Material::select('description')->where('purchase_orders_id', $purchase->id)->get();

        return view('admin.finance.purchase_order.show', compact('purchase', 'materials'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Auth::user()->hasPermissionTo('Editar Ordens de Compra')) {
            abort(403, 'Acesso não autorizado');
        }

        $role = Auth::user()->roles->first()->name;

        switch ($role) {
            case 'Colaborador':
            case 'Financeiro':
                $collaborators = Auth::user()->collaborators->pluck('subsidiary_id');
                $subsidiaries = Subsidiary::whereIn('id', $collaborators)->get();
                $states = array_unique($subsidiaries->pluck('state')->toArray());
                sort($states);
                $statesSearch = implode(',', $states);
                $providers = Provider::where('coverage', 'like', '%' . $statesSearch . '%')->orWhere('coverage', null)->get();
                break;
            case 'Gerente':
                $managers = Auth::user()->managers->pluck('subsidiary_id');
                $subsidiaries = Subsidiary::whereIn('id', $managers)->get();
                $states = array_unique($subsidiaries->pluck('state')->toArray());
                sort($states);
                $statesSearch = implode(',', $states);
                $providers = Provider::where('coverage', 'like', '%' . $statesSearch . '%')->orWhere('coverage', null)->get();
                break;
            default:
                $subsidiaries = Subsidiary::all();
                $providers = Provider::all();
                break;
        }

        $purchase = PurchaseOrder::where('id', $id)->whereIn('subsidiary_id', $subsidiaries->pluck('id'))->first();

        if (!$purchase) {
            abort(403, 'Acesso não autorizado');
        }

        $materials = Material::select('description')->where('purchase_orders_id', $purchase->id)->get();

        return view('admin.finance.purchase_order.edit', compact('subsidiaries', 'purchase', 'materials', 'providers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PurchaseOrderRequest $request, $id)
    {
        if (!Auth::user()->hasPermissionTo('Editar Ordens de Compra')) {
            abort(403, 'Acesso não autorizado');
        }

        $role = Auth::user()->roles->first()->name;

        switch ($role) {
            case 'Colaborador':
            case 'Financeiro':
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

        $purchase = PurchaseOrder::where('id', $id)->whereIn('subsidiary_id', $subsidiaries->pluck('id'))->first();

        if (!$purchase) {
            abort(403, 'Acesso não autorizado');
        }

        $data = $request->all();
        $materials = [];
        foreach ($data as $key => $value) {
            if (preg_match("/material_(\d)/", $key)) {
                if (strlen($value) > 0) {
                    $materials[$key] = Str::limit($value, 191);
                }
            }
        }

        if ($request->input('remove_file') == 'sim') {
            $data['file'] = null;
        }

        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $path = $request->file('file')->store('finance/purchase');
            $data['file'] = $path;
        }

        if ($purchase->update($data)) {

            $purchase->material->each->delete();

            foreach ($materials as $material) {
                $item = new Material();
                $item->description = $material;
                $item->user_id = Auth::user()->id;
                $item->purchase_orders_id = $purchase->id;
                $item->save();
            }

            return redirect()
                ->route('admin.finance-purchase-orders.index')
                ->with('success', 'Atualização realizada!');
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Erro ao cadastrar!');
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
        if (!Auth::user()->hasPermissionTo('Excluir Reembolsos')) {
            abort(403, 'Acesso não autorizado');
        }

        $role = Auth::user()->roles->first()->name;

        switch ($role) {
            case 'Colaborador':
            case 'Financeiro':
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

        $purchase = PurchaseOrder::where('id', $id)->whereIn('subsidiary_id', $subsidiaries->pluck('id'))->first();

        if (!$purchase) {
            abort(403, 'Acesso não autorizado');
        }

        if ($purchase->delete()) {
            return redirect()
                ->route('admin.finance-purchase-orders.index')
                ->with('success', 'Exclusão realizada!');
        } else {
            return redirect()
                ->back()
                ->with('error', 'Erro ao excluir!');
        }
    }

    public function executed($id)
    {
        if (!Auth::user()->hasPermissionTo('Editar Ordens de Compra')) {
            abort(403, 'Acesso não autorizado');
        }

        $role = Auth::user()->roles->first()->name;

        switch ($role) {
            case 'Colaborador':
            case 'Financeiro':
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

        $purchase = PurchaseOrder::where('id', $id)->whereIn('subsidiary_id', $subsidiaries->pluck('id'))->first();

        if (!$purchase) {
            abort(403, 'Acesso não autorizado');
        }

        $purchase->status = 'executada';

        if ($purchase->update()) {
            return redirect()
                ->route('admin.finance-purchase-orders.index')
                ->with('success', 'Ordem de compra marcada como executada!');
        } else {
            return redirect()
                ->back()
                ->with('error', 'Erro ao excluir!');
        }
    }

    public function unexecuted($id)
    {
        if (!Auth::user()->hasPermissionTo('Editar Ordens de Compra')) {
            abort(403, 'Acesso não autorizado');
        }

        $role = Auth::user()->roles->first()->name;

        switch ($role) {
            case 'Colaborador':
            case 'Financeiro':
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

        $purchase = PurchaseOrder::where('id', $id)->whereIn('subsidiary_id', $subsidiaries->pluck('id'))->first();

        if (!$purchase) {
            abort(403, 'Acesso não autorizado');
        }

        $purchase->status = 'não executada';

        if ($purchase->update()) {
            return redirect()
                ->route('admin.finance-purchase-orders.index')
                ->with('success', 'Ordem de compra marcada como não executada!');
        } else {
            return redirect()
                ->back()
                ->with('error', 'Erro ao excluir!');
        }
    }

    public function pdf($id)
    {
        if (!Auth::user()->hasPermissionTo('Listar Ordens de Compra')) {
            abort(403, 'Acesso não autorizado');
        }

        $role = Auth::user()->roles->first()->name;

        switch ($role) {
            case 'Colaborador':
            case 'Financeiro':
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

        $purchase = PurchaseOrder::where('id', $id)->whereIn('subsidiary_id', $subsidiaries->pluck('id'))->first();

        if (!$purchase) {
            abort(403, 'Acesso não autorizado');
        }

        $materials = Material::select('description')->where('purchase_orders_id', $purchase->id)->get();

        return view('admin.finance.purchase_order.pdf', compact('purchase', 'materials'));
    }
}