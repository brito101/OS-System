@extends('adminlte::page')
@section('plugins.select2', true)
@section('plugins.Summernote', true)

@section('title', '- Edição de Ordem de Serviço')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-list"></i> Editar Ordem de Serviço</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.service-orders.index') }}">Ordens de Serviço</a>
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

                        <form method="POST"
                            action="{{ route('admin.service-orders.update', ['service_order' => $serviceOrder->id]) }}">
                            @method('PUT')
                            @csrf
                            <input type="hidden" name="id" value="{{ $serviceOrder->id }}">
                            <div class="card-body">

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2 mb-0">
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
                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2 mb-0">
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
                                            name="zipcode" value="{{ old('zipcode') ?? $serviceOrder->zipcode }}" required>
                                    </div>
                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                        <label for="street">Rua</label>
                                        <input type="text" class="form-control" id="street" placeholder="Rua"
                                            name="street" value="{{ old('street') ?? $serviceOrder->street }}" required>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="number">Número</label>
                                        <input type="text" class="form-control" id="number" placeholder="Número"
                                            name="number" value="{{ old('number') ?? $serviceOrder->number }}" required>
                                    </div>
                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                        <label for="complement">Complemento</label>
                                        <input type="text" class="form-control" id="complement" placeholder="Complemento"
                                            name="complement" value="{{ old('complement') ?? $serviceOrder->complement }}">
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="neighborhood">Bairro</label>
                                        <input type="text" class="form-control" id="neighborhood" placeholder="Bairro"
                                            name="neighborhood"
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
                                            name="state" value="{{ old('state') ?? $serviceOrder->state }}" required>
                                    </div>

                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                        <label for="telephone">Telefone de Contato</label>
                                        <input type="text" class="form-control" id="telephone"
                                            placeholder="nº para contato" name="telephone"
                                            value="{{ old('telephone') ?? $serviceOrder->telephone }}">
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2 mb-0">
                                        <label for="user_id">Colaborador</label>
                                        <x-adminlte-select2 name="user_id" required>
                                            <option disabled selected value="">Selecione</option>
                                            @foreach ($collaborators as $collaborator)
                                                <option
                                                    {{ old('user_id') == $collaborator->id ? 'selected' : ($serviceOrder->user_id == $collaborator->id ? 'selected' : '') }}
                                                    value="{{ $collaborator->id }}">{{ $collaborator->name }}
                                                </option>
                                            @endforeach
                                        </x-adminlte-select2>
                                    </div>

                                    <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                        <label for="execution_date">Data de Execução</label>
                                        <input type="text" class="form-control date" id="execution_date"
                                            placeholder="dd/mm/yyyy" name="execution_date"
                                            value="{{ old('execution_date') ?? $serviceOrder->execution_date }}" required>
                                    </div>

                                    <div class="col-12 col-md-3 form-group px-0 pl-md-2">
                                        <label for="deadline">Data Limite</label>
                                        <input type="text" class="form-control date" id="deadline"
                                            placeholder="dd/mm/yyyy" name="deadline"
                                            value="{{ old('deadline') ?? $serviceOrder->deadline }}" required>
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

                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2 mb-0">
                                        <label for="status">Status</label>
                                        <x-adminlte-select2 name="status" required>
                                            <option
                                                {{ old('status') == 'Não inicado' ? 'selected' : ($serviceOrder->status == 'Não inicado' ? 'selected' : '') }}
                                                value="Não inicado">
                                                Não inicado</option>
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
                                                {{ old('status') == 'Cancelado' ? 'selected' : ($serviceOrder->status == 'Cancelado' ? 'selected' : '') }}
                                                value="Cancelado">
                                                Cancelado</option>
                                        </x-adminlte-select2>
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
                                    <div class="col-12 form-group px-0">
                                        <x-adminlte-text-editor name="observations" label="Observações"
                                            label-class="text-black" igroup-size="md" placeholder="Observações..."
                                            :config="$config">
                                            {!! $serviceOrder->observations !!}
                                        </x-adminlte-text-editor>
                                    </div>
                                </div>

                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Enviar</button>
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
@endsection
