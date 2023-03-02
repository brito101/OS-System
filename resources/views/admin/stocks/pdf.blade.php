@extends('adminlte::page')
@section('adminlte_css')
    <style>
        @page {
            margin: 2cm;
        }
    </style>
@endsection

@section('title', '- Movimentação')

@section('content')

    <div class="card">
        <div class="d-flex flex-wrap justify-content-center">
            <img src="{{ asset('img/logo.png') }}" class="col-2" style="width: 100px">
            <h2 class="text-center col-9 d-flex align-items-center ml-5 mt-3 display-5 font-weight-bold">Movimentação
                #{{ $stock->id }}
            </h2>
        </div>
        <div class="card-header">
            <h3 class="card-title">Dados Cadastrais da Movimentação</h3>
        </div>

        <div class="card-body pb-0 pt-1 text-muted text-right">Criada
            {{ isset($stock->user->name) ? 'por ' . $stock->user->name : '' }} em
            {{ $stock->created_at }} hs.</div>

        <form>
            <div class="card-body">

                <div class="d-flex flex-wrap justify-content-between">
                    <div class="col--5 form-group pr-2">
                        <label for="product_id">Produto</label>
                        <input type="text" class="form-control bg-white" id="product_id" name="product_id"
                            value="{{ $stock->product }}" disabled>
                    </div>

                    <div class="col-4 form-group px-2">
                        <label for="provider_id">Fornecedor</label>
                        <input type="text" class="form-control bg-white" id="provider_id" name="provider_id"
                            value="{{ $stock->provider->alias_name ?? null }}" disabled>
                    </div>

                    <div class="col-3 form-group pl-2">
                        <label for="day">Dia</label>
                        <input type="text" class="form-control bg-white" id="day" name="day"
                            value="{{ $stock->day }}" disabled>
                    </div>

                </div>

                <div class="d-flex flex-wrap justify-content-between">
                    <div class="col-5 form-group pr-2">
                        <label for="subsidiary_id">Filial</label>
                        <input type="text" class="form-control bg-white" id="subsidiary_id" name="subsidiary_id"
                            value="{{ $stock->subsidiary }}" disabled>
                    </div>

                    <div class="col-7 form-group pl-2">
                        <label for="job">Obra</label>
                        <input type="text" class="form-control bg-white" id="job" name="job"
                            value="{{ $stock->job }}" disabled>
                    </div>
                </div>

                <div class="d-flex flex-wrap justify-content-between">
                    <div class="col-4 form-group pr-2">
                        <label for="liberator">Liberado por</label>
                        <input type="text" class="form-control bg-white" id="liberator" name="liberator"
                            value="{{ $stock->liberator }}" disabled>
                    </div>

                    <div class="col-4 form-group px-2">
                        <label for="stripper">Retirado por</label>
                        <input type="text" class="form-control bg-white" id="stripper" name="stripper"
                            value="{{ $stock->stripper }}" disabled>
                    </div>

                    <div class="col-4 form-group pl-2">
                        <label for="lecturer">Conferente</label>
                        <input type="text" class="form-control bg-white" id="lecturer" name="lecturer"
                            value="{{ $stock->lecturer }}" disabled>
                    </div>
                </div>

                <div class="d-flex flex-wrap justify-content-between">
                    <div class="col-3 form-group pr-2">
                        <label for="value">Valor</label>
                        <input type="text" class="form-control bg-white" id="value" name="value"
                            value="{{ $stock->value }}" disabled>
                    </div>

                    <div class="col-3 form-group px-2">
                        <label for="validity">Validade do Produto</label>
                        <input type="text" class="form-control bg-white" id="validity" name="validity"
                            value="{{ $stock->validity }}" disabled>
                    </div>

                    <div class="col-3 form-group px-2">
                        <label for="input">Entrada</label>
                        <input type="text" class="form-control bg-white" id="input" name="input"
                            value="{{ $stock->input }}" disabled>
                    </div>
                    <div class="col-3 form-group pl-2">
                        <label for="output">Saída</label>
                        <input type="text" class="form-control bg-white" id="output" name="output"
                            value="{{ $stock->output }}" disabled>
                    </div>
                </div>

                <div class="d-flex flex-wrap justify-content-between">
                    <div class="col-12 form-group px-0">
                        <label for="observations">Observações</label>
                        <textarea name="observations" class="form-control bg-white" id="observations" disabled>{{ $stock->observations }}</textarea>
                    </div>
                </div>

                @if ($stock->photo != null)
                    <div class="d-flex flex-wrap justify-content-center">
                        <div class="embed-responsive embed-responsive-16by9 col-6 form-group px-0">
                            <img src="{{ url('storage/inventories/' . $stock->photo) }}" alt="Imagem capturada"
                                class="embed-responsive-item shadow-sm border border-1 border-primary rounded"
                                style="max-width: 75%; left: 12.5%;"></canvas>
                        </div>
                    </div>
                @endif

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
