@extends('adminlte::page')
@section('plugins.Summernote', true)
@section('plugins.select2', true)
@section('plugins.BsCustomFileInput', true)

@section('title', '- Cadastro de Cliente')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-user-plus"></i> Novo Cliente</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.clients.index') }}">Clientes</a></li>
                        <li class="breadcrumb-item active">Novo Cliente</li>
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

                        <form method="POST" action="{{ route('admin.clients.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-4 form-group px-0 pr-md-2">
                                        <label for="name">Nome</label>
                                        <input type="text" class="form-control" id="name"
                                            placeholder="Nome Completo" name="name" value="{{ old('name') }}" required>
                                    </div>
                                    <div class="col-12 col-md-4 form-group px-0 px-md-2 mb-0">
                                        <label for="seller_id">Vendedor</label>
                                        <x-adminlte-select2 name="seller_id">
                                            <option value="" {{ old('seller_id') == null ? 'selected' : '' }}>
                                                Não informado</option>
                                            @foreach ($sellers as $seller)
                                                <option {{ old('seller_id') == $seller->id ? 'selected' : '' }}
                                                    value="{{ $seller->id }}">{{ $seller->name }}
                                                </option>
                                            @endforeach
                                        </x-adminlte-select2>
                                    </div>
                                    <div class="col-12 col-md-4 form-group px-0 pl-md-2">
                                        <label for="document_person">CPF/CNPJ</label>
                                        <input type="text" class="form-control" id="document_person"
                                            placeholder="CPF ou CNPJ do cliente" name="document_person"
                                            value="{{ old('document_person') }}">
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between mb-0">
                                    <div class="col-12 col-md-4 form-group px-0 pr-md-2 mb-0">
                                        <label for="type">Tipo de Cliente</label>
                                        <x-adminlte-select2 name="type">
                                            <option {{ old('type') == 'Administradora' ? 'selected' : '' }}
                                                value="Administradora">Administradora
                                            </option>
                                            <option {{ old('type') == 'Construtora' ? 'selected' : '' }}
                                                value="Construtora">Construtora
                                            </option>
                                            <option {{ old('type') == 'Síndico Profissional' ? 'selected' : '' }}
                                                value="Síndico Profissional">Síndico Profissional
                                            </option>
                                            <option {{ old('type') == 'Condomínio Comercial' ? 'selected' : '' }}
                                                value="Condomínio Comercial">Condomínio Comercial
                                            </option>
                                            <option {{ old('type') == 'Condomínio Residencial' ? 'selected' : '' }}
                                                value="Condomínio Residencial">Condomínio Residencial
                                            </option>
                                            <option {{ old('type') == 'Síndico Orgânico' ? 'selected' : '' }}
                                                value="Síndico Orgânico">Síndico Orgânico
                                            </option>
                                            <option {{ old('type') == 'Parceiro' ? 'selected' : '' }} value="Parceiro">
                                                Parceiro
                                            </option>
                                            <option {{ old('type') == 'Indicação' ? 'selected' : '' }} value="Indicação">
                                                Indicação
                                            </option>
                                            <option {{ old('type') == 'Outros' ? 'selected' : '' }} value="Outros">Outros
                                            </option>
                                        </x-adminlte-select2>
                                    </div>

                                    <div class="col-12 col-md-4 form-group px-0 px-md-2 mb-0">
                                        <label for="trade_status">Status</label>
                                        <x-adminlte-select2 name="trade_status">
                                            <option {{ old('trade_status') == 'Prospect' ? 'selected' : '' }}
                                                value="Prospect">Prospect</option>
                                            <option {{ old('trade_status') == 'Prospect com Interesse' ? 'selected' : '' }}
                                                value="Prospect com Interesse">Prospect com Interesse</option>
                                            <option {{ old('trade_status') == 'Lead' ? 'selected' : '' }} value="Lead">
                                                Lead</option>
                                            <option {{ old('trade_status') == 'Lead com Proposta' ? 'selected' : '' }}
                                                value="Lead com Proposta">Lead com Proposta</option>
                                            <option {{ old('trade_status') == 'Lead Inativo' ? 'selected' : '' }}
                                                value="Lead Inativo">Lead Inativo</option>
                                            <option {{ old('trade_status') == 'Contato Realizado' ? 'selected' : '' }}
                                                value="Contato Realizado">Contato Realizado</option>
                                            <option {{ old('trade_status') == 'Vistoria Marcada' ? 'selected' : '' }}
                                                value="Vistoria Marcada">Vistoria Marcada</option>
                                            <option {{ old('trade_status') == 'Aguardando Orçamento' ? 'selected' : '' }}
                                                value="Aguardando Orçamento">Aguardando Orçamento</option>
                                            <option {{ old('trade_status') == 'Orçamento Enviado' ? 'selected' : '' }}
                                                value="Orçamento Enviado">Orçamento Enviado</option>
                                            <option {{ old('trade_status') == 'Assembléia Marcada' ? 'selected' : '' }}
                                                value="Assembléia Marcada">Assembléia Marcada</option>
                                            <option {{ old('trade_status') == 'Negociação' ? 'selected' : '' }}
                                                value="Negociação">Negociação</option>
                                            <option {{ old('trade_status') == 'Venda Realizada' ? 'selected' : '' }}
                                                value="Venda Realizada">Venda Realizada</option>
                                            <option {{ old('trade_status') == 'Cliente' ? 'selected' : '' }}
                                                value="Cliente">Cliente</option>
                                            <option {{ old('trade_status') == 'Ex Cliente' ? 'selected' : '' }}
                                                value="Ex Cliente">Ex Cliente</option>
                                            <option {{ old('trade_status') == 'Recusado' ? 'selected' : '' }}
                                                value="Recusado">Recusado</option>
                                            <option {{ old('trade_status') == 'Restrito' ? 'selected' : '' }}
                                                value="Restrito">Restrito</option>
                                        </x-adminlte-select2>
                                    </div>

                                    <div class="col-12 col-md-4 form-group px-0 pl-md-2 mb-0">
                                        <label for="origin">Origem</label>
                                        <x-adminlte-select2 name="origin">
                                            <option {{ old('origin') == 'Google' ? 'selected' : '' }} value="Google">
                                                Google
                                            </option>
                                            <option {{ old('origin') == 'oHub' ? 'selected' : '' }} value="oHub">
                                                oHub
                                            </option>
                                            <option {{ old('origin') == 'SindicoNet' ? 'selected' : '' }}
                                                value="SindicoNet">
                                                SindicoNet
                                            </option>
                                            <option {{ old('origin') == 'Cota Síndicos' ? 'selected' : '' }}
                                                value="Cota Síndicos">
                                                Cota Síndicos
                                            </option>
                                            <option {{ old('origin') == 'Feira' ? 'selected' : '' }} value="Feira">Feira
                                            </option>
                                            <option {{ old('origin') == 'Indicação' ? 'selected' : '' }} value="Indicação">
                                                Indicação
                                            </option>
                                            <option {{ old('origin') == 'Outros' ? 'selected' : '' }} value="Outros">Outros
                                            </option>
                                        </x-adminlte-select2>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-start mb-0" id="complement_trade_status">
                                    <div class="col-12 col-md-4 form-group px-0 pr-md-2 mb-0" id="status_sale_container">
                                        <label for="status_sale">Status da Venda Realizada</label>
                                        <x-adminlte-select2 name="status_sale">
                                            <option {{ old('status_sale') == 'Contrato em Confecção' ? 'selected' : '' }}
                                                value="Contrato em Confecção">Contrato em Confecção
                                            </option>
                                            <option {{ old('status_sale') == 'Contrato Assinado' ? 'selected' : '' }}
                                                value="Contrato Assinado">Contrato Assinado
                                            </option>
                                            <option {{ old('status_sale') == 'Aguardando PG' ? 'selected' : '' }}
                                                value="Aguardando PG">Aguardando PG
                                            </option>
                                            <option {{ old('status_sale') == 'Entrada PG' ? 'selected' : '' }}
                                                value="Entrada PG">Entrada PG
                                            </option>
                                            <option
                                                {{ old('status_sale') == 'Aguardando Vistoria para Obra' ? 'selected' : '' }}
                                                value="Aguardando Vistoria para Obra">Aguardando Vistoria para Obra
                                            </option>
                                            <option {{ old('status_sale') == 'Início de Obra' ? 'selected' : '' }}
                                                value="Início de Obra">Início de Obra
                                            </option>
                                            <option {{ old('status_sale') == 'Obra em andamento' ? 'selected' : '' }}
                                                value="Obra em andamento">Obra em andamento
                                            </option>
                                            <option {{ old('status_sale') == 'Obra Finalizada' ? 'selected' : '' }}
                                                value="Obra Finalizada">Obra Finalizada
                                            </option>
                                            <option {{ old('status_sale') == 'Obra Entregue' ? 'selected' : '' }}
                                                value="Obra Entregue">Obra Entregue
                                            </option>
                                            <option {{ old('status_sale') == 'Início de Leitura' ? 'selected' : '' }}
                                                value="Início de Leitura">Início de Leitura
                                            </option>
                                        </x-adminlte-select2>
                                    </div>

                                    <div class="col-12 form-group px-0" id="reason_refusal_container">
                                        <label for="reason_refusal">Motivo da Recusa</label>
                                        <input type="text" class="form-control" id="reason_refusal"
                                            placeholder="Descrição do Motivo" name="reason_refusal"
                                            value="{{ old('reason_refusal') }}">
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="contact">Nome do Contato</label>
                                        <input type="text" class="form-control" id="contact"
                                            placeholder="Nome do contato" name="contact" value="{{ old('contact') }}">
                                    </div>
                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                        <label for="contact_function">Função do Contato</label>
                                        <input type="text" class="form-control" id="contact_function"
                                            placeholder="Função do contato" name="contact_function"
                                            value="{{ old('contact_function') }}">
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-4 form-group px-0 pr-md-2">
                                        <label for="email">E-mail</label>
                                        <input type="email" class="form-control" id="email" placeholder="E-mail"
                                            name="email" value="{{ old('email') }}">
                                    </div>

                                    <div class="col-12 col-md-4 form-group px-0 px-md-2">
                                        <label for="telephone">Telefone</label>
                                        <input type="tel" class="form-control" id="telephone" placeholder="Telefone"
                                            name="telephone" value="{{ old('telephone') }}">
                                    </div>
                                    <div class="col-12 col-md-4 form-group px-0 pl-md-2">
                                        <label for="cell">Celular</label>
                                        <input type="tel" class="form-control" id="cell" placeholder="Celular"
                                            name="cell" value="{{ old('cell') }}">
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="zipcode">CEP</label>
                                        <input type="tel" class="form-control" id="zipcode" placeholder="CEP"
                                            name="zipcode" value="{{ old('zipcode') }}">
                                    </div>
                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                        <label for="street">Rua</label>
                                        <input type="text" class="form-control" id="street" placeholder="Rua"
                                            name="street" value="{{ old('street') }}">
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="number">Número</label>
                                        <input type="text" class="form-control" id="number" placeholder="Número"
                                            name="number" value="{{ old('number') }}">
                                    </div>
                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                        <label for="complement">Complemento</label>
                                        <input type="text" class="form-control" id="complement"
                                            placeholder="Complemento" name="complement" value="{{ old('complement') }}">
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="neighborhood">Bairro</label>
                                        <input type="text" class="form-control" id="neighborhood"
                                            placeholder="Bairro" name="neighborhood" value="{{ old('neighborhood') }}">
                                    </div>
                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                        <label for="city">Cidade</label>
                                        <input type="text" class="form-control" id="city" placeholder="Cidade"
                                            name="city" value="{{ old('city') }}">
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="state">Estado</label>
                                        <input type="text" class="form-control" id="state" placeholder="UF"
                                            name="state" value="{{ old('state') }}">
                                    </div>

                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                        <label for="subsidiary_id">Filial</label>
                                        <x-adminlte-select2 name="subsidiary_id" id="subsidiary_id">
                                            @foreach ($subsidiaries as $subsidiary)
                                                <option {{ old('subsidiary_id') == $subsidiary->id ? 'selected' : '' }}
                                                    value="{{ $subsidiary->id }}" data-state={{ $subsidiary->state }}>
                                                    {{ $subsidiary->alias_name }}
                                                </option>
                                            @endforeach
                                        </x-adminlte-select2>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 form-group px-0">
                                        <label for="service">Serviço/Produto</label>
                                        <textarea name="service" rows="2" class="form-control" id="service"
                                            placeholder="Tipo de serviço ou produto disponibilizado">{{ old('service') }}</textarea>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 form-group px-0">
                                        <label for="company">Empresa</label>
                                        <input type="text" class="form-control" id="company"
                                            placeholder="Nome da Empresa" name="company" value="{{ old('company') }}">
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-start">
                                    <div class="col-12 col-md-4 form-group px-0 pr-md-2">
                                        <label for="value_per_apartment">Valor por Apartamento</label>
                                        <input type="text" class="form-control money_format_2"
                                            id="value_per_apartment" name="value_per_apartment"
                                            value="{{ old('value_per_apartment') }}" onchange="calc()">
                                    </div>
                                    <div class="col-12 col-md-4 form-group px-0 px-md-2">
                                        <label for="apartments">Qtd de Apartamentos</label>
                                        <input type="number" class="form-control" id="apartments" name="apartments"
                                            min="0" value="{{ old('apartments') }}" onchange="calc()">
                                    </div>
                                    <div class="col-12 col-md-4 form-group px-0 pl-md-2">
                                        <label for="total_value">Valor Total</label>
                                        <input type="text" class="form-control money_format_2" id="total_value"
                                            name="total_value" value="{{ old('total_value') }}">
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-start">
                                    <div class="col-12 col-md-3 form-group px-0 pr-md-2">
                                        <label for="meeeting">Data da Assembléia</label>
                                        <input type="date" class="form-control" id="meeeting" name="meeeting"
                                            value="{{ old('meeeting') }}">
                                    </div>

                                    <div class="col-12 col-md-9 form-group px-0 pl-md-2">
                                        <x-adminlte-input-file id="attached_documents" name="attached_documents[]"
                                            label="Documentos em anexo (arquivos em PDF)"
                                            placeholder="Escolha múltiplos arquivos..." igroup-size="md"
                                            legend="Selecione" multiple>
                                            <x-slot name="prependSlot">
                                                <div class="input-group-text text-primary">
                                                    <i class="fas fa-file-upload"></i>
                                                </div>
                                            </x-slot>
                                        </x-adminlte-input-file>
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
                                        <x-adminlte-text-editor name="annotation" label="Anotação"
                                            label-class="text-black" igroup-size="md"
                                            placeholder="Escreva seu texto aqui..." :config="$config" />
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
    <script src="{{ asset('js/address-client.js') }}"></script>
    <script src="{{ asset('js/phone.js') }}"></script>
    <script src="{{ asset('js/money.js') }}"></script>
    <script src="{{ asset('js/trade-status.js') }}"></script>
    <script>
        function calc() {
            let value_per_apartment = Number($("#value_per_apartment").val().toString().replace(["R$ ", ","], ['', "."]));
            let apartments = Number($("#apartments").val());
            total_value = (value_per_apartment * apartments).toLocaleString(
                'pt-br', {
                    style: 'currency',
                    currency: 'BRL'
                });
            $("#total_value").val(total_value);
        }
        calc();
    </script>
@endsection
