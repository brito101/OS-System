<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TicketPaymentRequest;
use App\Models\Financier;
use App\Models\Manager;
use App\Models\Subsidiary;
use App\Models\TicketPayment;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Auth;

class TicketPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('Listar Pagamento de Passagens')) {
            abort(403, 'Acesso não autorizado');
        }

        $role = Auth::user()->roles->first()->name;

        switch ($role) {
            case 'Financeiro':
                $subsidiaries = Financier::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                $tickets = TicketPayment::where(function ($query) use ($subsidiaries) {
                    $query->whereIn('subsidiary_id', $subsidiaries);
                    $query->orWhere('subsidiary_id', null);
                })->get();
                break;
            case 'Gerente':
                $subsidiaries = Manager::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                $tickets = TicketPayment::where(function ($query) use ($subsidiaries) {
                    $query->whereIn('subsidiary_id', $subsidiaries);
                    $query->orWhere('subsidiary_id', null);
                })->get();
                break;
            default:
                $tickets = TicketPayment::all();
                break;
        }

        if ($request->ajax()) {
            return Datatables::of($tickets)
                ->addIndexColumn()
                ->addColumn('btnStatus', function ($row) {
                    $payLink = '';
                    if ($row->status == 'pendente') {
                        $payLink = '<a class="btn btn-xs btn-danger mx-1 shadow" title="Alterar para pago" href="ticket-payments/pay/' . $row->id . '"><i class="fa fa-lg fa-fw fa-thumbs-down"></i></a>';
                    }
                    if ($row->status == 'pago') {
                        $payLink = '<a class="btn btn-xs btn-success mx-1 shadow" title="Alterar para pendente" href="ticket-payments/receive/' . $row->id . '"><i class="fa fa-lg fa-fw fa-thumbs-up"></i></a>';
                    }
                    return $payLink;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-xs btn-success mx-1 shadow" title="Visualizar" href="ticket-payments/' . $row->id . '"><i class="fa fa-lg fa-fw fa-eye"></i></a>' . '<a class="btn btn-xs btn-primary mx-1 shadow" title="Editar" href="ticket-payments/' . $row->id . '/edit"><i class="fa fa-lg fa-fw fa-pen"></i></a>' . '<a class="btn btn-xs btn-danger mx-1 shadow" title="Excluir" href="ticket-payments/destroy/' . $row->id . '" onclick="return confirm(\'Confirma a exclusão deste pagamento de passagem?\')"><i class="fa fa-lg fa-fw fa-trash"></i></a>' . '<a class="btn btn-xs btn-success mx-1 shadow" title="Recibo" href="' . route('admin.ticketPayments.receipt', ['id' => $row->id]) . '" target="_blank"><i class="fa fa-lg fa-fw fa-file-invoice-dollar"></i></a>';
                    return $btn;
                })
                ->rawColumns(['btnStatus', 'action'])
                ->make(true);
        }

        return view('admin.ticket-payments.index');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->hasPermissionTo('Criar Pagamento de Passagens')) {
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

        return view('admin.ticket-payments.create', compact('subsidiaries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TicketPaymentRequest $request)
    {
        if (!Auth::user()->hasPermissionTo('Criar Pagamento de Passagens')) {
            abort(403, 'Acesso não autorizado');
        }

        $data = $request->all();

        $data['user_id'] = Auth::user()->id;

        $ticketPayment = TicketPayment::create($data);

        if ($ticketPayment->save()) {
            return redirect()
                ->route('admin.ticket-payments.index')
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
        if (!Auth::user()->hasPermissionTo('Listar Pagamento de Passagens')) {
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

        $ticketPayment = TicketPayment::where('id', $id)->where(function ($query) use ($subsidiaries) {
            $query->whereIn('subsidiary_id', $subsidiaries->pluck('id'));
            $query->orWhere('subsidiary_id', null);
        })->first();

        if (!$ticketPayment) {
            abort(403, 'Acesso não autorizado');
        }

        return view('admin.ticket-payments.show', compact('ticketPayment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Auth::user()->hasPermissionTo('Editar Pagamento de Passagens')) {
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

        $ticketPayment = TicketPayment::where('id', $id)
            ->where(function ($query) use ($subsidiaries) {
                $query->whereIn('subsidiary_id', $subsidiaries->pluck('id'));
                $query->orWhere('subsidiary_id', null);
            })->first();

        if (!$ticketPayment) {
            abort(403, 'Acesso não autorizado');
        }

        return view('admin.ticket-payments.edit', compact('ticketPayment', 'subsidiaries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TicketPaymentRequest $request, $id)
    {
        if (!Auth::user()->hasPermissionTo('Editar Pagamento de Passagens')) {
            abort(403, 'Acesso não autorizado');
        }

        $ticketPayment = TicketPayment::find($id);

        if (!$ticketPayment) {
            abort(403, 'Acesso não autorizado');
        }

        $data = $request->all();

        if ($ticketPayment->update($data)) {
            return redirect()
                ->route('admin.ticket-payments.index')
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
        if (!Auth::user()->hasPermissionTo('Excluir Pagamento de Passagens')) {
            abort(403, 'Acesso não autorizado');
        }

        $ticketPayment = TicketPayment::find($id);

        if (!$ticketPayment) {
            abort(403, 'Acesso não autorizado');
        }
        if ($ticketPayment->delete()) {
            return redirect()
                ->route('admin.ticket-payments.index')
                ->with('success', 'Exclusão realizada!');
        } else {
            return redirect()
                ->back()
                ->with('error', 'Erro ao excluir!');
        }
    }

    public function pay($id)
    {
        if (!Auth::user()->hasPermissionTo('Editar Pagamento de Passagens')) {
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

        $ticketPayment = TicketPayment::where('id', $id)->where(function ($query) use ($subsidiaries) {
            $query->whereIn('subsidiary_id', $subsidiaries->pluck('id'));
            $query->orWhere('subsidiary_id', null);
        })->first();

        if (!$ticketPayment) {
            abort(403, 'Acesso não autorizado');
        }

        $ticketPayment->status = 'pago';

        if ($ticketPayment->update()) {
            return redirect()
                ->route('admin.ticket-payments.index')
                ->with('success', 'Passagem marcada como paga!');
        } else {
            return redirect()
                ->back()
                ->with('error', 'Erro ao atualizar!');
        }
    }

    public function receive($id)
    {
        if (!Auth::user()->hasPermissionTo('Editar Pagamento de Passagens')) {
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

        $ticketPayment = TicketPayment::where('id', $id)->where(function ($query) use ($subsidiaries) {
            $query->whereIn('subsidiary_id', $subsidiaries->pluck('id'));
            $query->orWhere('subsidiary_id', null);
        })->first();

        if (!$ticketPayment) {
            abort(403, 'Acesso não autorizado');
        }

        $ticketPayment->status = 'pendente';

        if ($ticketPayment->update()) {
            return redirect()
                ->route('admin.ticket-payments.index')
                ->with('success', 'Passagem marcada como pendente!');
        } else {
            return redirect()
                ->back()
                ->with('error', 'Erro ao atualizar!');
        }
    }

    public function pdf($id)
    {
        if (!Auth::user()->hasPermissionTo('Listar Pagamento de Passagens')) {
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

        $ticketPayment = TicketPayment::where('id', $id)->where(function ($query) use ($subsidiaries) {
            $query->whereIn('subsidiary_id', $subsidiaries->pluck('id'));
            $query->orWhere('subsidiary_id', null);
        })->first();

        if (!$ticketPayment) {
            abort(403, 'Acesso não autorizado');
        }

        return view('admin.ticket-payments.pdf', compact('ticketPayment'));
    }

    public function changeStatus(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('Editar Pagamento de Passagens')) {
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
            $ticketPayment = TicketPayment::where('id', $id)->where(function ($query) use ($subsidiaries) {
                $query->whereIn('subsidiary_id', $subsidiaries->pluck('id'));
                $query->orWhere('subsidiary_id', null);
            })->first();

            if (!$ticketPayment) {
                abort(403, 'Acesso não autorizado');
            }

            $ticketPayment->status = $ticketPayment->status == 'pago' ? 'pendente' : 'pago';
            $ticketPayment->update();
        }

        return redirect()
            ->route('admin.ticket-payments.index')
            ->with('success', 'Comissões atualizadas!');
    }

    function receipt($id)
    {
        if (!Auth::user()->hasPermissionTo('Listar Pagamento de Passagens')) {
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

        $ticketPayment = TicketPayment::where('id', $id)->where(function ($query) use ($subsidiaries) {
            $query->whereIn('subsidiary_id', $subsidiaries->pluck('id'));
            $query->orWhere('subsidiary_id', null);
        })->first();

        if (!$ticketPayment) {
            abort(403, 'Acesso não autorizado');
        }

        return view('admin.ticket-payments.receipt', compact('ticketPayment'));
    }
}
