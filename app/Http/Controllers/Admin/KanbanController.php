<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\KanbanRequest;
use App\Models\Collaborator;
use App\Models\Kanban;
use App\Models\Manager;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KanbanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Auth::user()->hasPermissionTo('Listar Kanban')) {
            abort(403, 'Acesso não autorizado');
        }

        $role = Auth::user()->roles->first()->name;

        switch ($role) {
            case 'Colaborador':
            case 'Colaborador-NI':
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

        $scheduledVisit = Kanban::whereIn('client_id', $clients->pluck('id'))->where('status', 'Visita Agendada')->get();
        $performedInspection = Kanban::whereIn('client_id', $clients->pluck('id'))->where('status', 'Vistoria Executada')->get();
        $submissionProposal = Kanban::whereIn('client_id', $clients->pluck('id'))->where('status', 'Envio de Proposta')->get();
        $negotiation = Kanban::whereIn('client_id', $clients->pluck('id'))->where('status', 'Negociação')->get();
        $scheduledMeeting = Kanban::whereIn('client_id', $clients->pluck('id'))->where('status', 'Assembléia Marcada')->get();
        $closure = Kanban::whereIn('client_id', $clients->pluck('id'))->where('status', 'Fechamento')->get();
        $lost = Kanban::whereIn('client_id', $clients->pluck('id'))->where('status', 'Perdido')->get();

        $scheduledVisitSum = 'R$ ' . \number_format(Kanban::whereIn('client_id', $clients->pluck('id'))->where('status', 'Visita Agendada')->sum('proposal'), 2, ',', '.');
        $performedInspectionSum = 'R$ ' . \number_format(Kanban::whereIn('client_id', $clients->pluck('id'))->where('status', 'Vistoria Executada')->sum('proposal'), 2, ',', '.');
        $submissionProposalSum = 'R$ ' . \number_format(Kanban::whereIn('client_id', $clients->pluck('id'))->where('status', 'Envio de Proposta')->sum('proposal'), 2, ',', '.');
        $negotiationSum = 'R$ ' . \number_format(Kanban::whereIn('client_id', $clients->pluck('id'))->where('status', 'Negociação')->sum('proposal'), 2, ',', '.');
        $scheduledMeetingSum = 'R$ ' . \number_format(Kanban::whereIn('client_id', $clients->pluck('id'))->where('status', 'Assembléia Marcada')->sum('proposal'), 2, ',', '.');
        $closureSum = 'R$ ' . \number_format(Kanban::whereIn('client_id', $clients->pluck('id'))->where('status', 'Fechamento')->sum('proposal'), 2, ',', '.');
        $lostSum = 'R$ ' . \number_format(Kanban::whereIn('client_id', $clients->pluck('id'))->where('status', 'Perdido')->sum('proposal'), 2, ',', '.');

        return view('admin.kanban.index', \compact('scheduledVisit', 'performedInspection', 'submissionProposal', 'negotiation', 'scheduledMeeting', 'closure', 'lost', 'scheduledVisitSum', 'performedInspectionSum', 'submissionProposalSum', 'negotiationSum', 'scheduledMeetingSum', 'closureSum', 'lostSum', 'clients'));
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
    public function store(KanbanRequest $request)
    {
        $data = $request->all();

        $role = Auth::user()->roles->first()->name;

        switch ($role) {
            case 'Colaborador':
            case 'Colaborador-NI':
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
            if (!Auth::user()->hasPermissionTo('Criar Kanban')) {
                abort(403, 'Acesso não autorizado');
            }

            $data['user_id'] = Auth::user()->id;
            $kanban = Kanban::create($data);
            if ($kanban->save()) {
                return redirect()
                    ->route('admin.kanban.index')
                    ->with('success', 'Cadastro realizado!');
            }
        } else {
            if (!Auth::user()->hasPermissionTo('Editar Kanban')) {
                abort(403, 'Acesso não autorizado');
            }

            $kanban = Kanban::where('id', $request->id)->whereIn('client_id', $clients->pluck('id'))->first();

            if ($kanban->update($data)) {
                return redirect()
                    ->route('admin.kanban.index')
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
        if (!Auth::user()->hasPermissionTo('Editar Kanban')) {
            abort(403, 'Acesso não autorizado');
        }

        $role = Auth::user()->roles->first()->name;

        switch ($role) {
            case 'Colaborador':
            case 'Colaborador-NI':
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

        $kanban = Kanban::where('id', $request->item)->whereIn('client_id', $clients->pluck('id'))->first();

        if ($kanban) {
            switch ($request->area) {
                case 'scheduledVisit':
                    $kanban->status = 'Visita Agendada';
                    break;
                case 'performedInspection':
                    $kanban->status = 'Vistoria Executada';
                    break;
                case 'submissionProposal':
                    $kanban->status = 'Envio de Proposta';
                    break;
                case 'negotiation':
                    $kanban->status = 'Negociação';
                    break;
                case 'scheduledMeeting':
                    $kanban->status = 'Assembléia Marcada';
                    break;
                case 'closure':
                    $kanban->status = 'Fechamento';
                    break;
                case 'lost':
                    $kanban->status = 'Perdido';
                    break;
                default:
                    $kanban->status = $kanban->status;
                    break;
            }

            if ($kanban->update()) {

                $scheduledVisitSum = Kanban::whereIn('client_id', $clients->pluck('id'))->where('status', 'Visita Agendada')->sum('proposal');
                $performedInspectionSum = Kanban::whereIn('client_id', $clients->pluck('id'))->where('status', 'Vistoria Executada')->sum('proposal');
                $submissionProposalSum = Kanban::whereIn('client_id', $clients->pluck('id'))->where('status', 'Envio de Proposta')->sum('proposal');
                $negotiationSum = Kanban::whereIn('client_id', $clients->pluck('id'))->where('status', 'Negociação')->sum('proposal');
                $scheduledMeetingSum = Kanban::whereIn('client_id', $clients->pluck('id'))->where('status', 'Assembléia Marcada')->sum('proposal');
                $closureSum = Kanban::whereIn('client_id', $clients->pluck('id'))->where('status', 'Fechamento')->sum('proposal');
                $lostSum = Kanban::whereIn('client_id', $clients->pluck('id'))->where('status', 'Perdido')->sum('proposal');

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
        if (!Auth::user()->hasPermissionTo('Excluir Kanban')) {
            abort(403, 'Acesso não autorizado');
        }

        $role = Auth::user()->roles->first()->name;

        switch ($role) {
            case 'Colaborador':
            case 'Colaborador-NI':
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

        $kanban = Kanban::where('id', $request->itemDestroy)->whereIn('client_id', $clients->pluck('id'))->first();
        if ($kanban) {
            if ($kanban->delete()) {

                $scheduledVisitSum = Kanban::whereIn('client_id', $clients->pluck('id'))->where('status', 'Visita Agendada')->sum('proposal');
                $performedInspectionSum = Kanban::whereIn('client_id', $clients->pluck('id'))->where('status', 'Vistoria Executada')->sum('proposal');
                $submissionProposalSum = Kanban::whereIn('client_id', $clients->pluck('id'))->where('status', 'Envio de Proposta')->sum('proposal');
                $negotiationSum = Kanban::whereIn('client_id', $clients->pluck('id'))->where('status', 'Negociação')->sum('proposal');
                $scheduledMeetingSum = Kanban::whereIn('client_id', $clients->pluck('id'))->where('status', 'Assembléia Marcada')->sum('proposal');
                $closureSum = Kanban::whereIn('client_id', $clients->pluck('id'))->where('status', 'Fechamento')->sum('proposal');
                $lostSum = Kanban::whereIn('client_id', $clients->pluck('id'))->where('status', 'Perdido')->sum('proposal');

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
