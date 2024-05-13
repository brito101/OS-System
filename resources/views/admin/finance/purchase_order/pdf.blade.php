@extends('adminlte::page')
@section('adminlte_css')
    <style>
        @page {
            margin: 2cm;
        }
    </style>
@endsection

@section('title', '- Ordem de Compra')

@section('content')

    <div class="card">
        <div class="d-flex flex-wrap justify-content-center">
            <img src="{{ asset('img/logo.png') }}" class="col-2" style="width: 100px">
            <h2 class="text-center col-9 d-flex align-items-center ml-5 mt-3 display-5 font-weight-bold">Ordem de Compra
                #{{ $purchase->id }} - Nº Série {{ $purchase->number_series }}</h2>
        </div>

        <div class="card-header">
            <h3 class="card-title">Dados Cadastrais da Ordem de Compra</h3>
        </div>

        <div class="card-body pb-0 pt-1 text-muted text-right">Criada
            {{ isset($purchase->user->name) ? 'por ' . $purchase->user->name : '' }} em
            {{ $purchase->created_at }} hs.
        </div>

        <form>

            <div class="card-body">

                <div class="d-flex flex-wrap justify-content-between">
                    <div class="col-3 form-group pr-2">
                        <label for="date">Data</label>
                        <input type="text" class="form-control bg-white" id="date" name="date"
                            value="{{ $purchase->date }}" disabled>
                    </div>

                    <div class="col-3 form-group px-2">
                        <label for="amount">Quantidade</label>
                        <input type="text" class="form-control bg-white" id="amount" name="amount"
                            value="{{ (int) $purchase->amount }}" disabled>
                    </div>

                    <div class="col-6 form-group pl-2">
                        <label for="job">Obra</label>
                        <input type="text" class="form-control bg-white" id="job" name="job"
                            value="{{ $purchase->job }}" disabled>
                    </div>

                </div>

                <div class="d-flex flex-wrap justify-content-start">

                    <div class="col-6 form-group pr-2">
                        <label for="provider_id">Fornecedor</label>
                        <input type="text" class="form-control bg-white" id="provider_id" name="provider_id"
                            value="{{ $purchase->provider->alias_name }}" disabled>
                    </div>

                    <div class="col-3 form-group px-2">
                        <label for="value">Valor</label>
                        <input type="text" class="form-control bg-white" id="value" name="value"
                            value="{{ $purchase->value }}" disabled>
                    </div>

                    <div class="col-3 form-group pl-2">
                        <label for="invoice">Nota Fiscal</label>
                        <input type="text" class="form-control bg-white" id="invoice" name="invoice"
                            value="{{ $purchase->invoice }}" disabled>
                    </div>

                </div>

                <div class="d-flex flex-wrap justify-content-start" id="material">
                    @foreach ($materials as $material)
                        <div class="col-12 form-group px-0">
                            <label for="material_{{ $loop->index }}">Material {{ $loop->index + 1 }}
                            </label>
                            <input type="text" class="form-control bg-white" id="material_{{ $loop->index }}"
                                name="material_{{ $loop->index }}" value="{{ $material->description }}" disabled>
                        </div>
                    @endforeach
                </div>

                <div class="d-flex flex-wrap justify-content-start">
                    <div class="col-6 form-group pr-2">
                        <label for="requester">Solicitante</label>
                        <input type="text" class="form-control bg-white" id="requester" name="requester"
                            value="{{ $purchase->requester }}" disabled>
                    </div>

                    <div class="col-6 form-group pl-2">
                        <label for="authorized">Autorizado por:</label>
                        <input type="text" class="form-control bg-white" id="authorized" name="authorized"
                            value="{{ $purchase->authorized }}" disabled>
                    </div>
                </div>

                <div class="d-flex flex-wrap justify-content-between">
                    <div class="col-3 form-group pr-2">
                        <label for="authorized_date">Data de Autorização</label>
                        <input type="text" class="form-control bg-white" id="authorized_date" name="authorized_date"
                            value="{{ $purchase->authorized_date }}" disabled>
                    </div>

                    <div class="col-3 form-group px-2">
                        <label for="forecast">Previsão de Entrega</label>
                        <input type="text" class="form-control bg-white" id="forecast" name="forecast"
                            value="{{ $purchase->forecast }}" disabled>
                    </div>

                    <div class="col-6 form-group pl-2">
                        <label for="freight">Frete</label>
                        <input type="text" class="form-control bg-white" id="freight" name="freight"
                            value="{{ $purchase->freight }}" disabled>
                    </div>
                </div>

                <div class="d-flex flex-wrap justify-content-between">
                    <div class="col-12 form-group px-0">
                        <label for="subsidiary_id">Filial</label>
                        <input type="text" class="form-control bg-white" id="subsidiary_id" name="subsidiary_id"
                            value="{{ $purchase->subsidiary }}" disabled>
                    </div>
                </div>

                <div class="d-flex flex-wrap justify-content-start">
                    <div class="col-6 form-group pr-2">
                        <label for="purchase_mode">Forma de Pagamento</label>
                        <input type="text" class="form-control bg-white" id="purchase_mode" name="purchase_mode"
                            value="{{ $purchase->purchase_mode }}" disabled>
                    </div>

                    <div class="col-6 form-group pl-2">
                        <label for="status">Status</label>
                        <input type="text" class="form-control bg-white" id="status" name="status"
                            value="{{ $purchase->status }}" disabled>
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
