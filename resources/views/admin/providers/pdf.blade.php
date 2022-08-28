@extends('adminlte::page')
@section('adminlte_css')
    <style>
        @page {
            margin: 2cm;
        }
    </style>
@endsection

@section('title', '- Ficha de Fornecedor')

@section('content')

    <div class="card">
        <div class="d-flex flex-wrap justify-content-center">
            {{-- <img src="{{ asset('img/logo.png') }}" style="width: 500px;"> --}}
            <h2 class="w-100 text-center">Ficha de Fornecedor</h2>
        </div>
        <div class="card-header">
            <h3 class="card-title">Dados Cadastrais do Fornecedor</h3>
        </div>

        <form>
            <div class="card-body">
                <div class="d-flex flex-wrap justify-content-between">
                    <div class="col-6 form-group pr-2">
                        <label for="social_name">Nome Social</label>
                        <input type="text" class="form-control bg-white" id="social_name" name="social_name"
                            value="{{ $provider->social_name }}" disabled>
                    </div>
                    <div class="col-6 form-group pl-2">
                        <label for="alias_name">Nome Fantasia</label>
                        <input type="text" class="form-control bg-white" id="alias_name" name="alias_name"
                            value="{{ $provider->alias_name }}" disabled>
                    </div>
                </div>

                <div class="d-flex flex-wrap justify-content-between">
                    <div class="col-4 form-group pr-2">
                        <label for="document_company">CNPJ</label>
                        <input type="text" class="form-control bg-white" id="document_company" name="document_company"
                            value="{{ $provider->document_company }}" disabled>
                    </div>

                    <div class="col-4 form-group px-2">
                        <label for="document_company_secondary">Inscrição Estadual</label>
                        <input type="text" class="form-control bg-white" id="document_company_secondary"
                            name="document_company_secondary" value="{{ $provider->document_company_secondary }}" disabled>
                    </div>

                    <div class="col-6 form-group pl-2">
                        <label for="activity">Ramo de Atividade</label>
                        <input type="text" class="form-control bg-white" id="activity" name="activity"
                            value="{{ $provider->activity }}" disabled>
                    </div>
                </div>

                <div class="d-flex flex-wrap justify-content-between">
                    <div class="col-6 form-group pr-2">
                        <label for="contact">Pessoa de Contato</label>
                        <input type="text" class="form-control bg-white" id="contact" name="contact"
                            value="{{ $provider->contact }}" disabled>
                    </div>

                    <div class="col-6 form-group pl-2">
                        <label for="function">Função</label>
                        <input type="text" class="form-control bg-white" id="function" name="function"
                            value="{{ $provider->function }}" disabled>
                    </div>
                </div>

                <div class="d-flex flex-wrap justify-content-between">
                    <div class="col-4 form-group pr-2">
                        <label for="email">E-mail</label>
                        <input type="email" class="form-control bg-white" id="email" name="email"
                            value="{{ $provider->email }}" disabled>
                    </div>

                    <div class="col-4 form-group px-2">
                        <label for="telephone">Telefone</label>
                        <input type="tel" class="form-control bg-white" id="telephone" name="telephone"
                            value="{{ $provider->telephone }}" disabled>
                    </div>
                    <div class="col-4 form-group pl-2">
                        <label for="cell">Celular</label>
                        <input type="tel" class="form-control bg-white" id="cell" name="cell"
                            value="{{ $provider->cell }}" disabled>
                    </div>
                </div>

                <div class="d-flex flex-wrap justify-content-between">
                    <div class="col-12 form-group px-0">
                        <label for="payment_conditions">Condições de Pagamento</label>
                        <input type="text" class="form-control bg-white" id="payment_conditions"
                            name="payment_conditions" value="{{ $provider->payment_conditions }}" disabled>
                    </div>
                </div>

                <div class="d-flex flex-wrap justify-content-between">
                    <div class="col-6 form-group pr-2">
                        <label for="average_delivery_time">Tempo Médio de Entrega</label>
                        <input type="text" class="form-control bg-white" id="average_delivery_time"
                            name="average_delivery_time" value="{{ $provider->average_delivery_time }}" disabled>
                    </div>

                    <div class="col-6 form-group pl-2">
                        <label for="discounts">Condições de Desconto</label>
                        <input type="text" class="form-control bg-white" id="discounts" name="discounts"
                            value="{{ $provider->discounts }}" disabled>
                    </div>
                </div>

                <div class="d-flex flex-wrap justify-content-between">
                    <div class="col-6 form-group pr-2">
                        <label for="products_offered">Produtos/Serviços</label>
                        <input type="text" class="form-control bg-white" id="products_offered"
                            name="products_offered" value="{{ $provider->products_offered }}" disabled>
                    </div>

                    <div class="col-6 form-group pl-2">
                        <label for="promotion_funds">Recursos Promocionais</label>
                        <input type="text" class="form-control bg-white" id="promotion_funds" name="promotion_funds"
                            value="{{ $provider->promotion_funds }}" disabled>
                    </div>
                </div>

                <div class="d-flex flex-wrap justify-content-between">
                    <div class="col-6 form-group pr-2">
                        <label for="technical_assistance">Assistência Técnica</label>
                        <input type="text" class="form-control bg-white" id="technical_assistance"
                            name="technical_assistance" value="{{ $provider->technical_assistance }}"disabled>
                    </div>

                    <div class="col-6 form-group pl-2">
                        <label for="total_purchases_previous_year">Total adquirido no ano anterior</label>
                        <input type="text" class="form-control bg-white" id="total_purchases_previous_year"
                            name="total_purchases_previous_year" value="{{ $provider->total_purchases_previous_year }}"
                            disabled>
                    </div>
                </div>

                <div class="d-flex flex-wrap justify-content-between">
                    <div class="col-6 form-group pr-2">
                        <label for="zipcode">CEP</label>
                        <input type="tel" class="form-control bg-white" id="zipcode" name="zipcode"
                            value="{{ $provider->zipcode }}" disabled>
                    </div>
                    <div class="col-6 form-group pl-2">
                        <label for="street">Rua</label>
                        <input type="text" class="form-control bg-white" id="street" placeholder="Rua"
                            name="street" value="{{ $provider->street }}" disabled>
                    </div>
                </div>

                <div class="d-flex flex-wrap justify-content-between">
                    <div class="col-6 form-group pr-2">
                        <label for="number">Número</label>
                        <input type="text" class="form-control bg-white" id="number" name="number"
                            value="{{ $provider->number }}" disabled>
                    </div>
                    <div class="col-6 form-group pl-2">
                        <label for="complement">Complemento</label>
                        <input type="text" class="form-control bg-white" id="complement" name="complement"
                            value="{{ $provider->complement }}" disabled>
                    </div>
                </div>

                <div class="d-flex flex-wrap justify-content-between">
                    <div class="col-6 form-group pr-2">
                        <label for="neighborhood">Bairro</label>
                        <input type="text" class="form-control bg-white" id="neighborhood" name="neighborhood"
                            value="{{ $provider->neighborhood }}" disabled>
                    </div>
                    <div class="col-6 form-group pl-2">
                        <label for="city">Cidade</label>
                        <input type="text" class="form-control bg-white" id="city" name="city"
                            value="{{ $provider->city }}" disabled>
                    </div>
                </div>

                <div class="d-flex flex-wrap justify-content-between">
                    <div class="col-6 form-group pr-2">
                        <label for="state">Estado</label>
                        <input type="text" class="form-control bg-white" id="state" name="state"
                            value="{{ $provider->state }}" disabled>
                    </div>
                </div>

                <div class="d-flex flex-wrap justify-content-between">
                    <div class="col-12 form-group px-2">
                        <label for="state">Observações</label>
                        <div class="p-2 border rounded">
                            {!! $provider->observations !!}
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
