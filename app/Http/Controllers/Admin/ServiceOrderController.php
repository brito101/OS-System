<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ServiceOrderRequest;
use App\Models\Activity;
use App\Models\Client;
use App\Models\ServiceOrder;
use App\Models\User;
use App\Models\Views\ServiceOrder as ViewsServiceOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use DataTables;

class ServiceOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('Listar Ordens de Serviço')) {
            abort(403, 'Acesso não autorizado');
        }

        $serviceOrders = ViewsServiceOrder::all();

        if ($request->ajax()) {
            return Datatables::of($serviceOrders)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-xs btn-success mx-1 shadow" title="Visualizar" href="service-orders/' . $row->id . '"><i class="fa fa-lg fa-fw fa-eye"></i></a>' . '<a class="btn btn-xs btn-primary mx-1 shadow" title="Editar" href="service-orders/' . $row->id . '/edit"><i class="fa fa-lg fa-fw fa-pen"></i></a>' . '<a class="btn btn-xs btn-danger mx-1 shadow" title="Excluir" href="service-orders/destroy/' . $row->id . '" onclick="return confirm(\'Confirma a exclusão desta ordem de serviço?\')"><i class="fa fa-lg fa-fw fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.service_order.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->hasPermissionTo('Criar Ordens de Serviço')) {
            abort(403, 'Acesso não autorizado');
        }

        $activities = Activity::orderBy('name')->get();
        $clients = Client::orderBy('name')->get();
        $participants = User::role(['Gerente', 'Colaborador'])->orderBy('name')->get();
        return view('admin.service_order.create', compact('activities', 'clients', 'participants'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ServiceOrderRequest $request)
    {
        if (!Auth::user()->hasPermissionTo('Criar Ordens de Serviço')) {
            abort(403, 'Acesso não autorizado');
        }

        $data = $request->all();

        $observations = $request->observations;
        $dom = new \DOMDocument();
        $dom->encoding = 'utf-8';
        $dom->loadHTML(utf8_decode($observations), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD | LIBXML_NOERROR | LIBXML_NOWARNING);
        $imageFile = $dom->getElementsByTagName('img');

        foreach ($imageFile as $item => $image) {
            $img = $image->getAttribute('src');
            if (filter_var($img, FILTER_VALIDATE_URL) == false) {
                list($type, $img) = explode(';', $img);
                list(, $img) = explode(',', $img);
                $imageData = base64_decode($img);
                $image_name =  Str::slug($request->title) . '-' . time() . $item . '.png';
                $path = storage_path() . '/app/public/observations/' . $image_name;
                file_put_contents($path, $imageData);
                $image->removeAttribute('src');
                $image->removeAttribute('data-filename');
                $image->setAttribute('alt', $request->title);
                $image->setAttribute('src', url('storage/observations/' . $image_name));
            }
        }

        $observations = $dom->saveHTML();
        $data['observations'] = $observations;

        $serviceOrder = ServiceOrder::create($data);

        if ($serviceOrder->save()) {
            return redirect()
                ->route('admin.service-orders.index')
                ->with('success', 'Cadastro realizado!');
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Erro ao cadastrar!');
        }
    }

    public function show($id)
    {
        if (!Auth::user()->hasPermissionTo('Acessar Ordens de Serviço')) {
            abort(403, 'Acesso não autorizado');
        }

        $serviceOrder = ServiceOrder::find($id);

        if (!$serviceOrder) {
            abort(403, 'Acesso não autorizado');
        }

        return view('admin.service_order.show', compact('serviceOrder'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Auth::user()->hasPermissionTo('Editar Ordens de Serviço')) {
            abort(403, 'Acesso não autorizado');
        }

        $serviceOrder = ServiceOrder::find($id);

        if (!$serviceOrder) {
            abort(403, 'Acesso não autorizado');
        }

        $activities = Activity::orderBy('name')->get();
        $clients = Client::orderBy('name')->get();
        $participants = User::role(['Gerente', 'Colaborador'])->orderBy('name')->get();

        return view('admin.service_order.edit', compact('serviceOrder', 'activities', 'clients', 'participants'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ServiceOrderRequest $request, $id)
    {
        if (!Auth::user()->hasPermissionTo('Editar Ordens de Serviço')) {
            abort(403, 'Acesso não autorizado');
        }

        $serviceOrder = ServiceOrder::find($id);

        if (!$serviceOrder) {
            abort(403, 'Acesso não autorizado');
        }

        $data = $request->all();

        $observations = $request->observations;
        $dom = new \DOMDocument();
        $dom->encoding = 'utf-8';
        $dom->loadHTML(utf8_decode($observations), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD | LIBXML_NOERROR | LIBXML_NOWARNING);
        $imageFile = $dom->getElementsByTagName('img');

        foreach ($imageFile as $item => $image) {
            $img = $image->getAttribute('src');
            if (filter_var($img, FILTER_VALIDATE_URL) == false) {
                list($type, $img) = explode(';', $img);
                list(, $img) = explode(',', $img);
                $imageData = base64_decode($img);
                $image_name =  Str::slug($request->title) . '-' . time() . $item . '.png';
                $path = storage_path() . '/app/public/observations/' . $image_name;
                file_put_contents($path, $imageData);
                $image->removeAttribute('src');
                $image->removeAttribute('data-filename');
                $image->setAttribute('alt', $request->title);
                $image->setAttribute('src', url('storage/observations/' . $image_name));
            }
        }

        $observations = $dom->saveHTML();
        $data['observations'] = $observations;

        if ($request->costumer_signature) {
            $folderPath = storage_path() . '/app/public/signatures/';
            $image_parts = explode(";base64,", $request->costumer_signature);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $fileName = uniqid() . '.' . $image_type;
            $file = $folderPath . $fileName;
            file_put_contents($file, $image_base64);
            $data['costumer_signature'] = $fileName;
        }

        if ($serviceOrder->update($data)) {
            return redirect()
                ->route('admin.service-orders.index')
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
        if (!Auth::user()->hasPermissionTo('Excluir Ordens de Serviço')) {
            abort(403, 'Acesso não autorizado');
        }

        $serviceOrder = ServiceOrder::find($id);

        if (!$serviceOrder) {
            abort(403, 'Acesso não autorizado');
        }

        if ($serviceOrder->delete()) {
            return redirect()
                ->route('admin.service-orders.index')
                ->with('success', 'Exclusão realizada!');
        } else {
            return redirect()
                ->back()
                ->with('error', 'Erro ao excluir!');
        }
    }

    public function pdf($id)
    {
        if (!Auth::user()->hasPermissionTo('Acessar Ordens de Serviço')) {
            abort(403, 'Acesso não autorizado');
        }

        $serviceOrder = ServiceOrder::find($id);

        if (!$serviceOrder) {
            abort(403, 'Acesso não autorizado');
        }

        return view('admin.service_order.pdf', compact('serviceOrder'));
    }
}
