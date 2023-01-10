<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EmployeeRequest;
use App\Imports\EmployeeImport;
use App\Models\Employee;
use App\Models\Manager;
use App\Models\Subsidiary;
use App\Models\Views\Employee as ViewsEmployee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use DataTables;
use Image;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('Listar Funcionários')) {
            abort(403, 'Acesso não autorizado');
        }

        $role = Auth::user()->roles->first()->name;

        switch ($role) {
            case 'Financeiro':
                $employees = Employee::whereIn('subsidiary_id', Auth::user()->financiers->pluck('subsidiary_id'))->orWhere('subsidiary_id', null)->query();
                break;
            case 'Gerente':
                $employees = Employee::whereIn('subsidiary_id', Auth::user()->managers->pluck('subsidiary_id'))->orWhere('subsidiary_id', null)->query();
                break;
            default:
                $employees = ViewsEmployee::query();
                break;
        }

        if ($request->ajax()) {
            return Datatables::of($employees)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-xs btn-success mx-1 shadow" title="Visualizar" href="employees/' . $row->id . '"><i class="fa fa-lg fa-fw fa-eye"></i></a>' . '<a class="btn btn-xs btn-primary mx-1 shadow" title="Editar" href="employees/' . $row->id . '/edit"><i class="fa fa-lg fa-fw fa-pen"></i></a>' . '<a class="btn btn-xs btn-danger mx-1 shadow" title="Excluir" href="employees/destroy/' . $row->id . '" onclick="return confirm(\'Confirma a exclusão deste funcionário?\')"><i class="fa fa-lg fa-fw fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.employees.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->hasPermissionTo('Criar Funcionários')) {
            abort(403, 'Acesso não autorizado');
        }

        $role = Auth::user()->roles->first()->name;

        switch ($role) {
            case 'Gerente':
                $subsidiaries = Subsidiary::whereIn('id', Auth::user()->managers->pluck('subsidiary_id'))->get();
                break;
            case 'Financeiro':
                $subsidiaries = Subsidiary::whereIn('id', Auth::user()->financiers->pluck('subsidiary_id'))->get();
                break;
            default:
                $subsidiaries = Subsidiary::select('id', 'alias_name')->get();
                break;
        }

        return view('admin.employees.create', \compact('subsidiaries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeRequest $request)
    {
        if (!Auth::user()->hasPermissionTo('Criar Funcionários')) {
            abort(403, 'Acesso não autorizado');
        }

        $data = $request->all();

        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $name = Str::slug(mb_substr($data['name'], 0, 100)) . "-" . time();
            $extension = $request->photo->extension();
            $nameFile = "{$name}.{$extension}";

            $data['photo'] = $nameFile;

            $destinationPath = storage_path() . '/app/public/employees';
            $img = Image::make($request->photo);
            $img->resize(null, 151, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->crop(113, 151)->save($destinationPath . '/' . $nameFile);

            if (!$img) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Falha ao fazer o upload da imagem');
            }
        }

        $data['user_id'] = Auth::user()->id;
        $employee = Employee::create($data);

        if ($employee->save()) {
            return redirect()
                ->route('admin.employees.index')
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
        if (!Auth::user()->hasPermissionTo('Listar Funcionários')) {
            abort(403, 'Acesso não autorizado');
        }

        $employee = Employee::find($id);

        if (!$employee) {
            abort(403, 'Acesso não autorizado');
        }

        return view('admin.employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Auth::user()->hasPermissionTo('Editar Funcionários')) {
            abort(403, 'Acesso não autorizado');
        }

        $employee = Employee::find($id);

        if (!$employee) {
            abort(403, 'Acesso não autorizado');
        }

        $role = Auth::user()->roles->first()->name;

        switch ($role) {
            case 'Gerente':
                $subsidiaries = Subsidiary::whereIn('id', Auth::user()->managers->pluck('subsidiary_id'))->get();
                break;
            case 'Financeiro':
                $subsidiaries = Subsidiary::whereIn('id', Auth::user()->financiers->pluck('subsidiary_id'))->get();
                break;
            default:
                $subsidiaries = Subsidiary::select('id', 'alias_name')->get();
                break;
        }

        return view('admin.employees.edit', compact('employee', 'subsidiaries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EmployeeRequest $request, $id)
    {
        if (!Auth::user()->hasPermissionTo('Editar Funcionários')) {
            abort(403, 'Acesso não autorizado');
        }

        $employee = Employee::find($id);

        if (!$employee) {
            abort(403, 'Acesso não autorizado');
        }

        $data = $request->all();

        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $name = Str::slug(mb_substr($data['name'], 0, 200)) . "-" . time();
            $imagePath = storage_path() . '/app/public/employees/' . $employee->photo;

            if (File::isFile($imagePath)) {
                unlink($imagePath);
            }

            $extension = $request->photo->extension();
            $nameFile = "{$name}.{$extension}";

            $data['photo'] = $nameFile;

            $destinationPath = storage_path() . '/app/public/employees';
            $img = Image::make($request->photo);
            $img->resize(null, 151, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->crop(113, 151)->save($destinationPath . '/' . $nameFile);

            if (!$img)
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Falha ao fazer o upload da imagem');
        }

        if ($employee->update($data)) {
            return redirect()
                ->route('admin.employees.index')
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
        if (!Auth::user()->hasPermissionTo('Excluir Funcionários')) {
            abort(403, 'Acesso não autorizado');
        }

        $employee = Employee::find($id);

        if (!$employee) {
            abort(403, 'Acesso não autorizado');
        }

        $imagePath = storage_path() . '/app/public/employees/' . $employee->photo;
        if ($employee->delete()) {
            if (File::isFile($imagePath)) {
                unlink($imagePath);
                $employee->photo = null;
                $employee->update();
            }

            return redirect()
                ->route('admin.employees.index')
                ->with('success', 'Exclusão realizada!');
        } else {
            return redirect()
                ->back()
                ->with('error', 'Erro ao excluir!');
        }
    }

    public function pdf($id)
    {
        if (!Auth::user()->hasPermissionTo('Listar Funcionários')) {
            abort(403, 'Acesso não autorizado');
        }

        $employee = Employee::find($id);

        if (!$employee) {
            abort(403, 'Acesso não autorizado');
        }

        return view('admin.employees.pdf', compact('employee'));
    }

    public function fileImport(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('Criar Funcionários')) {
            abort(403, 'Acesso não autorizado');
        }

        if (!$request->file()) {
            return redirect()
                ->back()
                ->with('error', 'Nenhum arquivo selecionado!');
        }

        Excel::import(new EmployeeImport, $request->file('file')->store('temp'));
        return back()->with('success', 'Importação realizada!');
    }
}
