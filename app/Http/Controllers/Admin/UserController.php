<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Models\User;
use App\Models\Views\User as ViewsUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Image;
use DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('Listar Usuários')) {
            abort(403, 'Acesso não autorizado');
        }

        if (Auth::user()->hasRole('Programador')) {
            $users = ViewsUser::all('id', 'name', 'email', 'type');
        } elseif (Auth::user()->hasRole('Administrador')) {
            $users = ViewsUser::where('type', '!=', 'Programador')->get();
        } else {
            $users = null;
        }

        if ($request->ajax()) {
            return Datatables::of($users)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-xs btn-primary mx-1 shadow" title="Editar" href="users/' . $row->id . '/edit"><i class="fa fa-lg fa-fw fa-pen"></i></a>' . '<a class="btn btn-xs btn-danger mx-1 shadow" title="Excluir" href="users/destroy/' . $row->id . '" onclick="return confirm(\'Confirma a exclusão deste usuário?\')"><i class="fa fa-lg fa-fw fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->hasPermissionTo('Criar Usuários')) {
            abort(403, 'Acesso não autorizado');
        }
        if (Auth::user()->hasRole('Programador')) {
            $roles = Role::orderBy('name')->get();
        } elseif (Auth::user()->hasRole('Administrador')) {
            $roles = Role::where('name', '!=', 'Programador')->orderBy('name')->get();
        } else {
            $roles = [];
        }
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        if (!Auth::user()->hasPermissionTo('Criar Usuários')) {
            abort(403, 'Acesso não autorizado');
        }

        $data = $request->all();
        $data['password'] = bcrypt($request->password);

        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $name = Str::slug(mb_substr($data['name'], 0, 100)) . time();
            $extension = $request->photo->extension();
            $nameFile = "{$name}.{$extension}";

            $data['photo'] = $nameFile;

            $destinationPath = storage_path() . '/app/public/users';
            $img = Image::make($request->photo);
            $img->resize(null, 100, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->crop(100, 100)->save($destinationPath . '/' . $nameFile);

            if (!$img) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Falha ao fazer o upload da imagem');
            }
        }

        $user = User::create($data);

        if ($user->save()) {
            if (!empty($request->role)) {
                $user->syncRoles($request->role);
                $user->save();
            }
            return redirect()
                ->route('admin.users.index')
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
    public function edit($id = null)
    {

        if ($id && !Auth::user()->hasPermissionTo('Editar Usuários')) {
            abort(403, 'Acesso não autorizado');
        }

        if (is_null($id) && !Auth::user()->hasPermissionTo('Editar Usuário')) {
            abort(403, 'Acesso não autorizado');
        }

        if (is_null($id)) {
            $id = Auth::user()->id;
        }

        if (Auth::user()->hasRole('Programador')) {
            $roles = Role::orderBy('name')->get();
            $user = User::where('id', $id)->first();
        } elseif (Auth::user()->hasRole('Administrador')) {
            $roles = Role::where('name', '!=', 'Programador')->orderBy('name')->get();
            $user = User::where('id', $id)->first();
        } else {
            $roles = [];
            $user = User::where('id', $id)->first();
        }

        if (empty($user->id)) {
            abort(403, 'Acesso não autorizado');
        }
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        if (!Auth::user()->hasAnyPermission(['Editar Usuários', 'Editar Usuário'])) {
            abort(403, 'Acesso não autorizado');
        }

        $data = $request->all();

        if (Auth::user()->hasPermissionTo('Editar Usuários')) {
            $user = User::where('id', $id)->first();
        }

        if (empty($user->id) && Auth::user()->hasPermissionTo('Editar Usuário')) {
            $id = Auth::user()->id;
            $user = User::where('id', $id)->first();
        }

        if (empty($user->id)) {
            abort(403, 'Acesso não autorizado');
        }

        if (!empty($data['password'])) {
            $data['password'] = bcrypt($request->password);
        } else {
            $data['password'] = $user->password;
        }

        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $name = Str::slug(mb_substr($data['name'], 0, 200)) . "-" . time();
            $imagePath = storage_path() . '/app/public/users/' . $user->photo;

            if (File::isFile($imagePath)) {
                unlink($imagePath);
            }

            $extension = $request->photo->extension();
            $nameFile = "{$name}.{$extension}";

            $data['photo'] = $nameFile;

            $destinationPath = storage_path() . '/app/public/users';
            $img = Image::make($request->photo);
            $img->resize(null, 100, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->crop(100, 100)->save($destinationPath . '/' . $nameFile);

            if (!$img)
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Falha ao fazer o upload da imagem');
        }

        if ($user->update($data)) {
            if (!empty($request->role)) {
                $user->syncRoles($request->role);
                $user->save();
            }

            if (Auth::user()->hasPermissionTo('Editar Usuários')) {
                return redirect()
                    ->route('admin.users.index')
                    ->with('success', 'Atualização realizada!');
            } else {
                return redirect()
                    ->route('admin.user.edit')
                    ->with('success', 'Atualização realizada!');
            }
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
        if (!Auth::user()->hasPermissionTo('Excluir Usuários')) {
            abort(403, 'Acesso não autorizado');
        }

        $user = User::where('id', $id)->first();

        if (empty($user->id)) {
            abort(403, 'Acesso não autorizado');
        }

        $imagePath = storage_path() . '/app/public/users/' . $user->photo;
        if ($user->delete()) {
            if (File::isFile($imagePath)) {
                unlink($imagePath);
                $user->photo = null;
                $user->update();
            }

            return redirect()
                ->route('admin.users.index')
                ->with('success', 'Exclusão realizada!');
        } else {
            return redirect()
                ->back()
                ->with('error', 'Erro ao excluir!');
        }
    }
}
