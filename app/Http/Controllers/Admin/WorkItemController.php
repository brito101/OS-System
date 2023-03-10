<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\WorkItemRequest;
use App\Models\WorkItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DataTables;

class WorkItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('Listar Itens de Obra')) {
            abort(403, 'Acesso não autorizado');
        }

        $workItems = WorkItem::all();

        if ($request->ajax()) {
            return Datatables::of($workItems)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-xs btn-primary mx-1 shadow" title="Editar" href="work-items/' . $row->id . '/edit">
                    <i class="fa fa-lg fa-fw fa-pen"></i></a>' . '<a class="btn btn-xs btn-danger mx-1 shadow" title="Excluir" href="work-items/destroy/' . $row->id . '" onclick="return confirm(\'Confirma a exclusão deste item?\')"><i class="fa fa-lg fa-fw fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.budgets.work-items.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->hasPermissionTo('Criar Itens de Obra')) {
            abort(403, 'Acesso não autorizado');
        }

        return view('admin.budgets.work-items.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(WorkItemRequest $request)
    {
        if (!Auth::user()->hasPermissionTo('Criar Itens de Obra')) {
            abort(403, 'Acesso não autorizado');
        }

        $workItem = WorkItem::create($request->all());

        if ($workItem->save()) {
            return redirect()
                ->route('admin.work-items.index')
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
        if (!Auth::user()->hasPermissionTo('Editar Itens de Obra')) {
            abort(403, 'Acesso não autorizado');
        }

        $workItem = WorkItem::find($id);

        if (!$workItem) {
            abort(403, 'Acesso não autorizado');
        }

        return view('admin.budgets.work-items.edit', compact('workItem'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(WorkItemRequest $request, $id)
    {
        if (!Auth::user()->hasPermissionTo('Editar Itens de Obra')) {
            abort(403, 'Acesso não autorizado');
        }

        $workItem = WorkItem::find($id);

        if (!$workItem) {
            abort(403, 'Acesso não autorizado');
        }

        if ($workItem->update($request->all())) {
            return redirect()
                ->route('admin.work-items.index')
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
        if (!Auth::user()->hasPermissionTo('Excluir Itens de Obra')) {
            abort(403, 'Acesso não autorizado');
        }

        $workItem = WorkItem::find($id);

        if (!$workItem) {
            abort(403, 'Acesso não autorizado');
        }

        if ($workItem->delete()) {
            return redirect()
                ->route('admin.work-items.index')
                ->with('success', 'Exclusão realizada!');
        } else {
            return redirect()
                ->back()
                ->with('error', 'Erro ao excluir!');
        }
    }
}
