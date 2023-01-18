@extends('adminlte::page')
@section('adminlte_css')
    <style>
        @page {
            margin: 2cm 2cm 0cm 2cm;
            font-size: 14px !important;
        }
    </style>
@endsection

@section('title', '- Recibo')

@section('content')

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card border border-primary border-3">
                        <div class="d-flex flex-wrap justify-content-center">
                            <img src="{{ asset('img/logo.png') }}" class="col-2" style="width: 70px">
                            <h2 class="text-center col-9 d-flex align-items-center ml-5 mt-3 display-5 font-weight-bold">
                                Recibo de Pagamento de Passagem nº {{ $ticketPayment->id }}
                            </h2>
                        </div>
                        <div class="card-body">
                            <p>Eu, {{ $ticketPayment->employee }}, recebi a
                                quantia de <b>{{ $ticketPayment->total_value }}</b> referente ao pagamento de passagens.</p>
                            <p>{{ $ticketPayment->observations ?? 'Observações: ' . $ticketPayment->observations }}
                            </p>
                            <p class="text-right mt-2">Em ___________________, _____ de _________________ de _________.
                            </p>
                            <p class="text-left mt-5">Assinatura:____________________________________________</p>
                            <p class="text-right font-italic">1ª Via</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-3 mb-5"><i class="fa fa-hand-scissors fa-rotate-180"></i>
                .....................................................................................................................................................................................................................................
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card border border-primary border-3">
                        <div class="d-flex flex-wrap justify-content-center">
                            <img src="{{ asset('img/logo.png') }}" class="col-2" style="width: 100px">
                            <h2 class="text-center col-9 d-flex align-items-center ml-5 mt-3 display-5 font-weight-bold">
                                Recibo de Pagamento de Passagem nº {{ $ticketPayment->id }}
                            </h2>
                        </div>
                        <div class="card-body">
                            <p>Eu, {{ $ticketPayment->employee }}, recebi a
                                quantia de <b>{{ $ticketPayment->total_value }}</b> referente ao pagamento de passagens.</p>
                            <p>{{ $ticketPayment->observations ?? 'Observações: ' . $ticketPayment->observations }}
                            </p>
                            <p class="text-right mt-2">Em ___________________, _____ de _________________ de _________.
                            </p>
                            <p class="text-left mt-5">Assinatura:____________________________________________</p>
                            <p class="text-right font-italic">2ª Via</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-3 mb-5"><i class="fa fa-hand-scissors fa-rotate-180"></i>
                .....................................................................................................................................................................................................................................
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card border border-primary border-3">
                        <div class="d-flex flex-wrap justify-content-center">
                            <img src="{{ asset('img/logo.png') }}" class="col-2" style="width: 100px">
                            <h2 class="text-center col-9 d-flex align-items-center ml-5 mt-3 display-5 font-weight-bold">
                                Recibo de Pagamento de Passagem nº {{ $ticketPayment->id }}
                            </h2>
                        </div>
                        <div class="card-body">
                            <p>Eu, {{ $ticketPayment->employee }}, recebi a
                                quantia de <b>{{ $ticketPayment->total_value }}</b> referente ao pagamento de passagens.
                            </p>
                            <p>{{ $ticketPayment->observations ?? 'Observações: ' . $ticketPayment->observations }}
                            </p>
                            <p class="text-right mt-2">Em ___________________, _____ de _________________ de _________.
                            </p>
                            <p class="text-left mt-5">Assinatura:____________________________________________</p>
                            <p class="text-right font-italic">Arquivo</p>
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
