<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SubsidiaryRequest;
use App\Models\Collaborator;
use App\Models\Subsidiary;
use App\Models\User;
use App\Models\Views\Subsidiary as ViewsSubsidiary;
use App\Models\Views\User as ViewsUser;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SubsidiaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('Listar Filiais')) {
            abort(403, 'Acesso não autorizado');
        }

        $subsidiaries = ViewsSubsidiary::all();

        if ($request->ajax()) {
            return Datatables::of($subsidiaries)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-xs btn-primary mx-1 shadow" title="Editar" href="subsidiaries/' . $row->id . '/edit"><i class="fa fa-lg fa-fw fa-pen"></i></a>' . '<a class="btn btn-xs btn-danger mx-1 shadow" title="Excluir" href="subsidiaries/destroy/' . $row->id . '" onclick="return confirm(\'Confirma a exclusão desta filial?\')"><i class="fa fa-lg fa-fw fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.subsidiaries.index', compact('subsidiaries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->hasPermissionTo('Criar Filiais')) {
            abort(403, 'Acesso não autorizado');
        }

        $users = ViewsUser::whereIn('type', ['Colaborador'])->get();

        return view('admin.subsidiaries.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubsidiaryRequest $request)
    {
        if (!Auth::user()->hasPermissionTo('Criar Filiais')) {
            abort(403, 'Acesso não autorizado');
        }

        $subsidiary = Subsidiary::create($request->all());

        if ($subsidiary->save()) {

            $collaborators = $request->collaborators;
            if ($collaborators && count($collaborators) > 0) {
                $users = User::whereIn('id', $collaborators)->pluck('id');
                foreach ($users as $user) {
                    $collaborator = new Collaborator();
                    $collaborator->create([
                        'user_id' => $user,
                        'subsidiary_id' => $subsidiary->id
                    ]);
                }
            } else {
                $deleteCollaborators = Collaborator::where('subsidiary_id', $subsidiary->id)->delete();
            }
            return redirect()
                ->route('admin.subsidiaries.index')
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
        if (!Auth::user()->hasPermissionTo('Editar Filiais')) {
            abort(403, 'Acesso não autorizado');
        }

        $subsidiary = Subsidiary::where('id', $id)->with('collaborators')->first();

        if (!$subsidiary) {
            abort(403, 'Acesso não autorizado');
        }

        $users = ViewsUser::whereIn('type', ['Colaborador'])->get();

        return view('admin.subsidiaries.edit', compact('subsidiary', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SubsidiaryRequest $request, $id)
    {
        if (!Auth::user()->hasPermissionTo('Editar Filiais')) {
            abort(403, 'Acesso não autorizado');
        }

        $subsidiary = Subsidiary::find($id);

        if (!$subsidiary) {
            abort(403, 'Acesso não autorizado');
        }

        $collaborators = $request->collaborators;
        if ($collaborators && count($collaborators) > 0) {
            $users = User::whereIn('id', $collaborators)->pluck('id');
            $deleteCollaborators = Collaborator::whereNotIn('user_id', $users)
                ->where('subsidiary_id', $subsidiary->id)->delete();
            foreach ($users as $user) {
                $collaborator = new Collaborator();
                $collaborator->firstOrCreate([
                    'user_id' => $user,
                    'subsidiary_id' => $subsidiary->id
                ]);
            }
        } else {
            $deleteCollaborators = Collaborator::where('subsidiary_id', $subsidiary->id)->delete();
        }

        if ($subsidiary->update($request->all())) {
            return redirect()
                ->route('admin.subsidiaries.index')
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
        if (!Auth::user()->hasPermissionTo('Excluir Filiais')) {
            abort(403, 'Acesso não autorizado');
        }

        $subsidiary = Subsidiary::find($id);

        if (!$subsidiary) {
            abort(403, 'Acesso não autorizado');
        }

        if ($subsidiary->delete()) {
            $deleteCollaborators = Collaborator::where('subsidiary_id', $subsidiary->id)->delete();
            return redirect()
                ->route('admin.subsidiaries.index')
                ->with('success', 'Exclusão realizada!');
        } else {
            return redirect()
                ->back()
                ->with('error', 'Erro ao excluir!');
        }
    }

    public function collaborators(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('Listar Colaboradores')) {
            abort(403, 'Acesso não autorizado');
        }

        $subsidiaries = DB::table('subsidiaries')->where('deleted_at', null)
            ->when($request->alias_name, function ($query, $alias_name) {
                $query->where('alias_name', $alias_name);
            })
            ->when($request->city, function ($query, $city) {
                $query->where('city', $city);
            })
            ->get();

        $collaborators = Collaborator::whereIn('subsidiary_id', $subsidiaries->pluck('id'))->get();
        $users = User::whereIn('id', $collaborators->pluck('user_id'))->paginate();
        return view('admin.subsidiaries.collaborators', compact('users'));
    }
}
