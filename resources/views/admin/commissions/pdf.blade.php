@extends('adminlte::page')
@section('adminlte_css')
    <style>
        @page {
            margin: 2cm;
        }
    </style>
@endsection

@section('title', '- Comissão')

@section('content')

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="d-flex flex-wrap justify-content-center">
                            <img src="{{ asset('img/logo.png') }}" class="col-2" style="width: 100px">
                            <h2 class="text-center col-9 d-flex align-items-center ml-5 mt-3 display-5 font-weight-bold">
                                Comissão
                                #{{ $commission->id }}
                            </h2>
                        </div>

                        <div class="card-header">
                            <h3 class="card-title">Dados Cadastrais da Comissão</h3>
                        </div>

                        <div class="card-body pb-0 pt-1 text-muted text-right">Criada
                            {{ isset($commission->author) ? 'por ' . $commission->author : '' }} em
                            {{ $commission->created_at }} hs.</div>

                        <form>
                            <div class="card-body">

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-6 form-group pr-2">
                                        <label for="seller_id">Vendedor</label>
                                        <input type="text" class="form-control bg-white" id="seller_id" name="seller_id"
                                            value="{{ $commission->seller }}" disabled>
                                    </div>
                                    <div class="col-6 form-group pl-2">
                                        <label for="product">Produto</label>
                                        <input type="text" class="form-control bg-white" id="product" name="product"
                                            value="{{ $commission->product }}" disabled>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 form-group px-0">
                                        <label for="job">Obra</label>
                                        <input type="text" class="form-control bg-white" id="job" name="job"
                                            value="{{ $commission->job }}" disabled>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-4 form-group pr-2">
                                        <label for="job_value">Valor da Obra</label>
                                        <input type="text" class="form-control bg-white" id="job_value" name="job_value"
                                            value="{{ $commission->job_value }}" disabled>
                                    </div>
                                    <div class="col-4 form-group px-2">
                                        <label for="percentage">Percentual de Comissão</label>
                                        <input type="text" class="form-control bg-white" id="percentage"
                                            name="totpercentageal_value" value="{{ $commission->percentage }}" disabled>
                                    </div>
                                    <div class="col-4 form-group pl-2">
                                        <label for="total_value">Total</label>
                                        <input type="text" class="form-control bg-white" id="total_value"
                                            name="total_value" value="{{ $commission->total_value }}" disabled>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-4 form-group pr-2">
                                        <label for="due_date">Vencimento</label>
                                        <input type="text" class="form-control bg-white" id="due_date" name="due_date"
                                            value="{{ $commission->due_date }}" disabled>
                                    </div>

                                    <div class="col-4 form-group px-2">
                                        <label for="status">Status</label>
                                        <input type="text" class="form-control bg-white" id="status" name="status"
                                            value="{{ $commission->status }}" disabled>
                                    </div>

                                    <div class="col-4 form-group pl-2">
                                        <label for="subsidiary_id">Filial</label>
                                        <input type="text" class="form-control bg-white" id="subsidiary_id"
                                            name="subsidiary_id" value="{{ $commission->subsidiary }}" disabled>
                                    </div>
                                </div>

                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
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
