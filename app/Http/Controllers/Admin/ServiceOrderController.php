<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ServiceOrderModelRequest;
use App\Http\Requests\Admin\ServiceOrderRequest;
use App\Models\Activity;
use App\Models\Client;
use App\Models\Collaborator;
use App\Models\Manager;
use App\Models\ServiceOrder;
use App\Models\ServiceOrderFile;
use App\Models\ServiceOrderObservations;
use App\Models\ServiceOrderPhoto;
use App\Models\Subsidiary;
use App\Models\User;
use App\Models\Views\ServiceOrder as ViewsServiceOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Twilio\Rest\Client as Twilio;
use Image;
use PDF;

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

        $role = Auth::user()->roles->first()->name;

        switch ($role) {
            case 'Colaborador':
            case 'Colaborador Comercial':
            case 'Leiturista':
            case 'Manutenção de Bomba':
                $serviceOrders = ViewsServiceOrder::where('user_id', Auth::user()->id)
                    ->orWhere('author_id', Auth::user()->id)->get();
                break;
            case 'Colaborador-NI':
                $subsidiaries = Collaborator::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                $serviceOrders = ViewsServiceOrder::where('user_id', Auth::user()->id)
                    ->orWhere('author_id', Auth::user()->id)
                    ->orWhereIn('subsidiary_id', $subsidiaries)
                    ->get();
                break;
            case 'Gerente':
                $subsidiaries = Manager::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                $serviceOrders = ViewsServiceOrder::where('user_id', Auth::user()->id)
                    ->orWhere('author_id', Auth::user()->id)
                    ->orWhereIn('subsidiary_id', $subsidiaries)
                    ->get();
                break;
            default:
                $serviceOrders = ViewsServiceOrder::all();
                break;
        }

        if ($request->ajax()) {
            return Datatables::of($serviceOrders)
                ->addIndexColumn()
                ->addColumn('priority', function ($row) {
                    // Baixa,Média,Alta,Urgente
                    switch ($row->priority) {
                        case 'Baixa':
                            $priority = '<span class="text-success fa fa-circle"></span> ' . $row->priority;
                            break;
                        case 'Média':
                            $priority = '<span class="text-warning fa fa-circle"></span> ' . $row->priority;
                            break;
                        case 'Alta':
                            $priority = '<span class="text-danger fa fa-circle"></span> ' . $row->priority;
                            break;
                        case 'Urgente':
                            $priority = '<span class="btn btn-danger font-weight-bold">' . $row->priority . '</span>';
                            break;
                        default:
                            $priority = $row->priority;
                            break;
                    }

                    return $priority;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-xs btn-success mx-1 shadow" title="Visualizar" href="service-orders/' . $row->id . '"><i class="fa fa-lg fa-fw fa-eye"></i></a>' . '<a class="btn btn-xs btn-primary mx-1 shadow" title="Editar" href="service-orders/' . $row->id . '/edit"><i class="fa fa-lg fa-fw fa-pen"></i></a>' .
                        (($row->author_id == Auth::user()->id && Auth::user()->hasAnyRole('Gerente|Colaborador|Colaborador-NI|Colaborador Comercial|Leiturista|Manutenção de Bomba') || Auth::user()->hasAnyRole('Programador|Administrador')) ? '<a class="btn btn-xs btn-danger mx-1 shadow" title="Excluir" href="service-orders/destroy/' . $row->id . '" onclick="return confirm(\'Confirma a exclusão desta ordem de serviço?\')"><i class="fa fa-lg fa-fw fa-trash"></i></a>' : '');
                    return $btn;
                })
                ->rawColumns(['priority', 'action'])
                ->make(true);
        }

        return view('admin.service_order.index');
    }

    public function pending(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('Listar Ordens de Serviço')) {
            abort(403, 'Acesso não autorizado');
        }

        $role = Auth::user()->roles->first()->name;

        $status = ['Concluído', 'Concluído com envio de proposta', 'Cancelado'];

        switch ($role) {
            case 'Colaborador':
            case 'Colaborador Comercial':
            case 'Leiturista':
            case 'Manutenção de Bomba':
                $serviceOrders = ViewsServiceOrder::where('user_id', Auth::user()->id)
                    ->orWhere('author_id', Auth::user()->id)->whereNotIn('status', $status)->get();
                break;
            case 'Colaborador-NI':
                $subsidiaries = Collaborator::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                $serviceOrders = ViewsServiceOrder::where('user_id', Auth::user()->id)
                    ->orWhere('author_id', Auth::user()->id)
                    ->orWhereIn('subsidiary_id', $subsidiaries)
                    ->whereNotIn('status', $status)->get();
                break;
            case 'Gerente':
                $subsidiaries = Manager::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                $serviceOrders = ViewsServiceOrder::where('user_id', Auth::user()->id)
                    ->orWhere('author_id', Auth::user()->id)
                    ->orWhereIn('subsidiary_id', $subsidiaries)
                    ->whereNotIn('status', $status)->get();
                break;
            default:
                $serviceOrders = ViewsServiceOrder::whereNotIn('status', $status)->get();
                break;
        }

        if ($request->ajax()) {
            return Datatables::of($serviceOrders)
                ->addIndexColumn()
                ->addColumn('priority', function ($row) {
                    // Baixa,Média,Alta,Urgente
                    switch ($row->priority) {
                        case 'Baixa':
                            $priority = '<span class="text-success fa fa-circle"></span> ' . $row->priority;
                            break;
                        case 'Média':
                            $priority = '<span class="text-warning fa fa-circle"></span> ' . $row->priority;
                            break;
                        case 'Alta':
                            $priority = '<span class="text-danger fa fa-circle"></span> ' . $row->priority;
                            break;
                        case 'Urgente':
                            $priority = '<span class="btn btn-danger font-weight-bold">' . $row->priority . '</span>';
                            break;
                        default:
                            $priority = $row->priority;
                            break;
                    }

                    return $priority;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-xs btn-success mx-1 shadow" title="Visualizar" href="service-orders/' . $row->id . '"><i class="fa fa-lg fa-fw fa-eye"></i></a>' . '<a class="btn btn-xs btn-primary mx-1 shadow" title="Editar" href="service-orders/' . $row->id . '/edit"><i class="fa fa-lg fa-fw fa-pen"></i></a>' .
                        (($row->author_id == Auth::user()->id && Auth::user()->hasAnyRole('Gerente|Colaborador|Colaborador-NI|Colaborador Comercial|Leiturista|Manutenção de Bomba') || Auth::user()->hasAnyRole('Programador|Administrador')) ? '<a class="btn btn-xs btn-danger mx-1 shadow" title="Excluir" href="service-orders/destroy/' . $row->id . '" onclick="return confirm(\'Confirma a exclusão desta ordem de serviço?\')"><i class="fa fa-lg fa-fw fa-trash"></i></a>' : '');
                    return $btn;
                })
                ->rawColumns(['priority', 'action'])
                ->make(true);
        }

        return view('admin.service_order.pending');
    }

    public function models()
    {
        return view('admin.service_order.models');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(ServiceOrderModelRequest $request)
    {

        if (!Auth::user()->hasPermissionTo('Criar Ordens de Serviço')) {
            abort(403, 'Acesso não autorizado');
        }

        $role = Auth::user()->roles->first()->name;

        switch ($role) {
            case 'Colaborador':
            case 'Colaborador-NI':
            case 'Colaborador Comercial':
            case 'Leiturista':
            case 'Manutenção de Bomba':
                $collaborators = Auth::user()->collaborators->pluck('subsidiary_id');
                $subsidiaries = Subsidiary::whereIn('id', $collaborators)->get();
                $clients = Client::where('trade_status', '!=', 'Restrito')->orderBy('name')->get();
                break;
            case 'Gerente':
                $managers = Auth::user()->managers->pluck('subsidiary_id');
                $subsidiaries = Subsidiary::whereIn('id', $managers)->get();
                $clients = Client::where('trade_status', '!=', 'Restrito')->orderBy('name')->get();
                break;
            default:
                $subsidiaries = Subsidiary::all();
                $clients = Client::orderBy('name')->get();
                break;
        }

        $activities = Activity::orderBy('name')->get();
        $participants = User::role(['Gerente', 'Colaborador', 'Colaborador-NI'])
            ->where('id', '!=', Auth::user()->id)
            ->orderBy('name')
            ->get();

        $type = $request->type;

        switch ($request->model) {
            case 'air-block':
                return view('admin.service_order.air-block.create', compact('activities', 'clients', 'participants', 'subsidiaries', 'type'));
                break;
            case 'default':
            default:
                return view('admin.service_order.create', compact('activities', 'clients', 'participants', 'subsidiaries', 'type'));
                break;
        }
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

        if ($data['user_id'] == Auth::user()->id) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Não é possível criar uma OS com você como participante! Atribua-a a outro participante. Caso você seja o executor do serviço, ao menos seu gerente deverá ser o autor da OS para controle.');
        }

        if ($request->observations) {
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
        }

        $data['author'] = Auth::user()->id;

        $serviceOrders = ServiceOrder::whereYear('created_at', date('Y'))->count();
        $data['number_series'] = $serviceOrders + 1 . '/' . date('Y');

        $serviceOrder = ServiceOrder::create($data);

        if ($serviceOrder->save()) {

            // $this->sendSMS($serviceOrder);

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

        $role = Auth::user()->roles->first()->name;

        switch ($role) {
            case 'Colaborador':
            case 'Colaborador Comercial':
            case 'Leiturista':
            case 'Manutenção de Bomba':
                $serviceOrder = ServiceOrder::where('id', $id)
                    ->where(function ($query) {
                        $query->where('user_id', Auth::user()->id)
                            ->orWhere('author', Auth::user()->id);
                    })->first();
                break;
            case 'Colaborador-NI':
                $subsidiaries = Collaborator::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                $serviceOrder = ServiceOrder::where('id', $id)
                    ->where(function ($query) use ($subsidiaries) {
                        $query->where('user_id', Auth::user()->id)
                            ->orWhere('author', Auth::user()->id)
                            ->orWhereIn('subsidiary_id', $subsidiaries);
                    })->first();
                break;
            case 'Gerente':
                $subsidiaries = Manager::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                $serviceOrder = ServiceOrder::where(function ($query) use ($subsidiaries) {
                    $query->where('user_id', Auth::user()->id)
                        ->orWhere('author', Auth::user()->id)
                        ->orWhereIn('subsidiary_id', $subsidiaries);
                })->where('id', $id)->first();
                break;
            default:
                $serviceOrder = ServiceOrder::find($id);
                break;
        }

        if (!$serviceOrder) {
            abort(403, 'Acesso não autorizado');
        }

        $observations = ServiceOrderObservations::where('service_order_id', $serviceOrder->id)->orderBy('date')->get();

        return view('admin.service_order.show', compact('serviceOrder', 'observations'));
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

        $role = Auth::user()->roles->first()->name;

        switch ($role) {
            case 'Colaborador':
            case 'Colaborador Comercial':
            case 'Leiturista':
            case 'Manutenção de Bomba':
                $collaborators = Auth::user()->collaborators->pluck('subsidiary_id');
                $subsidiaries = Subsidiary::whereIn('id', $collaborators)->get();
                $serviceOrder = ServiceOrder::where('id', $id)
                    ->where(function ($query) {
                        $query->where('user_id', Auth::user()->id)
                            ->orWhere('author', Auth::user()->id);
                    })->first();
                $clients = Client::where('trade_status', '!=', 'Restrito')->orderBy('name')->get();
                break;
            case 'Colaborador-NI':
                $collaborators = Auth::user()->collaborators->pluck('subsidiary_id');
                $subsidiaries = Subsidiary::whereIn('id', $collaborators)->get();
                $serviceOrder = ServiceOrder::where('id', $id)
                    ->where(function ($query) use ($subsidiaries) {
                        $query->where('user_id', Auth::user()->id)
                            ->orWhere('author', Auth::user()->id)
                            ->orWhereIn('subsidiary_id', $subsidiaries->pluck('id'));
                    })->first();
                $clients = Client::where('trade_status', '!=', 'Restrito')->orderBy('name')->get();
                break;
            case 'Gerente':
                $managers = Auth::user()->managers->pluck('subsidiary_id');
                $subsidiaries = Subsidiary::whereIn('id', $managers)->get();
                $serviceOrder = ServiceOrder::where(function ($query) use ($subsidiaries) {
                    $query->where('user_id', Auth::user()->id)
                        ->orWhere('author', Auth::user()->id)
                        ->orWhereIn('subsidiary_id', $subsidiaries->pluck('id'));
                })->where('id', $id)->first();
                $clients = Client::where('trade_status', '!=', 'Restrito')->orderBy('name')->get();
                break;
            default:
                $serviceOrder = ServiceOrder::find($id);
                $subsidiaries = Subsidiary::all();
                $clients = Client::orderBy('name')->get();
                break;
        }

        if (!$serviceOrder) {
            abort(403, 'Acesso não autorizado');
        }

        $role = Auth::user()->roles->first()->name;

        $activities = Activity::orderBy('name')->get();
        $participants = User::role(['Gerente', 'Colaborador', 'Colaborador-NI'])
            ->where('id', '!=', Auth::user()->id)
            ->orderBy('name')
            ->get();

        $observations = ServiceOrderObservations::where('service_order_id', $serviceOrder->id)->orderBy('date')->get();

        return view('admin.service_order.edit', compact('serviceOrder', 'activities', 'clients', 'participants', 'subsidiaries', 'observations'));
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

        $role = Auth::user()->roles->first()->name;

        switch ($role) {
            case 'Colaborador':
            case 'Colaborador Comercial':
            case 'Leiturista':
            case 'Manutenção de Bomba':
                $serviceOrder = ServiceOrder::where('id', $id)
                    ->where(function ($query) {
                        $query->where('user_id', Auth::user()->id)
                            ->orWhere('author', Auth::user()->id);
                    })->first();
                break;
            case 'Colaborador-NI':
                $subsidiaries = Collaborator::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                $serviceOrder = ServiceOrder::where('id', $id)
                    ->where(function ($query) use ($subsidiaries) {
                        $query->where('user_id', Auth::user()->id)
                            ->orWhere('author', Auth::user()->id)
                            ->orWhereIn('subsidiary_id', $subsidiaries);
                    })->first();
                break;
            case 'Gerente':
                $subsidiaries = Manager::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                $serviceOrder = ServiceOrder::where(function ($query) use ($subsidiaries) {
                    $query->where('user_id', Auth::user()->id)
                        ->orWhere('author', Auth::user()->id)
                        ->orWhereIn('subsidiary_id', $subsidiaries);
                })->where('id', $id)->first();
                break;
            default:
                $serviceOrder = ServiceOrder::find($id);
                break;
        }

        if (!$serviceOrder) {
            abort(403, 'Acesso não autorizado');
        }

        // if (Auth::user()->hasAnyRole('Gerente|Colaborador|Colaborador-NI')) {
        //     if ($serviceOrder->author == Auth::user()->id) {
        //         $data = $request->all();
        //     } else {
        //         $data = $request->only(['status', 'costumer_signature', 'readiness_date', 'start_time', 'end_time']);
        //     }
        // } else {
        //     $data = $request->all();
        // }

        $data = $request->all();
        if ($request->observations) {
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
        }

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

        if ($request->photos) {
            $validator = Validator::make($request->only('photos'), ['photos.*' => 'image']);
            if ($validator->fails() === true) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Todas as imagens devem ser do tipo jpg, jpeg ou png.');
            }

            foreach ($request->photos as $image) {
                $serviceOrderPhoto = new ServiceOrderPhoto();
                $serviceOrderPhoto->service_order_id = $serviceOrder->id;

                $name = time();
                $extension = $image->extension();
                $nameFile = "{$name}.{$extension}";

                $destinationPath = storage_path() . '/app/public/service-orders/photos/';
                $img = Image::make($image);
                $img->save($destinationPath . '/' . $nameFile);

                $serviceOrderPhoto->photo = 'service-orders/photos/' . $nameFile;
                $serviceOrderPhoto->user_id = Auth::user()->id;
                $serviceOrderPhoto->save();
                unset($serviceOrderPhoto);
            }
        }

        if ($request->file('files') != null) {
            $validator = Validator::make($request->only('files'), ['files.*' => 'file|mimes:pdf|max:125000']);
            if ($validator->fails() === true) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Todos os arquivos devem ser pdf com no máximo 1GB total');
            }

            $files = $request->file('files');

            foreach ($files as $file) {
                $serviceOrderFile = new ServiceOrderFile();
                $serviceOrderFile->service_order_id = $serviceOrder->id;
                $path = Storage::putFile('service-orders/files', $file);
                $serviceOrderFile->file = $path;
                $serviceOrderFile->user_id = Auth::user()->id;
                $serviceOrderFile->save();
                unset($serviceOrderFile);
            }
        }

        $observations = [];
        $oi = 0;
        foreach ($data as $key => $value) {
            if (preg_match("/observation_(\d)$/", $key)) {
                if (strlen($value) > 0) {
                    $observations[$oi]['text'] = Str::limit($value, 400000);
                    $observations[$oi]['date'] = $request->{$key . "_date"};
                    $oi++;
                }
            }
        }
        if ($serviceOrder->update($data)) {

            ServiceOrderObservations::where('service_order_id', $serviceOrder->id)->delete();

            foreach ($observations as $observation) {
                $item = new ServiceOrderObservations();
                $item->observation = $observation['text'];
                $item->user_id = Auth::user()->id;
                $item->service_order_id = $serviceOrder->id;
                $item->date = $observation['date'];
                $item->save();
            }
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

        if (Auth::user()->hasAnyRole('Gerente|Colaborador|Colaborador-NI')) {
            $serviceOrder = ServiceOrder::where('id', $id)
                ->where('author', Auth::user()->id)
                ->first();
        } else {
            $serviceOrder = ServiceOrder::find($id);
        }

        if (!$serviceOrder) {
            abort(403, 'Acesso não autorizado');
        }

        if ($serviceOrder->delete()) {
            ServiceOrderPhoto::where('service_order_id', $serviceOrder->id)->delete();
            ServiceOrderFile::where('service_order_id', $serviceOrder->id)->delete();
            ServiceOrderObservations::where('service_order_id', $serviceOrder->id)->delete();
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

        $observations = ServiceOrderObservations::where('service_order_id', $serviceOrder->id)->orderBy('date')->get();

        return view('admin.service_order.pdf', compact('serviceOrder', 'observations'));
    }

    private function sendSMS(ServiceOrder $order)
    {
        $user = User::find($order->user_id);
        if ($user->cell) {
            $orderUrl = url("/admin/service-orders/{$order->id}");
            $text = ": - Nova OS para a sua execução criada pelo {$order->author->name}. Serviço:  {$order->activity->name} - Prioridade: {$order->priority} - Cliente: {$order->client->name} - Prazo: {$order->deadline}. Detalhes: {$orderUrl}";

            $receiverNumber = $user->routeNotificationForWhatsApp();
            $message = $text;

            $account_sid = env("TWILIO_AUTH_SID");
            $auth_token = env("TWILIO_AUTH_TOKEN");
            $twilio_number = env("TWILIO_PHONE_NUMBER_SID");

            $client = new Twilio($account_sid, $auth_token);
            $client->messages->create($receiverNumber, [
                'from' => $twilio_number,
                'body' => $message
            ]);
        }
    }

    public function photoDelete(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('Editar Ordens de Serviço')) {
            abort(403, 'Acesso não autorizado');
        }

        $photo = ServiceOrderPhoto::find($request->id);
        if ($photo) {
            $photo->delete();
            return response()->json(['message' => 'success']);
        } else {
            return response()->json(['message' => 'fail']);
        }
    }

    public function fileDelete(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('Editar Ordens de Serviço')) {
            abort(403, 'Acesso não autorizado');
        }

        $file = ServiceOrderFile::find($request->id);
        if ($file) {
            $file->delete();
            return response()->json(['message' => 'success']);
        } else {
            return response()->json(['message' => 'fail']);
        }
    }

    public function print(int $id)
    {
        if (!Auth::user()->hasPermissionTo('Listar Ordens de Serviço')) {
            abort(403, 'Acesso não autorizado');
        }

        $serviceOrder = ServiceOrder::find($id);

        $data = [
            'serviceOrder' => $serviceOrder,
        ];

        switch ($serviceOrder->type) {
            case 'air-block':
                $pdf = PDF::loadView('admin.service_order.air-block.pdf', $data);
                break;
            default:
                $pdf = PDF::loadView('admin.service_order.air-block.pdf', $data);
                break;
        }

        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();

        $canvas = $dom_pdf->getCanvas();
        $canvas->page_text(0, 0, null, null, 10);

        return $pdf->download(Str::slug($serviceOrder->id) . '.pdf');
    }
}
