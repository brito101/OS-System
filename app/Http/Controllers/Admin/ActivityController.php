<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ActivityRequest;
use App\Models\Activity;
use App\Models\Views\Activity as ViewsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DataTables;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('Listar Atividades')) {
            abort(403, 'Acesso não autorizado');
        }

        $activities = ViewsActivity::all();

        if ($request->ajax()) {
            return Datatables::of($activities)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-xs btn-primary mx-1 shadow" title="Editar" href="activities/' . $row->id . '/edit"><i class="fa fa-lg fa-fw fa-pen"></i></a>' . '<a class="btn btn-xs btn-danger mx-1 shadow" title="Excluir" href="activities/destroy/' . $row->id . '" onclick="return confirm(\'Confirma a exclusão desta atividade?\')"><i class="fa fa-lg fa-fw fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.activities.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->hasPermissionTo('Criar Atividades')) {
            abort(403, 'Acesso não autorizado');
        }

        return view('admin.activities.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ActivityRequest $request)
    {
        if (!Auth::user()->hasPermissionTo('Criar Atividades')) {
            abort(403, 'Acesso não autorizado');
        }

        $activity = Activity::create($request->all());

        if ($activity->save()) {
            return redirect()
                ->route('admin.activities.index')
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
        if (!Auth::user()->hasPermissionTo('Editar Atividades')) {
            abort(403, 'Acesso não autorizado');
        }

        $activity = Activity::find($id);

        if (!$activity) {
            abort(403, 'Acesso não autorizado');
        }

        return view('admin.activities.edit', compact('activity'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ActivityRequest $request, $id)
    {
        if (!Auth::user()->hasPermissionTo('Editar Atividades')) {
            abort(403, 'Acesso não autorizado');
        }

        $activity = Activity::find($id);

        if (!$activity) {
            abort(403, 'Acesso não autorizado');
        }

        if ($activity->update($request->all())) {
            return redirect()
                ->route('admin.activities.index')
                ->with('success', 'Edição realizada!');
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
        if (!Auth::user()->hasPermissionTo('Excluir Atividades')) {
            abort(403, 'Acesso não autorizado');
        }

        $activity = Activity::find($id);

        if (!$activity) {
            abort(403, 'Acesso não autorizado');
        }

        if ($activity->delete()) {
            return redirect()
                ->route('admin.activities.index')
                ->with('success', 'Exclusão realizada!');
        } else {
            return redirect()
                ->back()
                ->with('error', 'Erro ao excluir!');
        }
    }
}
