@extends('adminlte::page')
@section('adminlte_css')
    <style>
        textarea {
            overflow: auto;
        }

        @page {
            margin: 2cm;
        }
    </style>
@endsection

@section('title', '- Pagamento de Passagem')

@section('content')

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="d-flex flex-wrap justify-content-center">
                            <img src="{{ asset('img/logo.png') }}" class="col-2" style="width: 100px">
                            <h2 class="text-center col-9 d-flex align-items-center ml-5 mt-3 display-5 font-weight-bold">
                                Pagamento de Passagem
                                #{{ $ticketPayment->id }}
                            </h2>
                        </div>

                        <div class="card-header">
                            <h3 class="card-title">Dados Cadastrais da Passagem</h3>
                        </div>

                        <div class="card-body pb-0 pt-1 text-muted text-right">Criada
                            {{ isset($ticketPayment->author) ? 'por ' . $ticketPayment->author : '' }} em
                            {{ $ticketPayment->created_at }} hs.</div>

                        <div class="card-body">

                            <div class="d-flex flex-wrap justify-content-between">
                                <div class="col-12 form-group px-0">
                                    <label for="employee">Funcionário</label>
                                    <input type="text" class="form-control bg-white" id="employee" name="employee"
                                        value="{{ $ticketPayment->employee }}" disabled>
                                </div>
                            </div>

                            <div class="d-flex flex-wrap justify-content-between">
                                <div class="col-3 form-group pr-2">
                                    <label for="total_value">Total</label>
                                    <input type="text" class="form-control money_format_2 bg-white" id="total_value"
                                        name="total_value" value="{{ $ticketPayment->total_value }}" disabled>
                                </div>

                                <div class="col-3 form-group px-2">
                                    <label for="due_date">Vencimento</label>
                                    <input type="date" class="form-control bg-white" id="due_date" name="due_date"
                                        value="{{ $ticketPayment->due_date }}" required disabled>
                                </div>

                                <div class="col-3 form-group px-2">
                                    <label for="status">Status</label>
                                    <input type="text" class="form-control bg-white" id="status" name="status"
                                        value="{{ $ticketPayment->status }}" disabled>
                                </div>

                                <div class="col-3 form-group pl-2">
                                    <label for="subsidiary_id">Filial</label>
                                    <input type="text" class="form-control bg-white" id="subsidiary_id"
                                        name="subsidiary_id" value="{{ $ticketPayment->subsidiary }}" disabled>
                                </div>
                            </div>

                            @if ($ticketPayment->observations)
                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 form-group px-0">
                                        <label for="observations">Observações</label>
                                        <textarea class="form-control bg-white" id="observations" name="observations" disabled>{{ $ticketPayment->observations }}</textarea>
                                    </div>
                                </div>
                            @endif

                        </div>

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
