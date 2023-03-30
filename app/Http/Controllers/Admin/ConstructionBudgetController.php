<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ConstructionBudgetRequest;
use App\Models\ConstructionBudget;
use App\Models\WorkItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DataTables;

class ConstructionBudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('Listar Orçamentos')) {
            abort(403, 'Acesso não autorizado');
        }

        $budget = ConstructionBudget::all();

        if ($request->ajax()) {
            return Datatables::of($budget)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-xs btn-primary mx-1 shadow" title="Editar" href="construction-budget/' . $row->id . '/edit">
                    <i class="fa fa-lg fa-fw fa-pen"></i></a>' . '<a class="btn btn-xs btn-danger mx-1 shadow" title="Excluir" href="construction-budget/destroy/' . $row->id . '" onclick="return confirm(\'Confirma a exclusão deste item?\')"><i class="fa fa-lg fa-fw fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.budgets.construction.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->hasPermissionTo('Criar Orçamentos')) {
            abort(403, 'Acesso não autorizado');
        }

        $items = WorkItem::all();

        return view('admin.budgets.construction.create', compact('items'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ConstructionBudgetRequest $request)
    {
        if (!Auth::user()->hasPermissionTo('Criar Orçamentos')) {
            abort(403, 'Acesso não autorizado');
        }

        $data = $request->all();
        $data['user_id'] = Auth::user()->id;

        $budget = ConstructionBudget::create($data);

        if ($budget->save()) {
            return redirect()
                ->route('admin.construction-budget.index')
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
        if (!Auth::user()->hasPermissionTo('Editar Orçamentos')) {
            abort(403, 'Acesso não autorizado');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!Auth::user()->hasPermissionTo('Editar Orçamentos')) {
            abort(403, 'Acesso não autorizado');
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
        if (!Auth::user()->hasPermissionTo('Excluir Orçamentos')) {
            abort(403, 'Acesso não autorizado');
        }
    }
}
