<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SalesFunnelRequest;
use App\Models\Client;
use App\Models\Collaborator;
use App\Models\Manager;
use App\Models\SalesFunnel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SalesFunnelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Auth::user()->hasPermissionTo('Listar Funil de Vendas')) {
            abort(403, 'Acesso não autorizado');
        }

        $role = Auth::user()->roles->first()->name;

        switch ($role) {
            case 'Colaborador':
            case 'Colaborador-NI':
            case 'Colaborador Comercial':
                $subsidiaries = Collaborator::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                $clients = Client::where('trade_status', '!=', 'Restrito')->whereIn('subsidiary_id', $subsidiaries)->orWhere('subsidiary_id', null)->get();
                break;
            case 'Gerente':
                $subsidiaries = Manager::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                $clients = Client::where('trade_status', '!=', 'Restrito')->whereIn('subsidiary_id', $subsidiaries)->orWhere('subsidiary_id', null)->get();
                break;
            default:
                $clients = Client::all();
                break;
        }

        $scheduledVisit = SalesFunnel::whereIn('client_id', $clients->pluck('id'))->where('status', 'Visita Agendada')->get();
        $performedInspection = SalesFunnel::whereIn('client_id', $clients->pluck('id'))->where('status', 'Vistoria Executada')->get();
        $submissionProposal = SalesFunnel::whereIn('client_id', $clients->pluck('id'))->where('status', 'Envio de Proposta')->get();
        $negotiation = SalesFunnel::whereIn('client_id', $clients->pluck('id'))->where('status', 'Negociação')->get();
        $scheduledMeeting = SalesFunnel::whereIn('client_id', $clients->pluck('id'))->where('status', 'Assembléia Marcada')->get();
        $closure = SalesFunnel::whereIn('client_id', $clients->pluck('id'))->where('status', 'Fechamento')->get();
        $lost = SalesFunnel::whereIn('client_id', $clients->pluck('id'))->where('status', 'Perdido')->get();

        $scheduledVisitSum = 'R$ ' . \number_format(SalesFunnel::whereIn('client_id', $clients->pluck('id'))->where('status', 'Visita Agendada')->sum('proposal'), 2, ',', '.');
        $performedInspectionSum = 'R$ ' . \number_format(SalesFunnel::whereIn('client_id', $clients->pluck('id'))->where('status', 'Vistoria Executada')->sum('proposal'), 2, ',', '.');
        $submissionProposalSum = 'R$ ' . \number_format(SalesFunnel::whereIn('client_id', $clients->pluck('id'))->where('status', 'Envio de Proposta')->sum('proposal'), 2, ',', '.');
        $negotiationSum = 'R$ ' . \number_format(SalesFunnel::whereIn('client_id', $clients->pluck('id'))->where('status', 'Negociação')->sum('proposal'), 2, ',', '.');
        $scheduledMeetingSum = 'R$ ' . \number_format(SalesFunnel::whereIn('client_id', $clients->pluck('id'))->where('status', 'Assembléia Marcada')->sum('proposal'), 2, ',', '.');
        $closureSum = 'R$ ' . \number_format(SalesFunnel::whereIn('client_id', $clients->pluck('id'))->where('status', 'Fechamento')->sum('proposal'), 2, ',', '.');
        $lostSum = 'R$ ' . \number_format(SalesFunnel::whereIn('client_id', $clients->pluck('id'))->where('status', 'Perdido')->sum('proposal'), 2, ',', '.');

        return view('admin.sales-funnel.index', \compact('scheduledVisit', 'performedInspection', 'submissionProposal', 'negotiation', 'scheduledMeeting', 'closure', 'lost', 'scheduledVisitSum', 'performedInspectionSum', 'submissionProposalSum', 'negotiationSum', 'scheduledMeetingSum', 'closureSum', 'lostSum', 'clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SalesFunnelRequest $request)
    {
        $data = $request->all();

        $role = Auth::user()->roles->first()->name;

        switch ($role) {
            case 'Colaborador':
            case 'Colaborador-NI':
            case 'Colaborador Comercial':
                $subsidiaries = Collaborator::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                $clients = Client::where('trade_status', '!=', 'Restrito')->whereIn('subsidiary_id', $subsidiaries)->orWhere('subsidiary_id', null)->get();
                break;
            case 'Gerente':
                $subsidiaries = Manager::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                $clients = Client::where('trade_status', '!=', 'Restrito')->whereIn('subsidiary_id', $subsidiaries)->orWhere('subsidiary_id', null)->get();
                break;
            default:
                $clients = Client::all();
                break;
        }

        if ($request->id == null) {
            if (!Auth::user()->hasPermissionTo('Criar Funil de Vendas')) {
                abort(403, 'Acesso não autorizado');
            }

            $data['user_id'] = Auth::user()->id;
            $salesFunnel = SalesFunnel::create($data);
            if ($salesFunnel->save()) {
                return redirect()
                    ->route('admin.sales-funnel.index')
                    ->with('success', 'Cadastro realizado!');
            }
        } else {
            if (!Auth::user()->hasPermissionTo('Editar Funil de Vendas')) {
                abort(403, 'Acesso não autorizado');
            }

            $salesFunnel = SalesFunnel::where('id', $request->id)->whereIn('client_id', $clients->pluck('id'))->first();

            if ($salesFunnel->update($data)) {
                return redirect()
                    ->route('admin.sales-funnel.index')
                    ->with('success', 'Atualização realizada!');
            }
        }

        return redirect()
            ->back()
            ->withInput()
            ->with('error', 'Erro ao cadastrar!');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('Editar Funil de Vendas')) {
            abort(403, 'Acesso não autorizado');
        }

        $role = Auth::user()->roles->first()->name;

        switch ($role) {
            case 'Colaborador':
            case 'Colaborador-NI':
            case 'Colaborador Comercial':
                $subsidiaries = Collaborator::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                $clients = Client::where('trade_status', '!=', 'Restrito')->whereIn('subsidiary_id', $subsidiaries)->orWhere('subsidiary_id', null)->get();
                break;
            case 'Gerente':
                $subsidiaries = Manager::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                $clients = Client::where('trade_status', '!=', 'Restrito')->whereIn('subsidiary_id', $subsidiaries)->orWhere('subsidiary_id', null)->get();
                break;
            default:
                $clients = Client::all();
                break;
        }

        $salesFunnel = SalesFunnel::where('id', $request->item)->whereIn('client_id', $clients->pluck('id'))->first();

        if ($salesFunnel) {
            switch ($request->area) {
                case 'scheduledVisit':
                    $salesFunnel->status = 'Visita Agendada';
                    break;
                case 'performedInspection':
                    $salesFunnel->status = 'Vistoria Executada';
                    break;
                case 'submissionProposal':
                    $salesFunnel->status = 'Envio de Proposta';
                    break;
                case 'negotiation':
                    $salesFunnel->status = 'Negociação';
                    break;
                case 'scheduledMeeting':
                    $salesFunnel->status = 'Assembléia Marcada';
                    break;
                case 'closure':
                    $salesFunnel->status = 'Fechamento';
                    break;
                case 'lost':
                    $salesFunnel->status = 'Perdido';
                    break;
                default:
                    $salesFunnel->status = $salesFunnel->status;
                    break;
            }

            if ($salesFunnel->update()) {

                $scheduledVisitSum = SalesFunnel::whereIn('client_id', $clients->pluck('id'))->where('status', 'Visita Agendada')->sum('proposal');
                $performedInspectionSum = SalesFunnel::whereIn('client_id', $clients->pluck('id'))->where('status', 'Vistoria Executada')->sum('proposal');
                $submissionProposalSum = SalesFunnel::whereIn('client_id', $clients->pluck('id'))->where('status', 'Envio de Proposta')->sum('proposal');
                $negotiationSum = SalesFunnel::whereIn('client_id', $clients->pluck('id'))->where('status', 'Negociação')->sum('proposal');
                $scheduledMeetingSum = SalesFunnel::whereIn('client_id', $clients->pluck('id'))->where('status', 'Assembléia Marcada')->sum('proposal');
                $closureSum = SalesFunnel::whereIn('client_id', $clients->pluck('id'))->where('status', 'Fechamento')->sum('proposal');
                $lostSum = SalesFunnel::whereIn('client_id', $clients->pluck('id'))->where('status', 'Perdido')->sum('proposal');

                return response()->json([
                    'scheduledVisitSum' => (float)$scheduledVisitSum,
                    'performedInspectionSum' => (float)$performedInspectionSum,
                    'submissionProposalSum' => (float)$submissionProposalSum,
                    'negotiationSum' => (float)$negotiationSum,
                    'scheduledMeetingSum' => (float)$scheduledMeetingSum,
                    'closureSum' => (float)$closureSum,
                    'lostSum' => (float)$lostSum,
                ]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('Excluir Funil de Vendas')) {
            abort(403, 'Acesso não autorizado');
        }

        $role = Auth::user()->roles->first()->name;

        switch ($role) {
            case 'Colaborador':
            case 'Colaborador-NI':
            case 'Colaborador Comercial':
                $subsidiaries = Collaborator::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                $clients = Client::where('trade_status', '!=', 'Restrito')->whereIn('subsidiary_id', $subsidiaries)->orWhere('subsidiary_id', null)->get();
                break;
            case 'Gerente':
                $subsidiaries = Manager::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                $clients = Client::where('trade_status', '!=', 'Restrito')->whereIn('subsidiary_id', $subsidiaries)->orWhere('subsidiary_id', null)->get();
                break;
            default:
                $clients = Client::all();
                break;
        }

        $kanban = SalesFunnel::where('id', $request->itemDestroy)
            ->whereIn('client_id', $clients->pluck('id'))->first();
        if ($kanban) {
            if ($kanban->delete()) {

                $scheduledVisitSum = SalesFunnel::whereIn('client_id', $clients->pluck('id'))->where('status', 'Visita Agendada')->sum('proposal');
                $performedInspectionSum = SalesFunnel::whereIn('client_id', $clients->pluck('id'))->where('status', 'Vistoria Executada')->sum('proposal');
                $submissionProposalSum = SalesFunnel::whereIn('client_id', $clients->pluck('id'))->where('status', 'Envio de Proposta')->sum('proposal');
                $negotiationSum = SalesFunnel::whereIn('client_id', $clients->pluck('id'))->where('status', 'Negociação')->sum('proposal');
                $scheduledMeetingSum = SalesFunnel::whereIn('client_id', $clients->pluck('id'))->where('status', 'Assembléia Marcada')->sum('proposal');
                $closureSum = SalesFunnel::whereIn('client_id', $clients->pluck('id'))->where('status', 'Fechamento')->sum('proposal');
                $lostSum = SalesFunnel::whereIn('client_id', $clients->pluck('id'))->where('status', 'Perdido')->sum('proposal');

                return response()->json([
                    'scheduledVisitSum' => (float)$scheduledVisitSum,
                    'performedInspectionSum' => (float)$performedInspectionSum,
                    'submissionProposalSum' => (float)$submissionProposalSum,
                    'negotiationSum' => (float)$negotiationSum,
                    'scheduledMeetingSum' => (float)$scheduledMeetingSum,
                    'closureSum' => (float)$closureSum,
                    'lostSum' => (float)$lostSum,
                ]);
            }
        }
    }
}
