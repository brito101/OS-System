@extends('adminlte::page')
@section('plugins.Summernote', true)
@section('plugins.select2', true)

@section('title', '- Edição de Cliente')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-user-plus"></i> Editar Cliente</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.clients.index') }}">Clientes</a></li>
                        <li class="breadcrumb-item active">Editar Cliente</li>
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
                            <h3 class="card-title">Dados Cadastrais do Cliente</h3>
                        </div>

                        <form method="POST" action="{{ route('admin.clients.update', ['client' => $client->id]) }}">
                            @method('PUT')
                            @csrf
                            <input type="hidden" name="id" value="{{ $client->id }}">
                            <div class="card-body">

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-4 form-group px-0 pr-md-2">
                                        <label for="name">Nome</label>
                                        <input type="text" class="form-control" id="name"
                                            placeholder="Nome Completo" name="name"
                                            value="{{ old('name') ?? $client->name }}" required>
                                    </div>
                                    <div class="col-12 col-md-4 form-group px-0 px-md-2 mb-0">
                                        <label for="seller_id">Vendedor</label>
                                        <x-adminlte-select2 name="seller_id">
                                            <option value=""
                                                {{ old('seller_id') == null ? 'selected' : ($client->seller_id == null ? 'selected' : '') }}>
                                                Não informado</option>
                                            @foreach ($sellers as $seller)
                                                <option
                                                    {{ old('seller_id') == $seller->id ? 'selected' : ($client->seller_id == $seller->id ? 'selected' : '') }}
                                                    value="{{ $seller->id }}">{{ $seller->name }}
                                                </option>
                                            @endforeach
                                        </x-adminlte-select2>
                                    </div>
                                    <div class="col-12 col-md-4 form-group px-0 pl-md-2">
                                        <label for="document_person">CPF/CNPJ</label>
                                        <input type="text" class="form-control" id="document_person"
                                            placeholder="CPF ou CNPJ do cliente" name="document_person"
                                            value="{{ old('document_person') ?? $client->document_person }}">
                                    </div>

                                </div>

                                <div class="d-flex flex-wrap justify-content-between mb-0">
                                    <div class="col-12 col-md-4 form-group px-0 pr-md-2 mb-0">
                                        <label for="type">Tipo de Cliente</label>
                                        <x-adminlte-select2 name="type">
                                            <option
                                                {{ old('type') == 'Administradora' ? 'selected' : ($client->type == 'Administradora' ? 'selected' : '') }}
                                                value="Administradora">Administradora
                                            </option>
                                            <option
                                                {{ old('type') == 'Construtora' ? 'selected' : ($client->type == 'Construtora' ? 'selected' : '') }}
                                                value="Construtora">Construtora
                                            </option>
                                            <option
                                                {{ old('type') == 'Síndico Profissional' ? 'selected' : ($client->type == 'Síndico Profissional' ? 'selected' : '') }}
                                                value="Síndico Profissional">Síndico Profissional
                                            </option>
                                            <option
                                                {{ old('type') == 'Condomínio Comercial' ? 'selected' : ($client->type == 'Condomínio Comercial' ? 'selected' : '') }}
                                                value="Condomínio Comercial">Condomínio Comercial
                                            </option>
                                            <option
                                                {{ old('type') == 'Condomínio Residencial' ? 'selected' : ($client->type == 'Condomínio Residencial' ? 'selected' : '') }}
                                                value="Condomínio Residencial">Condomínio Residencial
                                            </option>
                                            <option
                                                {{ old('type') == 'Síndico Orgânico' ? 'selected' : ($client->type == 'Síndico Orgânico' ? 'selected' : '') }}
                                                value="Síndico Orgânico">Síndico Orgânico
                                            </option>
                                            <option
                                                {{ old('type') == 'Parceiro' ? 'selected' : ($client->type == 'Parceiro' ? 'selected' : '') }}
                                                value="Parceiro">
                                                Parceiro
                                            </option>
                                            <option
                                                {{ old('type') == 'Indicação' ? 'selected' : ($client->type == 'Indicação' ? 'selected' : '') }}
                                                value="Indicação">
                                                Indicação
                                            </option>
                                            <option
                                                {{ old('type') == 'Outros' ? 'selected' : ($client->type == 'Outros' ? 'selected' : '') }}
                                                value="Outros">Outros
                                            </option>
                                        </x-adminlte-select2>
                                    </div>

                                    <div class="col-12 col-md-4 form-group px-0 px-md-2 mb-0">
                                        <label for="trade_status">Status</label>
                                        <x-adminlte-select2 name="trade_status">
                                            <option
                                                {{ old('trade_status') == 'Lead' ? 'selected' : ($client->trade_status == 'Lead' ? 'selected' : '') }}
                                                value="Lead">Lead
                                            </option>
                                            <option
                                                {{ old('trade_status') == 'Prospect' ? 'selected' : ($client->trade_status == 'Prospect' ? 'selected' : '') }}
                                                value="Prospect">
                                                Prospect
                                            </option>
                                            <option
                                                {{ old('trade_status') == 'Cliente' ? 'selected' : ($client->trade_status == 'Cliente' ? 'selected' : '') }}
                                                value="Cliente">
                                                Cliente
                                            </option>
                                            <option
                                                {{ old('trade_status') == 'Ex Cliente' ? 'selected' : ($client->trade_status == 'Ex Cliente' ? 'selected' : '') }}
                                                value="Ex Cliente">
                                                Ex Cliente
                                            </option>
                                            <option
                                                {{ old('trade_status') == 'Lead com Proposta' ? 'selected' : ($client->trade_status == 'Lead com Proposta' ? 'selected' : '') }}
                                                value="Lead com Proposta">
                                                Lead com Proposta
                                            </option>
                                            <option
                                                {{ old('trade_status') == 'Lead Inativo' ? 'selected' : ($client->trade_status == 'Lead Inativo' ? 'selected' : '') }}
                                                value="Lead Inativo">Lead Inativo</option>
                                            <option
                                                {{ old('trade_status') == 'Recusado' ? 'selected' : ($client->trade_status == 'Recusado' ? 'selected' : '') }}
                                                value="Recusado">Recusado</option>
                                            <option
                                                {{ old('trade_status') == 'Restrito' ? 'selected' : ($client->trade_status == 'Restrito' ? 'selected' : '') }}
                                                value="Restrito">Restrito</option>
                                        </x-adminlte-select2>
                                    </div>

                                    <div class="col-12 col-md-4 form-group px-0 pl-md-2 mb-0">
                                        <label for="origin">Origem</label>
                                        <x-adminlte-select2 name="origin">
                                            <option
                                                {{ old('origin') == 'Google' ? 'selected' : ($client->origin == 'Google' ? 'selected' : '') }}
                                                value="Google">
                                                Google
                                            </option>
                                            <option
                                                {{ old('origin') == 'oHub' ? 'selected' : ($client->origin == 'oHub' ? 'selected' : '') }}
                                                value="oHub">
                                                oHub
                                            </option>
                                            <option
                                                {{ old('origin') == 'SindicoNet' ? 'selected' : ($client->origin == 'SindicoNet' ? 'selected' : '') }}
                                                value="SindicoNet">
                                                SindicoNet
                                            </option>
                                            <option
                                                {{ old('origin') == 'Cota Síndicos' ? 'selected' : ($client->origin == 'Cota Síndicos' ? 'selected' : '') }}
                                                value="Cota Síndicos">
                                                Cota Síndicos
                                            </option>
                                            <option
                                                {{ old('origin') == 'Feira' ? 'selected' : ($client->origin == 'Feira' ? 'selected' : '') }}
                                                value="Feira">Feira
                                            </option>
                                            <option
                                                {{ old('origin') == 'Indicação' ? 'selected' : ($client->origin == 'Indicação' ? 'selected' : '') }}
                                                value="Indicação">
                                                Indicação
                                            </option>
                                            <option
                                                {{ old('origin') == 'Outros' ? 'selected' : ($client->origin == 'Outros' ? 'selected' : '') }}
                                                value="Outros">Outros
                                            </option>
                                        </x-adminlte-select2>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 form-group px-0 ">
                                        <label for="contact">Dados do Contato</label>
                                        <textarea type="text" class="form-control" id="contact" placeholder="Nome de um ou mais contatos" name="contact"
                                            rows="1">{{ old('contact') ?? $client->contact }}</textarea>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-4 form-group px-0 pr-md-2">
                                        <label for="email">E-mail</label>
                                        <input type="email" class="form-control" id="email" placeholder="E-mail"
                                            name="email" value="{{ old('email') ?? $client->email }}">
                                    </div>

                                    <div class="col-12 col-md-4 form-group px-0 px-md-2">
                                        <label for="telephone">Telefone</label>
                                        <input type="tel" class="form-control" id="telephone" placeholder="Telefone"
                                            name="telephone" value="{{ old('telephone') ?? $client->telephone }}">
                                    </div>
                                    <div class="col-12 col-md-4 form-group px-0 pl-md-2">
                                        <label for="cell">Celular</label>
                                        <input type="tel" class="form-control" id="cell" placeholder="Celular"
                                            name="cell" value="{{ old('cell') ?? $client->cell }}">
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="zipcode">CEP</label>
                                        <input type="tel" class="form-control" id="zipcode" placeholder="CEP"
                                            name="zipcode" value="{{ old('zipcode') ?? $client->zipcode }}">
                                    </div>
                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                        <label for="street">Rua</label>
                                        <input type="text" class="form-control" id="street" placeholder="Rua"
                                            name="street" value="{{ old('street') ?? $client->street }}">
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="number">Número</label>
                                        <input type="text" class="form-control" id="number" placeholder="Número"
                                            name="number" value="{{ old('number') ?? $client->number }}">
                                    </div>
                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                        <label for="complement">Complemento</label>
                                        <input type="text" class="form-control" id="complement"
                                            placeholder="Complemento" name="complement"
                                            value="{{ old('complement') ?? $client->complement }}">
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="neighborhood">Bairro</label>
                                        <input type="text" class="form-control" id="neighborhood"
                                            placeholder="Bairro" name="neighborhood"
                                            value="{{ old('neighborhood') ?? $client->neighborhood }}">
                                    </div>
                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                        <label for="city">Cidade</label>
                                        <input type="text" class="form-control" id="city" placeholder="Cidade"
                                            name="city" value="{{ old('city') ?? $client->city }}">
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="state">Estado</label>
                                        <input type="text" class="form-control" id="state" placeholder="UF"
                                            name="state" value="{{ old('state') ?? $client->state }}">
                                    </div>

                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                        <label for="subsidiary_id">Filial</label>
                                        <x-adminlte-select2 name="subsidiary_id">
                                            @foreach ($subsidiaries as $subsidiary)
                                                <option
                                                    {{ old('subsidiary_id') == $subsidiary->id ? 'selected' : ($client->subsidiary_id == $subsidiary->id ? 'selected' : '') }}
                                                    value="{{ $subsidiary->id }}">{{ $subsidiary->alias_name }}
                                                </option>
                                            @endforeach
                                        </x-adminlte-select2>
                                    </div>

                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 form-group px-0">
                                        <label for="service">Serviço</label>
                                        <textarea name="service" rows="2" class="form-control" id="service"
                                            placeholder="Tipo de serviço disponibilizado">{{ old('service') ?? $client->service }}</textarea>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-8 form-group px-0 pr-md-2">
                                        <label for="company">Empresa</label>
                                        <input type="text" class="form-control" id="company"
                                            placeholder="Nome da Empresa" name="company"
                                            value="{{ old('company') ?? $client->company }}">
                                    </div>

                                    <div class="col-12 col-md-4 form-group px-0 pl-md-2">
                                        <label for="apartments">Nº de Apartamentos</label>
                                        <input type="number" class="form-control" id="apartments" name="apartments"
                                            min="0" value="{{ old('apartments') ?? $client->apartments }}">
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
                                            {!! $client->observations !!}
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
    <script src="{{ asset('js/address.js') }}"></script>
    <script src="{{ asset('js/phone.js') }}"></script>
@endsection
