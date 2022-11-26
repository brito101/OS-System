<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CommissionRequest;
use App\Models\Commission;
use App\Models\Financier;
use App\Models\Manager;
use App\Models\Seller;
use App\Models\Subsidiary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DataTables;

class CommissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('Listar Comissões')) {
            abort(403, 'Acesso não autorizado');
        }

        $role = Auth::user()->roles->first()->name;

        switch ($role) {
            case 'Financeiro':
                $subsidiaries = Financier::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                $commissions = Commission::whereIn('subsidiary_id', $subsidiaries)->get();
                break;
            case 'Gerente':
                $subsidiaries = Manager::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                $commissions = Commission::whereIn('subsidiary_id', $subsidiaries)->get();
                break;
            default:
                $commissions = Commission::all();
                break;
        }

        $sellers = Seller::orderBy('name')->get();

        $payValue = Commission::where('status', 'pago')->whereIn('id', $commissions->pluck('id'))->sum('total_value');
        $pay = 'R$ ' . \number_format($payValue, 2, ',', '.');

        $receiveValue = Commission::where('status', 'pendente')->whereIn('id', $commissions->pluck('id'))->sum('total_value');
        $receive = 'R$ ' . \number_format($receiveValue, 2, ',', '.');

        $balance = 'R$ ' . \number_format($payValue - $receiveValue, 2, ',', '.');

        if ($request->ajax()) {
            return Datatables::of($commissions)
                ->addIndexColumn()
                ->addColumn('btnStatus', function ($row) {
                    $payLink = '';
                    if ($row->status == 'pendente') {
                        $payLink = '<a class="btn btn-xs btn-danger mx-1 shadow" title="Alterar para pago" href="commissions/pay/' . $row->id . '"><i class="fa fa-lg fa-fw fa-thumbs-down"></i></a>';
                    }
                    if ($row->status == 'pago') {
                        $payLink = '<a class="btn btn-xs btn-success mx-1 shadow" title="Alterar para pendente" href="commissions/receive/' . $row->id . '"><i class="fa fa-lg fa-fw fa-thumbs-up"></i></a>';
                    }
                    return $payLink;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-xs btn-success mx-1 shadow" title="Visualizar" href="commissions/' . $row->id . '"><i class="fa fa-lg fa-fw fa-eye"></i></a>' . '<a class="btn btn-xs btn-primary mx-1 shadow" title="Editar" href="commissions/' . $row->id . '/edit"><i class="fa fa-lg fa-fw fa-pen"></i></a>' . '<a class="btn btn-xs btn-danger mx-1 shadow" title="Excluir" href="commissions/destroy/' . $row->id . '" onclick="return confirm(\'Confirma a exclusão desta comissão?\')"><i class="fa fa-lg fa-fw fa-trash"></i></a>' . '<a class="btn btn-xs btn-success mx-1 shadow" title="Recibo" href="' . route('admin.commissions.receipt', ['id' => $row->id]) . '" target="_blank"><i class="fa fa-lg fa-fw fa-file-invoice-dollar"></i></a>';
                    return $btn;
                })
                ->rawColumns(['btnStatus', 'action'])
                ->make(true);
        }

        return view('admin.commissions.index', compact('pay', 'receive', 'balance', 'sellers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->hasPermissionTo('Criar Comissões')) {
            abort(403, 'Acesso não autorizado');
        }

        $role = Auth::user()->roles->first()->name;

        switch ($role) {
            case 'Financeiro':
                $financiers = Financier::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                $subsidiaries = Subsidiary::whereIn('id', $financiers)->get();
                break;
            case 'Gerente':
                $managers = Manager::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                $subsidiaries = Subsidiary::whereIn('id', $managers)->get();
                break;
            default:
                $subsidiaries = Subsidiary::all();
                break;
        }

        $sellers = Seller::all();

        return view('admin.commissions.create', compact('subsidiaries', 'sellers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CommissionRequest $request)
    {
        if (!Auth::user()->hasPermissionTo('Criar Comissões')) {
            abort(403, 'Acesso não autorizado');
        }

        $data = $request->all();

        $data['user_id'] = Auth::user()->id;

        $commission = Commission::create($data);

        if ($commission->save()) {
            return redirect()
                ->route('admin.commissions.index')
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
        if (!Auth::user()->hasPermissionTo('Listar Comissões')) {
            abort(403, 'Acesso não autorizado');
        }

        $role = Auth::user()->roles->first()->name;

        switch ($role) {
            case 'Financeiro':
                $financiers = Financier::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                $subsidiaries = Subsidiary::whereIn('id', $financiers)->get();
                break;
            case 'Gerente':
                $managers = Manager::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                $subsidiaries = Subsidiary::whereIn('id', $managers)->get();
                break;
            default:
                $subsidiaries = Subsidiary::all();
                break;
        }

        $commission = Commission::where('id', $id)->whereIn('subsidiary_id', $subsidiaries->pluck('id'))->first();

        if (!$commission) {
            abort(403, 'Acesso não autorizado');
        }

        return view('admin.commissions.show', compact('commission'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Auth::user()->hasPermissionTo('Editar Comissões')) {
            abort(403, 'Acesso não autorizado');
        }

        $role = Auth::user()->roles->first()->name;

        switch ($role) {
            case 'Financeiro':
                $financiers = Financier::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                $subsidiaries = Subsidiary::whereIn('id', $financiers)->get();
                break;
            case 'Gerente':
                $managers = Manager::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                $subsidiaries = Subsidiary::whereIn('id', $managers)->get();
                break;
            default:
                $subsidiaries = Subsidiary::all();
                break;
        }

        $commission = Commission::where('id', $id)->whereIn('subsidiary_id', $subsidiaries->pluck('id'))->first();

        if (!$commission) {
            abort(403, 'Acesso não autorizado');
        }

        $sellers = Seller::all();

        return view('admin.commissions.edit', compact('commission', 'subsidiaries', 'sellers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CommissionRequest $request, $id)
    {
        if (!Auth::user()->hasPermissionTo('Editar Comissões')) {
            abort(403, 'Acesso não autorizado');
        }


        $commission = Commission::find($id);

        if (!$commission) {
            abort(403, 'Acesso não autorizado');
        }

        $data = $request->all();

        if ($commission->update($data)) {
            return redirect()
                ->route('admin.commissions.index')
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
        if (!Auth::user()->hasPermissionTo('Excluir Comissões')) {
            abort(403, 'Acesso não autorizado');
        }

        $commission = Commission::find($id);

        if (!$commission) {
            abort(403, 'Acesso não autorizado');
        }
        if ($commission->delete()) {
            return redirect()
                ->route('admin.commissions.index')
                ->with('success', 'Exclusão realizada!');
        } else {
            return redirect()
                ->back()
                ->with('error', 'Erro ao excluir!');
        }
    }

    public function pay($id)
    {
        if (!Auth::user()->hasPermissionTo('Editar Comissões')) {
            abort(403, 'Acesso não autorizado');
        }

        $role = Auth::user()->roles->first()->name;

        switch ($role) {
            case 'Financeiro':
                $financiers = Financier::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                $subsidiaries = Subsidiary::whereIn('id', $financiers)->get();
                break;
            case 'Gerente':
                $managers = Manager::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                $subsidiaries = Subsidiary::whereIn('id', $managers)->get();
                break;
            default:
                $subsidiaries = Subsidiary::all();
                break;
        }

        $commission = Commission::where('id', $id)->whereIn('subsidiary_id', $subsidiaries->pluck('id'))->first();

        if (!$commission) {
            abort(403, 'Acesso não autorizado');
        }

        $commission->status = 'pago';

        if ($commission->update()) {
            return redirect()
                ->route('admin.commissions.index')
                ->with('success', 'Comissão marcada como paga!');
        } else {
            return redirect()
                ->back()
                ->with('error', 'Erro ao atualizar!');
        }
    }

    public function receive($id)
    {
        if (!Auth::user()->hasPermissionTo('Editar Comissões')) {
            abort(403, 'Acesso não autorizado');
        }

        $role = Auth::user()->roles->first()->name;

        switch ($role) {
            case 'Financeiro':
                $financiers = Financier::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                $subsidiaries = Subsidiary::whereIn('id', $financiers)->get();
                break;
            case 'Gerente':
                $managers = Financier::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                $subsidiaries = Subsidiary::whereIn('id', $managers)->get();
                break;
            default:
                $subsidiaries = Subsidiary::all();
                break;
        }

        $commission = Commission::where('id', $id)->whereIn('subsidiary_id', $subsidiaries->pluck('id'))->first();

        if (!$commission) {
            abort(403, 'Acesso não autorizado');
        }

        $commission->status = 'pendente';

        if ($commission->update()) {
            return redirect()
                ->route('admin.commissions.index')
                ->with('success', 'Comissão marcada como pendente!');
        } else {
            return redirect()
                ->back()
                ->with('error', 'Erro ao atualizar!');
        }
    }

    public function pdf($id)
    {
        if (!Auth::user()->hasPermissionTo('Listar Comissões')) {
            abort(403, 'Acesso não autorizado');
        }

        $role = Auth::user()->roles->first()->name;

        switch ($role) {
            case 'Financeiro':
                $financiers = Financier::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                $subsidiaries = Subsidiary::whereIn('id', $financiers)->get();
                break;
            case 'Gerente':
                $managers = Manager::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                $subsidiaries = Subsidiary::whereIn('id', $managers)->get();
                break;
            default:
                $subsidiaries = Subsidiary::all();
                break;
        }

        $commission = Commission::where('id', $id)->whereIn('subsidiary_id', $subsidiaries->pluck('id'))->first();

        if (!$commission) {
            abort(403, 'Acesso não autorizado');
        }

        return view('admin.commissions.pdf', compact('commission'));
    }

    public function changeStatus(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('Editar Comissões')) {
            abort(403, 'Acesso não autorizado');
        }

        if (!$request->ids) {
            return redirect()
                ->back()
                ->with('error', 'Selecione ao menos uma linha!');
        }

        $ids = explode(",", $request->ids);

        $role = Auth::user()->roles->first()->name;
        switch ($role) {
            case 'Financeiro':
                $financiers = Financier::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                $subsidiaries = Subsidiary::whereIn('id', $financiers)->get();
                break;
            case 'Gerente':
                $managers = Manager::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                $subsidiaries = Subsidiary::whereIn('id', $managers)->get();
                break;
            default:
                $subsidiaries = Subsidiary::all();
                break;
        }

        foreach ($ids as $id) {
            $commission = Commission::where('id', $id)->whereIn('subsidiary_id', $subsidiaries->pluck('id'))->first();
            if (!$commission) {
                abort(403, 'Acesso não autorizado');
            }

            $commission->status = $commission->status == 'pago' ? 'pendente' : 'pago';
            $commission->update();
        }

        return redirect()
            ->route('admin.commissions.index')
            ->with('success', 'Comissões atualizadas!');
    }

    function receipt($id)
    {
        if (!Auth::user()->hasPermissionTo('Listar Comissões')) {
            abort(403, 'Acesso não autorizado');
        }

        $role = Auth::user()->roles->first()->name;

        switch ($role) {
            case 'Financeiro':
                $financiers = Financier::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                $subsidiaries = Subsidiary::whereIn('id', $financiers)->get();
                break;
            case 'Gerente':
                $managers = Manager::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                $subsidiaries = Subsidiary::whereIn('id', $managers)->get();
                break;
            default:
                $subsidiaries = Subsidiary::all();
                break;
        }

        $commission = Commission::where('id', $id)->whereIn('subsidiary_id', $subsidiaries->pluck('id'))->first();

        if (!$commission) {
            abort(403, 'Acesso não autorizado');
        }

        return view('admin.commissions.receipt', compact('commission'));
    }
}
