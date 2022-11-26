@extends('adminlte::page')
@section('adminlte_css')
    <style>
        @page {
            margin: 0 2cm;
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
                            <img src="{{ asset('img/logo.png') }}" class="col-2" style="width: 100px">
                            <h2 class="text-center col-9 d-flex align-items-center ml-5 mt-3 display-5 font-weight-bold">
                                Recibo nº {{ $commission->id }}
                            </h2>
                        </div>
                        <div class="card-body">
                            <p>Eu, {{ $commission->author }},
                                {{ $commission->document_person ? 'CPF nº ' . $commission->document_person . ', ' : '' }}
                                recebi a
                                quantia de <b>{{ $commission->total_value }}</b> referente a comissão de
                                {{ $commission->percentage }} sobre a venda do produto
                                {{ $commission->product }} na obra {{ $commission->job }}, com valor total de
                                {{ $commission->job_value }}
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
                                Recibo nº {{ $commission->id }}
                            </h2>
                        </div>
                        <div class="card-body">
                            <p>Eu, {{ $commission->author }},
                                {{ $commission->document_person ? 'CPF nº ' . $commission->document_person . ', ' : '' }}
                                recebi a
                                quantia de <b>{{ $commission->total_value }}</b> referente a comissão de
                                {{ $commission->percentage }} sobre a venda do produto
                                {{ $commission->product }} na obra {{ $commission->job }}, com valor total de
                                {{ $commission->job_value }}
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
                                Recibo nº {{ $commission->id }}
                            </h2>
                        </div>
                        <div class="card-body">
                            <p>Eu, {{ $commission->author }},
                                {{ $commission->document_person ? 'CPF nº ' . $commission->document_person . ', ' : '' }}
                                recebi a
                                quantia de <b>{{ $commission->total_value }}</b> referente a comissão de
                                {{ $commission->percentage }} sobre a venda do produto
                                {{ $commission->product }} na obra {{ $commission->job }}, com valor total de
                                {{ $commission->job_value }}
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
