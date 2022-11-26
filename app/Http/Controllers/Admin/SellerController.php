<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SellerRequest;
use App\Models\Commission;
use App\Models\Financier;
use App\Models\Manager;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Image;
use DataTables;

class SellerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('Listar Vendedores')) {
            abort(403, 'Acesso não autorizado');
        }

        $sellers = Seller::all();

        if ($request->ajax()) {
            return Datatables::of($sellers)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-xs btn-warning mx-1 shadow" title="Comissões" href="sellers/commissions/' . $row->id . '"><i class="fa fa-lg fa-fw fa-coins"></i></a>' . '<a class="btn btn-xs btn-primary mx-1 shadow" title="Editar" href="sellers/' . $row->id . '/edit"><i class="fa fa-lg fa-fw fa-pen"></i></a>' . '<a class="btn btn-xs btn-danger mx-1 shadow" title="Excluir" href="sellers/destroy/' . $row->id . '" onclick="return confirm(\'Confirma a exclusão deste vendedor?\')"><i class="fa fa-lg fa-fw fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.sellers.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->hasPermissionTo('Criar Vendedores')) {
            abort(403, 'Acesso não autorizado');
        }

        return view('admin.sellers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SellerRequest $request)
    {
        if (!Auth::user()->hasPermissionTo('Criar Vendedores')) {
            abort(403, 'Acesso não autorizado');
        }

        $data = $request->all();

        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $name = Str::slug(mb_substr($data['name'], 0, 100)) . time();
            $extension = $request->photo->extension();
            $nameFile = "{$name}.{$extension}";

            $data['photo'] = $nameFile;

            $destinationPath = storage_path() . '/app/public/sellers';
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

        $data['user_id'] = Auth::user()->id;

        $seller = Seller::create($data);

        if ($seller->save()) {
            return redirect()
                ->route('admin.sellers.index')
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
        if (!Auth::user()->hasPermissionTo('Editar Vendedores')) {
            abort(403, 'Acesso não autorizado');
        }

        $seller = Seller::find($id);

        if (!$seller) {
            abort(403, 'Acesso não autorizado');
        }

        return view('admin.sellers.edit', compact('seller'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SellerRequest $request, $id)
    {
        if (!Auth::user()->hasPermissionTo('Editar Vendedores')) {
            abort(403, 'Acesso não autorizado');
        }

        $seller = Seller::find($id);

        if (!$seller) {
            abort(403, 'Acesso não autorizado');
        }

        $data = $request->all();

        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $name = Str::slug(mb_substr($data['name'], 0, 200)) . "-" . time();
            $imagePath = storage_path() . '/app/public/sellers/' . $seller->photo;

            if (File::isFile($imagePath)) {
                unlink($imagePath);
            }

            $extension = $request->photo->extension();
            $nameFile = "{$name}.{$extension}";

            $data['photo'] = $nameFile;

            $destinationPath = storage_path() . '/app/public/sellers';
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

        if ($seller->update($data)) {
            return redirect()
                ->route('admin.sellers.index')
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
        if (!Auth::user()->hasPermissionTo('Excluir Vendedores')) {
            abort(403, 'Acesso não autorizado');
        }

        $seller = Seller::find($id);

        if (!$seller) {
            abort(403, 'Acesso não autorizado');
        }

        $imagePath = storage_path() . '/app/public/sellers/' . $seller->photo;
        if ($seller->delete()) {
            if (File::isFile($imagePath)) {
                unlink($imagePath);
                $user->photo = null;
                $user->update();
            }

            return redirect()
                ->route('admin.sellers.index')
                ->with('success', 'Exclusão realizada!');
        } else {
            return redirect()
                ->back()
                ->with('error', 'Erro ao excluir!');
        }
    }

    public function commissions(Request $request, $id)
    {
        if (!Auth::user()->hasPermissionTo('Listar Comissões')) {
            abort(403, 'Acesso não autorizado');
        }

        $seller = Seller::find($id);

        if (!$seller) {
            abort(403, 'Acesso não autorizado');
        }

        $role = Auth::user()->roles->first()->name;

        switch ($role) {
            case 'Financeiro':
                $subsidiaries = Financier::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                $commissions = Commission::where('seller_id', $seller->id)->whereIn('subsidiary_id', $subsidiaries)->get();
                break;
            case 'Gerente':
                $subsidiaries = Manager::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                $commissions = Commission::where('seller_id', $seller->id)->whereIn('subsidiary_id', $subsidiaries)->get();
                break;
            default:
                $commissions = Commission::where('seller_id', $seller->id)->get();
                break;
        }

        $payValue = Commission::where('status', 'pago')->whereIn('id', $commissions->pluck('id'))->sum('total_value');
        $pay = 'R$ ' . \number_format($payValue, 2, ',', '.');

        $receiveValue = Commission::where('status', 'pendente')->whereIn('id', $commissions->pluck('id'))->sum('total_value');
        $receive = 'R$ ' . \number_format($receiveValue, 2, ',', '.');

        $balance = 'R$ ' . \number_format($payValue - $receiveValue, 2, ',', '.');

        if ($request->ajax()) {
            return Datatables::of($commissions)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-xs btn-success mx-1 shadow" title="Recibo" href="' . route('admin.commissions.receipt', ['id' => $row->id]) . '" target="_blank"><i class="fa fa-lg fa-fw fa-file-invoice-dollar"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.sellers.commissions', compact('pay', 'receive', 'balance', 'seller'));
    }
}
