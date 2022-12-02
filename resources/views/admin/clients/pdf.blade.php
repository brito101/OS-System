@extends('adminlte::page')
@section('adminlte_css')
    <style>
        @page {
            margin: 2cm;
        }
    </style>
@endsection

@section('title', '- Ficha de Cliente')

@section('content')

    <div class="card">
        <div class="d-flex flex-wrap justify-content-center">
            <img src="{{ asset('img/logo.png') }}" class="col-2" style="width: 100px">
            <h2 class="text-center col-9 d-flex align-items-center ml-5 mt-3 display-5 font-weight-bold">Ficha de Cliente
            </h2>
        </div>
        <div class="card-header">
            <h3 class="card-title">Dados Cadastrais do Cliente</h3>
        </div>

        <form>
            <div class="card-body">

                <div class="d-flex flex-wrap justify-content-between">
                    <div class="col-4 form-group pr-2">
                        <label for="name">Nome</label>
                        <input type="text" class="form-control bg-white" id="name" name="name"
                            value="{{ $client->name }}" disabled>
                    </div>
                    <div class="col-4 form-group px-2">
                        <label for="name">Vendedor</label>
                        <input type="text" class="form-control bg-white" id="name" name="name"
                            value="{{ $client->seller ? $client->seller->name : 'Não Informado' }}" disabled>
                    </div>
                    <div class="col-4 form-group pl-2">
                        <label for="document_person">CPF/CNPJ</label>
                        <input type="text" class="form-control bg-white" id="document_person" name="document_person"
                            value="{{ $client->document_person }}" disabled>
                    </div>

                </div>

                <div class="d-flex flex-wrap justify-content-between">
                    <div class="col-4 form-group pr-2">
                        <label for="type">Tipo de Cliente</label>
                        <input type="text" class="form-control bg-white" id="type" name="type"
                            value="{{ $client->type }}" disabled>
                    </div>

                    <div class="col-4 form-group px-2">
                        <label for="trade_status">Status</label>
                        <input type="text" class="form-control bg-white" id="trade_status" name="trade_status"
                            value="{{ $client->trade_status }}" disabled>
                    </div>

                    <div class="col-4 form-group pl-2">
                        <label for="origin">Origem</label>
                        <input type="text" class="form-control bg-white" id="origin" name="origin"
                            value="{{ $client->origin }}" disabled>
                    </div>
                </div>

                <div class="d-flex flex-wrap justify-content-between">
                    <div class="col-12 form-group px-2">
                        <label for="contact">Dados do Contato</label>
                        <textarea type="text" class="form-control bg-white" id="contact" name="contact" rows="1" disabled>{{ $client->contact }}</textarea>
                    </div>
                </div>

                <div class="d-flex flex-wrap justify-content-between">
                    <div class="col-4 form-group pr-2">
                        <label for="email">E-mail</label>
                        <input type="text" class="form-control bg-white" id="email" name="email"
                            value="{{ $client->email }}" disabled>
                    </div>

                    <div class="col-4 form-group px-2">
                        <label for="telephone">Telefone</label>
                        <input type="text" class="form-control bg-white" id="telephone" name="telephone"
                            value="{{ $client->telephone }}" disabled>
                    </div>
                    <div class="col-4 form-group pl-2">
                        <label for="cell">Celular</label>
                        <input type="text" class="form-control bg-white" id="cell" name="cell"
                            value="{{ $client->cell }}" disabled>
                    </div>
                </div>

                <div class="d-flex flex-wrap justify-content-between">
                    <div class="col-6 form-group pr-2">
                        <label for="zipcode">CEP</label>
                        <input type="text" class="form-control bg-white" id="zipcode" name="zipcode"
                            value="{{ $client->zipcode }}" disabled>
                    </div>
                    <div class="col-6 form-group pl-2">
                        <label for="street">Rua</label>
                        <input type="text" class="form-control bg-white" id="street" name="street"
                            value="{{ $client->street }}" disabled>
                    </div>
                </div>

                <div class="d-flex flex-wrap justify-content-between">
                    <div class="col-6 form-group pr-2">
                        <label for="number">Número</label>
                        <input type="text" class="form-control bg-white" id="number" name="number"
                            value="{{ $client->number }}" disabled>
                    </div>
                    <div class="col-6 form-group pl-2">
                        <label for="complement">Complemento</label>
                        <input type="text" class="form-control bg-white" id="complement" name="complement"
                            value="{{ $client->complement }}" disabled>
                    </div>
                </div>

                <div class="d-flex flex-wrap justify-content-between">
                    <div class="col-6 form-group pr-2">
                        <label for="neighborhood">Bairro</label>
                        <input type="text" class="form-control bg-white" id="neighborhood" name="neighborhood"
                            value="{{ $client->neighborhood }}" disabled>
                    </div>
                    <div class="col-6 form-group pl-2">
                        <label for="city">Cidade</label>
                        <input type="text" class="form-control bg-white" id="city" name="city"
                            value="{{ $client->city }}" disabled>
                    </div>
                </div>

                <div class="d-flex flex-wrap justify-content-between">
                    <div class="col-6 form-group pr-2">
                        <label for="state">Estado</label>
                        <input type="text" class="form-control bg-white" id="state" name="state"
                            value="{{ $client->state }}" disabled>
                    </div>

                    <div class="col-6 form-group pl-2">
                        <label for="subsidiary_id">Filial</label>
                        <input type="text" class="form-control bg-white" id="subsidiary_id" name="subsidiary_id"
                            value="{{ $client->subsidiary->alias_name ?? null }}" disabled>

                    </div>

                </div>

                <div class="d-flex flex-wrap justify-content-between">
                    <div class="col-12 form-group px-2">
                        <label for="service">Serviço</label>
                        <textarea name="service" rows="2" class="form-control bg-white" id="service" disabled>{{ $client->service }}</textarea>
                    </div>
                </div>

                <div class="d-flex flex-wrap justify-content-between">
                    <div class="col-8 form-group pr-2">
                        <label for="company">Empresa</label>
                        <input type="text" class="form-control bg-white" id="company" name="company"
                            value="{{ $client->company }}" disabled>
                    </div>

                    <div class="col-4 form-group pl-2">
                        <label for="apartments">Nº de Apartamentos</label>
                        <input type="text" class="form-control bg-white" id="apartments" name="apartments"
                            value="{{ $client->apartments }}" disabled>
                    </div>
                </div>

                <div class="d-flex flex-wrap justify-content-between">
                    <div class="col-12 form-group px-2">
                        <label for="state">Observações</label>
                        <div class="p-2 border rounded">
                            {!! $client->observations !!}
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
@endsection

@section('custom_js')
    <script>
        window.onload = function() {
            $(".main-footer").remove();
            window.print();
            setTimeout(function() {
                window.close();
            }, 1000);
        }
    </script>
@endsection
