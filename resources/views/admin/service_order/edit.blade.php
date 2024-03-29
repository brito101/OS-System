@extends('adminlte::page')
@section('plugins.select2', true)
@section('plugins.Summernote', true)
@section('plugins.BsCustomFileInput', true)

@section('adminlte_css')
    <style>
        .kbw-signature {
            display: inline-block;
            -ms-touch-action: none;
            width: 100%;
            height: 200px;
            border: 0;
            border: 1px solid #ced4da;
            border-radius: .25rem;
            box-shadow: inset 0 0 0 transparent;
            max-width: 100%;
        }
    </style>
@endsection

@section('title', '- Edição de Ordem de Serviço')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-list"></i> Editar Ordem de Serviço nº
                        {{ $serviceOrder->number_series }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.service-orders.index') }}">Ordens de
                                Serviço</a>
                        </li>
                        <li class="breadcrumb-item active">Editar Ordem de Serviço</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    @include('components.alert')

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Dados Cadastrais da Ordem de Serviço</h3>
                        </div>

                        <div class="card-body pb-0 pt-1 text-muted text-right">Criada
                            {{ isset($serviceOrder->author->name) ? 'por ' . $serviceOrder->author->name : '' }} em
                            {{ $serviceOrder->created_at }} hs.</div>

                        <form method="POST"
                            action="{{ route('admin.service-orders.update', ['service_order' => $serviceOrder->id]) }}"
                            enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <input type="hidden" name="id" value="{{ $serviceOrder->id }}">
                            <div class="card-body">

                                @if (
                                    (isset($serviceOrder->author->id) && $serviceOrder->author->id == Auth::user()->id) ||
                                        Auth::user()->hasRole('Programador|Administrador'))

                                    <div class="d-flex flex-wrap justify-content-between">
                                        <div class="col-12 form-group px-0 mb-0">
                                            <label for="activity_id">Atividade</label>
                                            <x-adminlte-select2 name="activity_id" required>
                                                <option disabled selected value="">Selecione</option>
                                                @foreach ($activities as $activity)
                                                    <option
                                                        {{ old('activity_id') == $activity->id ? 'selected' : ($serviceOrder->activity_id == $activity->id ? 'selected' : '') }}
                                                        value="{{ $activity->id }}">{{ $activity->name }}</option>
                                                @endforeach
                                            </x-adminlte-select2>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-wrap justify-content-between">
                                        <div class="col-12 form-group px-0 mb-0">
                                            <label for="client_id">Cliente</label>
                                            <x-adminlte-select2 name="client_id" required>
                                                <option disabled selected value="">Selecione</option>
                                                @foreach ($clients as $client)
                                                    <option
                                                        {{ old('client_id') == $client->id ? 'selected' : ($serviceOrder->client_id == $client->id ? 'selected' : '') }}
                                                        value="{{ $client->id }}">{{ $client->name }}
                                                        ({{ $client->document_person }})
                                                    </option>
                                                @endforeach
                                            </x-adminlte-select2>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-wrap justify-content-between">
                                        <div class="col-12 form-group px-0">
                                            <label for="description">Descrição do Serviço</label>
                                            <textarea name="description" rows="2" class="form-control" id="description">{{ old('description') ?? $serviceOrder->description }}</textarea>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-wrap justify-content-between">
                                        <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                            <label for="zipcode">CEP</label>
                                            <input type="tel" class="form-control" id="zipcode" placeholder="CEP"
                                                name="zipcode" value="{{ old('zipcode') ?? $serviceOrder->zipcode }}"
                                                required>
                                        </div>
                                        <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                            <label for="street">Rua</label>
                                            <input type="text" class="form-control" id="street" placeholder="Rua"
                                                name="street" value="{{ old('street') ?? $serviceOrder->street }}"
                                                required>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-wrap justify-content-between">
                                        <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                            <label for="number">Número</label>
                                            <input type="text" class="form-control" id="number" placeholder="Número"
                                                name="number" value="{{ old('number') ?? $serviceOrder->number }}"
                                                required>
                                        </div>
                                        <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                            <label for="complement">Complemento</label>
                                            <input type="text" class="form-control" id="complement"
                                                placeholder="Complemento" name="complement"
                                                value="{{ old('complement') ?? $serviceOrder->complement }}">
                                        </div>
                                    </div>

                                    <div class="d-flex flex-wrap justify-content-between">
                                        <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                            <label for="neighborhood">Bairro</label>
                                            <input type="text" class="form-control" id="neighborhood"
                                                placeholder="Bairro" name="neighborhood"
                                                value="{{ old('neighborhood') ?? $serviceOrder->neighborhood }}" required>
                                        </div>
                                        <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                            <label for="city">Cidade</label>
                                            <input type="text" class="form-control" id="city" placeholder="Cidade"
                                                name="city" value="{{ old('city') ?? $serviceOrder->city }}" required>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-wrap justify-content-between">
                                        <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                            <label for="state">Estado</label>
                                            <input type="text" class="form-control" id="state" placeholder="UF"
                                                name="state" value="{{ old('state') ?? $serviceOrder->state }}"
                                                required>
                                        </div>

                                        <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                            <label for="telephone">Telefone de Contato</label>
                                            <input type="text" class="form-control" id="telephone"
                                                placeholder="nº para contato" name="telephone"
                                                value="{{ old('telephone') ?? $serviceOrder->telephone }}">
                                        </div>
                                    </div>

                                    <div class="d-flex flex-wrap justify-content-between">
                                        <div class="col-12 form-group px-0 mb-0">
                                            <label for="user_id">Participante</label>
                                            <x-adminlte-select2 name="user_id" required>
                                                <option disabled selected value="">Selecione</option>
                                                @foreach ($participants as $participant)
                                                    <option
                                                        {{ old('user_id') == $participant->id ? 'selected' : ($serviceOrder->user_id == $participant->id ? 'selected' : '') }}
                                                        value="{{ $participant->id }}">{{ $participant->name }}
                                                        ({{ $participant->roles->first()->name }})
                                                    </option>
                                                @endforeach
                                            </x-adminlte-select2>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-wrap justify-content-between">
                                        <div class="col-12 form-group px-0">
                                            <label for="subsidiary_id">Filial</label>
                                            <x-adminlte-select2 name="subsidiary_id">
                                                @foreach ($subsidiaries as $subsidiary)
                                                    <option
                                                        {{ old('subsidiary_id') == $subsidiary->id ? 'selected' : ($serviceOrder->subsidiary_id == $subsidiary->id ? 'selected' : '') }}
                                                        value="{{ $subsidiary->id }}">{{ $subsidiary->alias_name }}
                                                    </option>
                                                @endforeach
                                            </x-adminlte-select2>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-wrap justify-content-between">
                                        <div class="col-12 col-md-6 form-group px-0 pr-md-2 mb-0">
                                            <label for="priority">Prioridade</label>
                                            <x-adminlte-select2 name="priority" required>
                                                <option
                                                    {{ old('priority') == 'Baixa' ? 'selected' : ($serviceOrder->priority == 'Baixa' ? 'selected' : '') }}
                                                    value="Baixa">
                                                    Baixa</option>
                                                <option
                                                    {{ old('priority') == 'Média' ? 'selected' : ($serviceOrder->priority == 'Média' ? 'selected' : '') }}
                                                    value="Média">
                                                    Média</option>
                                                <option
                                                    {{ old('priority') == 'Alta' ? 'selected' : ($serviceOrder->priority == 'Alta' ? 'selected' : '') }}
                                                    value="Alta">
                                                    Alta</option>
                                                <option
                                                    {{ old('priority') == 'Urgente' ? 'selected' : ($serviceOrder->priority == 'Urgente' ? 'selected' : '') }}
                                                    value="Urgente">
                                                    Urgente</option>
                                            </x-adminlte-select2>
                                        </div>

                                        <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                            <label for="execution_date">Data de Execução</label>
                                            <input type="text" class="form-control date" id="execution_date"
                                                placeholder="dd/mm/yyyy" name="execution_date"
                                                value="{{ old('execution_date') ?? $serviceOrder->execution_date }}"
                                                required>
                                        </div>

                                        <div class="col-12 col-md-3 form-group px-0 pl-md-2">
                                            <label for="deadline">Data Limite</label>
                                            <input type="text" class="form-control date" id="deadline"
                                                placeholder="dd/mm/yyyy" name="deadline"
                                                value="{{ old('deadline') ?? $serviceOrder->deadline }}" required>
                                        </div>
                                    </div>

                                    @php
                                        $config = [
                                            'height' => '100',
                                            'toolbar' => [
                                                // [groupName, [list of button]]
                                                ['style', ['bold', 'italic', 'underline', 'clear']],
                                                ['font', ['strikethrough', 'superscript', 'subscript']],
                                                ['fontsize', ['fontsize']],
                                                ['color', ['color']],
                                                ['para', ['ul', 'ol', 'paragraph']],
                                                ['height', ['height']],
                                                ['table', ['table']],
                                                ['insert', ['link', 'picture', 'video']],
                                                ['view', ['fullscreen', 'codeview', 'help']],
                                            ],
                                        ];
                                    @endphp
                                    <div class="d-flex flex-wrap justify-content-between">
                                        <div class="col-12 form-group px-0 mb-0">
                                            <x-adminlte-text-editor name="observations" label="Observações"
                                                label-class="text-black" igroup-size="md" placeholder="Observações..."
                                                :config="$config">
                                                {!! $serviceOrder->observations !!}
                                            </x-adminlte-text-editor>
                                        </div>
                                    </div>
                                @else
                                    <input type="hidden" id="client_id" name="client_id"
                                        value="{{ $serviceOrder->client_id }}">
                                    <input type="hidden" id="activity_id" name="activity_id"
                                        value="{{ $serviceOrder->activity_id }}">
                                    <input type="hidden" id="user_id" name="user_id"
                                        value="{{ $serviceOrder->user_id }}">
                                    <input type="hidden" id="priority" name="priority"
                                        value="{{ $serviceOrder->priority }}">
                                    <input type="hidden" id="subsidiary_id" name="subsidiary_id"
                                        value="{{ $serviceOrder->subsidiary_id }}">

                                    <div class="d-flex flex-wrap justify-content-between">
                                        <div class="col-12 form-group px-0">
                                            <label for="activity">Atividade</label>
                                            <input type="text" class="form-control" id="activity" name="activity"
                                                value="{{ $serviceOrder->activity->name }}" disabled>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-wrap justify-content-between">
                                        <div class="col-12  form-group px-0">
                                            <label for="client">Cliente</label>
                                            <input type="text" class="form-control " id="client" name="client"
                                                value="{{ $serviceOrder->client->name }}" disabled>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-wrap justify-content-between">
                                        <div class="col-12 form-group px-0">
                                            <label for="description">Descrição do Serviço</label>
                                            <textarea name="description" rows="2" class="form-control " id="description" disabled>{{ $serviceOrder->description }}</textarea>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-wrap justify-content-between">
                                        <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                            <label for="zipcode">CEP</label>
                                            <input type="text" class="form-control " id="zipcode" name="zipcode"
                                                value="{{ $serviceOrder->zipcode }}" disabled>
                                        </div>
                                        <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                            <label for="street">Rua</label>
                                            <input type="text" class="form-control " id="street" name="street"
                                                value="{{ $serviceOrder->street }}" disabled>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-wrap justify-content-between">
                                        <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                            <label for="number">Número</label>
                                            <input type="text" class="form-control " id="number" name="number"
                                                value="{{ $serviceOrder->number }}" disabled>
                                        </div>
                                        <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                            <label for="complement">Complemento</label>
                                            <input type="text" class="form-control " id="complement"
                                                name="complement" value="{{ $serviceOrder->complement }}" disabled>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-wrap justify-content-between">
                                        <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                            <label for="neighborhood">Bairro</label>
                                            <input type="text" class="form-control " id="neighborhood"
                                                name="neighborhood" value="{{ $serviceOrder->neighborhood }}" disabled>
                                        </div>
                                        <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                            <label for="city">Cidade</label>
                                            <input type="text" class="form-control " id="city" name="city"
                                                value="{{ $serviceOrder->city }}" disabled>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-wrap justify-content-between">
                                        <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                            <label for="state">Estado</label>
                                            <input type="text" class="form-control " id="state" name="state"
                                                value="{{ $serviceOrder->state }}" disabled>
                                        </div>

                                        <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                            <label for="telephone">Telefone de Contato</label>
                                            <input type="text" class="form-control " id="telephone" name="telephone"
                                                value="{{ $serviceOrder->telephone }}" disabled>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-wrap justify-content-between">
                                        <div class="col-12 form-group px-0">
                                            <label for="user_id">Participante</label>
                                            <input type="text" class="form-control " id="user_id" name="user_id"
                                                value="{{ $serviceOrder->user->name }} ({{ $serviceOrder->user->roles->first()->name }})"
                                                disabled>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-wrap justify-content-between">
                                        <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                            <label for="priority_name">Prioridade</label>
                                            <input type="text" class="form-control " id="priority_name"
                                                name="priority_name" value="{{ $serviceOrder->priority }}" disabled>
                                        </div>

                                        <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                            <label for="execution_date">Data de Execução</label>
                                            <input type="text" class="form-control " id="execution_date"
                                                name="execution_date" value="{{ $serviceOrder->execution_date }}"
                                                disabled>
                                        </div>

                                        <div class="col-12 col-md-3 form-group px-0 pl-md-2">
                                            <label for="deadline">Data Limite</label>
                                            <input type="text" class="form-control " id="deadline" name="deadline"
                                                value="{{ $serviceOrder->execution_date }}" disabled>
                                        </div>
                                    </div>

                                    @if ($serviceOrder->observations)
                                        <div class="d-flex flex-wrap justify-content-between">
                                            <div class="col-12 form-group px-0">
                                                <label for="observations">Observações</label>
                                                <div class="p-2 border rounded bg-gray-light" id="observations">
                                                    {!! $serviceOrder->observations !!}
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                @endif

                                <div class="d-flex flex-wrap justify-content-start">
                                    <div class="col-12 col-md-3 form-group px-0 pr-md-2 mb-0">
                                        <label for="status">Status</label>
                                        <x-adminlte-select2 name="status" required>
                                            <option
                                                {{ old('status') == 'Não iniciado' ? 'selected' : ($serviceOrder->status == 'Não iniciado' ? 'selected' : '') }}
                                                value="Não iniciado">
                                                Não iniciado</option>
                                            <option
                                                {{ old('status') == 'Aguardando orçamento' ? 'selected' : ($serviceOrder->status == 'Aguardando orçamento' ? 'selected' : '') }}
                                                value="Aguardando orçamento">Aguardando orçamento</option>
                                            <option
                                                {{ old('status') == 'Orçamento enviado' ? 'selected' : ($serviceOrder->status == 'Orçamento enviado' ? 'selected' : '') }}
                                                value="Orçamento enviado">Orçamento enviado</option>
                                            <option
                                                {{ old('status') == 'Aguardando laudo' ? 'selected' : ($serviceOrder->status == 'Aguardando laudo' ? 'selected' : '') }}
                                                value="Aguardando laudo">Aguardando laudo</option>
                                            <option
                                                {{ old('status') == 'Laudo enviado' ? 'selected' : ($serviceOrder->status == 'Laudo enviado' ? 'selected' : '') }}
                                                value="Laudo enviado">Laudo enviado</option>
                                            <option
                                                {{ old('status') == 'Atrasado' ? 'selected' : ($serviceOrder->status == 'Atrasado' ? 'selected' : '') }}
                                                value="Atrasado">
                                                Atrasado</option>
                                            <option
                                                {{ old('status') == 'Iniciado' ? 'selected' : ($serviceOrder->status == 'Iniciado' ? 'selected' : '') }}
                                                value="Iniciado">
                                                Iniciado</option>
                                            <option
                                                {{ old('status') == 'Concluído' ? 'selected' : ($serviceOrder->status == 'Concluído' ? 'selected' : '') }}
                                                value="Concluído">
                                                Concluído</option>
                                            <option
                                                {{ old('status') == 'Concluído com envio de proposta' ? 'selected' : ($serviceOrder->status == 'Concluído com envio de proposta' ? 'selected' : '') }}
                                                value="Concluído com envio de proposta">
                                                Concluído com envio de proposta</option>

                                            <option
                                                {{ old('status') == 'Cancelado' ? 'selected' : ($serviceOrder->status == 'Cancelado' ? 'selected' : '') }}
                                                value="Cancelado">
                                                Cancelado</option>
                                        </x-adminlte-select2>
                                    </div>

                                    <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                        <label for="readiness_date">Data de Prontificação</label>
                                        <input type="text" class="form-control date" id="readiness_date"
                                            placeholder="dd/mm/yyyy ou vazio" name="readiness_date"
                                            value="{{ old('readiness_date') ?? $serviceOrder->readiness_date }}">
                                    </div>

                                    <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                        <label for="start_time">Horário de Início</label>
                                        <input type="time" class="form-control" id="start_time"
                                            placeholder="HH:mm ou vazio" name="start_time"
                                            value="{{ old('start_time') ?? $serviceOrder->start_time }}">
                                    </div>

                                    <div class="col-12 col-md-3 form-group px-0 pl-md-2">
                                        <label for="end_time">Horário de Conclusão</label>
                                        <input type="time" class="form-control" id="end_time"
                                            placeholder="HH:mm ou vazio" name="end_time"
                                            value="{{ old('end_time') ?? $serviceOrder->end_time }}">
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 form-group px-0">
                                        <label for="remarks">Observações de execução</label>
                                        <textarea name="remarks" rows="2" class="form-control" id="remarks">{{ old('remarks') ?? $serviceOrder->remarks }}</textarea>
                                    </div>
                                </div>

                                @if ($observations->count() > 0)
                                    <div class="d-flex flex-wrap justify-content-start" id="observation"
                                        data-observation-qtd="{{ $observations->count() - 1 }}">
                                        @foreach ($observations as $item)
                                            <label for="observation_{{ $loop->index }}">Observação sobre Etapa de
                                                Execução - Autor: {{ $item->user->name }} em
                                                {{ date('d/m/Y H:i', strtotime($item->created_at)) }}</label>
                                            <div class="col-12 form-group px-0 d-flex flex-wrap justify-content-start"
                                                id="container_observation_{{ $loop->index }}">
                                                <div class="col-12 col-md-9 px-0 pr-md-2">
                                                    <textarea class="form-control" id="observation_{{ $loop->index }}" placeholder="Observação sobre a execução"
                                                        name="observation_{{ $loop->index }}" rows="2">{{ old('observation_' . $loop->index) ?? $item->observation }}</textarea>
                                                </div>
                                                <div class="col-12 col-md-3 px-0 pl-md-2 mt-2 mt-md-0">
                                                    <input class="form-control" type="date"
                                                        id="observation_{{ $loop->index }}_date"
                                                        name="observation_{{ $loop->index }}_date"
                                                        value="{{ old('observation_' . $loop->index . '_date') ?? $item->date }}"
                                                        required>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="d-flex flex-wrap justify-content-start" id="observation"
                                        data-observation-qtd="0">
                                        <div class="col-12 form-group px-0" id="container_observation_0">
                                            <label for="observation_0">Observação sobre Etapa de Execução</label>
                                            <div class="col-12 form-group px-0 d-flex flex-wrap justify-content-start"
                                                id="container_observation_${item}">
                                                <div class="col-12 col-md-9 px-0 pr-md-2">
                                                    <textarea type="text" class="form-control" id="observation_0" placeholder="Descrição da Observação"
                                                        name="observation_0" value="{{ old('observation_0') }}" rows="2"></textarea>
                                                </div>
                                                <div class="col-12 col-md-3 px-0 pl-md-2 mt-2 mt-md-0">
                                                    <input class="form-control" type="date" id="observation_0_date"
                                                        name="observation_0_date" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="d-flex flex-wrap justify-content-start">
                                    <div class="col-12 col-md-3 form-group px-0 pr-md-2">
                                        <button class="btn btn-info w-100" data-observation="open"><i
                                                class="fa fa-plus"></i>
                                            Nova Observação</button>
                                    </div>

                                    <div class="col-12 col-md-3 form-group px-0 pl-md-2">
                                        <button class="btn btn-danger w-100" data-observation="close"><i
                                                class="fa fa-minus"></i>
                                            Remover Observação</button>
                                    </div>
                                </div>

                                @if ($serviceOrder->photo != null)
                                    <div class="d-flex flex-wrap justify-content-center">
                                        <div
                                            class="embed-responsive embed-responsive-16by9 col-12 col-md-6 form-group px-0">
                                            <img src="{{ url('storage/service-orders/' . $serviceOrder->photo) }}"
                                                alt="Imagem capturada"
                                                class="embed-responsive-item shadow-sm border border-1 border-primary rounded"
                                                style="max-width: 75%; left: 12.5%;"></canvas>
                                        </div>
                                    </div>
                                @endif

                                <div class="capture_container">
                                    <div class="d-flex flex-wrap justify-content-between">
                                        <label for="cover_base64">Capturar
                                            Foto</label>
                                        <input type="hidden" id="cover_base64" name="cover_base64" />
                                    </div>

                                    <div class="d-flex flex-wrap justify-content-between" id="cover_base64_container">
                                        <div
                                            class="embed-responsive embed-responsive-16by9 col-12 col-md-6 form-group px-0 pr-md-2">
                                            <video id="player" autoplay class="embed-responsive-item"></video>
                                        </div>

                                        <div
                                            class="embed-responsive embed-responsive-16by9 col-12 col-md-6 form-group px-0 pl-md-2">
                                            <canvas id="canvas" class="embed-responsive-item"
                                                style="max-width: 75%; left: 12.5%;"></canvas>
                                        </div>
                                        <button id="capture" class="btn btn-secondary"><i
                                                class="fa fa-camera mr-1"></i>
                                            Capturar</button>
                                    </div>
                                </div>

                                <div class="col-12 form-group px-0 mt-2">
                                    <x-adminlte-input-file id="photos" name="photos[]"
                                        label="Enviar Fotos do dispositivo" placeholder="Escolha múltiplas fotos..."
                                        igroup-size="md" legend="Selecione" multiple>
                                        <x-slot name="prependSlot">
                                            <div class="input-group-text text-primary">
                                                <i class="fas fa-file-upload"></i>
                                            </div>
                                        </x-slot>
                                    </x-adminlte-input-file>
                                </div>

                                @if ($serviceOrder->photos->count() > 0)
                                    <label>Imagens</label>
                                    <div class="col-12 form-group px-0 d-flex flex-wrap justify-content-start">
                                        @foreach ($serviceOrder->photos as $photo)
                                            <div class="col-12 col-md-3 p-2 card" data-photo={{ $photo->id }}>
                                                <div class="card-body d-flex justify-content-center align-items-center">
                                                    <img class="img-fluid" src="{{ asset('storage/' . $photo->photo) }}"
                                                        alt="">
                                                </div>
                                                <div class="card-footer d-flex justify-content-center">
                                                    <button class="btn btn-sm btn-danger photo-delete"
                                                        data-id={{ $photo->id }}><i
                                                            class="fa fa-trash"></i>Excluir</button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                <div class="col-12 form-group px-0 mt-2">
                                    <x-adminlte-input-file id="files" name="files[]" label="Enviar arquivos em PDF"
                                        placeholder="Escolha múltiplos arquivos..." igroup-size="md" legend="Selecione"
                                        multiple>
                                        <x-slot name="prependSlot">
                                            <div class="input-group-text text-primary">
                                                <i class="fas fa-file-upload"></i>
                                            </div>
                                        </x-slot>
                                    </x-adminlte-input-file>
                                </div>

                                @if ($serviceOrder->files->count() > 0)
                                    <label>Arquivos em PDF</label>
                                    <div class="col-12 form-group px-0 d-flex flex-wrap justify-content-start">
                                        @foreach ($serviceOrder->files as $file)
                                            <div class="col-12 p-2 card" data-file={{ $file->id }}>
                                                <div class="card-body">
                                                    <embed src="{{ url('storage/' . $file->file) }}"
                                                        type="application/pdf" width="100%" height="500px">
                                                </div>
                                                <div class="card-footer d-flex justify-content-center">
                                                    <button class="btn btn-sm btn-danger file-delete"
                                                        data-id={{ $file->id }}><i
                                                            class="fa fa-trash"></i>Excluir</button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                <div class="col-12 form-group px-0">
                                    <label>Assinatura do Cliente:</label>
                                    @if ($serviceOrder->costumer_signature)
                                        <p class="small text-muted mb-n2">Assinatura atual</p>
                                        <div class="border rounded my-2">
                                            <img id="costumer_sig_img" class="img-fluid"
                                                src="{{ asset('storage/signatures/' . $serviceOrder->costumer_signature) }}"
                                                alt="">
                                        </div>
                                    @endif
                                    <p class="small text-muted mb-n1">Atualizar a assinatura</p>
                                    <div id="costumer_sig"></div>
                                    <button id="costumer_signature_clear" class="btn btn-danger btn-sm">Limpar</button>
                                    <textarea id="costumer_signature" name="costumer_signature" style="display: none"></textarea>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="costumer_name">Nome de quem assinou</label>
                                        <input type="text" class="form-control " id="costumer_name"
                                            name="costumer_name" placeholder="Nome completo para identificação"
                                            value="{{ $serviceOrder->costumer_name }}">
                                    </div>

                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                        <label for="costumer_document">Documento de quem assinou</label>
                                        <input type="text" class="form-control " id="costumer_document"
                                            name="costumer_document" placeholder="nº do documento (CPF ou RG)"
                                            value="{{ $serviceOrder->costumer_document }}">
                                    </div>
                                </div>

                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Atualizar</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('custom_js')
    <script src="{{ asset('vendor/jquery/jquery.inputmask.bundle.min.js') }}"></script>
    <script src="{{ asset('js/date.js') }}"></script>
    <script src="{{ asset('js/address.js') }}"></script>
    <script src="{{ asset('vendor/jquery/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/jquery.signature.js') }}"></script>
    <script src="{{ asset('js/jquery.ui.touch-punch.min.js') }}"></script>
    <script src="{{ asset('js/signature.js') }}"></script>
    <script src="{{ asset('js/capture.js') }}"></script>
    <script>
        $(".photo-delete").on('click', function(e) {
            e.preventDefault();
            if (confirm("Confirma a exclusão desta imagem?") == true) {
                let photoRemove = e.target.dataset.id;
                $.ajax({
                    type: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('admin.service-orders-photo-delete') }}",
                    data: {
                        'id': photoRemove,
                    },
                    success: function(res) {
                        if (res.message == 'success') {
                            $("div").find(`[data-photo='${photoRemove}']`).remove();
                        } else {
                            alert('Falha ao remover a imagem');
                        }
                    }
                });
            }
        });

        $(".file-delete").on('click', function(e) {
            e.preventDefault();
            if (confirm("Confirma a exclusão deste arquivo?") == true) {
                let fileRemove = e.target.dataset.id;
                $.ajax({
                    type: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('admin.service-orders-file-delete') }}",
                    data: {
                        'id': fileRemove,
                    },
                    success: function(res) {
                        if (res.message == 'success') {
                            $("div").find(`[data-file='${fileRemove}']`).remove();
                        } else {
                            alert('Falha ao remover a pdf');
                        }
                    }
                });
            }
        });
    </script>
    <script src="{{ asset('js/service_orders_observations.js') }}"></script>
@endsection
