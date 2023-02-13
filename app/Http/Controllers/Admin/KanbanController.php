<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\KanbanRequest;
use App\Models\Kanban;
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

        $draftKanbans = Kanban::where('user_id', Auth::user()->id)->where('status', 'rascunho')->get();
        $doKanbans = Kanban::where('user_id', Auth::user()->id)->where('status', 'fazer')->get();
        $progressKanbans = Kanban::where('user_id', Auth::user()->id)->where('status', 'progresso')->get();
        $finishKanbans = Kanban::where('user_id', Auth::user()->id)->where('status', 'concluido')->get();

        $draftSum = 'R$ ' . \number_format(Kanban::where('user_id', Auth::user()->id)->where('status', 'rascunho')->sum('value'), 2, ',', '.');
        $doSum = 'R$ ' . \number_format(Kanban::where('user_id', Auth::user()->id)->where('status', 'fazer')->sum('value'), 2, ',', '.');
        $progressSum = 'R$ ' . \number_format(Kanban::where('user_id', Auth::user()->id)->where('status', 'progresso')->sum('value'), 2, ',', '.');
        $finishSum = 'R$ ' . \number_format(Kanban::where('user_id', Auth::user()->id)->where('status', 'concluido')->sum('value'), 2, ',', '.');

        return view('admin.kanban.index', \compact('draftKanbans', 'doKanbans', 'progressKanbans', 'finishKanbans', 'draftSum', 'doSum', 'progressSum', 'finishSum'));
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

            $kanban = Kanban::where('id', $request->item)->where('user_id', Auth::user()->id)->first();
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

        $kanban = Kanban::where('id', $request->item)->where('user_id', Auth::user()->id)->first();
        if ($kanban) {
            switch ($request->area) {
                case 'draft':
                    $kanban->status = 'rascunho';
                    break;
                case 'do':
                    $kanban->status = 'fazer';
                    break;
                case 'progress':
                    $kanban->status = 'progresso';
                    break;
                case 'finish':
                    $kanban->status = 'concluido';
                    break;
                default:
                    $kanban->status = $kanban->status;
                    break;
            }
            if ($kanban->update()) {

                $draftSum = Kanban::where('user_id', Auth::user()->id)->where('status', 'rascunho')->sum('value');
                $doSum = Kanban::where('user_id', Auth::user()->id)->where('status', 'fazer')->sum('value');
                $progressSum = Kanban::where('user_id', Auth::user()->id)->where('status', 'progresso')->sum('value');
                $finishSum = Kanban::where('user_id', Auth::user()->id)->where('status', 'concluido')->sum('value');

                return response()->json([
                    'draftSum' => (float)$draftSum,
                    'doSum' => (float)$doSum,
                    'progressSum' => (float)$progressSum,
                    'finishSum' => (float)$finishSum
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

        $kanban = Kanban::where('id', $request->itemDestroy)->where('user_id', Auth::user()->id)->first();
        if ($kanban) {
            if ($kanban->delete()) {
                $draftSum = Kanban::where('user_id', Auth::user()->id)->where('status', 'rascunho')->sum('value');
                $doSum = Kanban::where('user_id', Auth::user()->id)->where('status', 'fazer')->sum('value');
                $progressSum = Kanban::where('user_id', Auth::user()->id)->where('status', 'progresso')->sum('value');
                $finishSum = Kanban::where('user_id', Auth::user()->id)->where('status', 'concluido')->sum('value');

                return response()->json([
                    'draftSum' => (float)$draftSum,
                    'doSum' => (float)$doSum,
                    'progressSum' => (float)$progressSum,
                    'finishSum' => (float)$finishSum
                ]);
            }
        }
    }
}
