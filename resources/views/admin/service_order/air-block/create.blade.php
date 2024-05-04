@extends('adminlte::page')
@section('plugins.select2', true)
@section('plugins.Summernote', true)

@section('title', '- Cadastro de Ordem de Serviço')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-8">
                    <h1><i class="fas fa-fw fa-list"></i> Nova Ordem de Serviço - Ficha
                        técnica orçamentária de bloqueador de ar</h1>
                </div>
                <div class="col-sm-4">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.service-orders.index') }}">Ordens de Serviço</a>
                        </li>
                        <li class="breadcrumb-item active">Nova Ordem de Serviço</li>
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

                        <form method="POST" action="{{ route('admin.service-orders.store') }}">
                            @csrf
                            <div class="card-body">

                                <input type="hidden" name="type" value="comercial - bloqueador de ar">

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 form-group px-0 mb-0">
                                        <label for="activity_id">Atividade</label>
                                        <x-adminlte-select2 name="activity_id" required>
                                            <option disabled selected value="">Selecione</option>
                                            @foreach ($activities as $activity)
                                                <option {{ old('activity_id') == $activity->id ? 'selected' : '' }}
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
                                                <option {{ old('client_id') == $client->id ? 'selected' : '' }}
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
                                        <textarea name="description" rows="2" class="form-control" id="description">{{ old('description') }}</textarea>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 form-group px-0">
                                        <label for="user_id">Participante</label>
                                        <x-adminlte-select2 name="user_id" required>
                                            <option disabled selected value="">Selecione</option>
                                            @foreach ($participants as $participant)
                                                <option {{ old('user_id') == $participant->id ? 'selected' : '' }}
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
                                                <option {{ old('subsidiary_id') == $subsidiary->id ? 'selected' : '' }}
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
                                            <option {{ old('priority') == 'Baixa' ? 'selected' : '' }} value="Baixa">
                                                Baixa</option>
                                            <option {{ old('priority') == 'Média' ? 'selected' : '' }} value="Média">
                                                Média</option>
                                            <option {{ old('priority') == 'Alta' ? 'selected' : '' }} value="Alta">
                                                Alta</option>
                                            <option {{ old('priority') == 'Urgente' ? 'selected' : '' }} value="Urgente">
                                                Urgente</option>
                                        </x-adminlte-select2>
                                    </div>

                                    <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                        <label for="execution_date">Data de Execução</label>
                                        <input type="text" class="form-control date" id="execution_date"
                                            placeholder="dd/mm/yyyy" name="execution_date"
                                            value="{{ old('execution_date') }}" required>
                                    </div>

                                    <div class="col-12 col-md-3 form-group px-0 pl-md-2">
                                        <label for="deadline">Data Limite</label>
                                        <input type="text" class="form-control date" id="deadline"
                                            placeholder="dd/mm/yyyy" name="deadline" value="{{ old('deadline') }}"
                                            required>
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
                                            :config="$config" />
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2 mb-0">
                                        <label for="status">Status</label>
                                        <x-adminlte-select2 name="status" required>
                                            <option {{ old('status') == 'Não iniciado' ? 'selected' : '' }}
                                                value="Não iniciado">
                                                Não iniciado</option>
                                            <option {{ old('status') == 'Aguardando orçamento' ? 'selected' : '' }}
                                                value="Aguardando orçamento">Aguardando orçamento</option>
                                            <option {{ old('status') == 'Orçamento enviado' ? 'selected' : '' }}
                                                value="Orçamento enviado">Orçamento enviado</option>
                                            <option {{ old('status') == 'Aguardando laudo' ? 'selected' : '' }}
                                                value="Aguardando laudo">Aguardando laudo</option>
                                            <option {{ old('status') == 'Laudo enviado' ? 'selected' : '' }}
                                                value="Laudo enviado">Laudo enviado</option>
                                            <option {{ old('status') == 'Atrasado' ? 'selected' : '' }} value="Atrasado">
                                                Atrasado</option>
                                            <option {{ old('status') == 'Iniciado' ? 'selected' : '' }} value="Iniciado">
                                                Iniciado</option>
                                            <option {{ old('status') == 'Concluído' ? 'selected' : '' }} value="Concluído">
                                                Concluído</option>
                                            <option
                                                {{ old('status') == 'Concluído com envio de proposta' ? 'selected' : '' }}
                                                value="Concluído com envio de proposta">
                                                Concluído com envio de proposta</option>
                                            <option {{ old('status') == 'Cancelado' ? 'selected' : '' }} value="Cancelado">
                                                Cancelado</option>
                                        </x-adminlte-select2>
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
    <script src="{{ asset('js/address.js') }}"></script>
@endsection
