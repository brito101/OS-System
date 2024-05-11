@extends('adminlte::page')

@section('title', '- Modelos de Ordem de Serviço')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-list"></i> Modelos de Ordem de Serviço</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.service-orders.index') }}">Ordens de Serviço</a>
                        </li>
                        <li class="breadcrumb-item active">Modelos de Ordem de Serviço</li>
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


                    <div class="row">
                        <div class="col-12">
                            <div class="card card-primary card-tabs">
                                <div class="card-header p-0 pt-1">
                                    <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="custom-tabs-comercial-tab" data-toggle="pill"
                                                href="#default" role="tab" aria-controls="custom-tabs-comercial"
                                                aria-selected="true">Padrão</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="custom-tabs-comercial-tab" data-toggle="pill"
                                                href="#comercial" role="tab" aria-controls="custom-tabs-comercial"
                                                aria-selected="true">Comercial</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="custom-tabs-engineering-tab" data-toggle="pill"
                                                href="#engineering" role="tab" aria-controls="custom-tabs-engineering"
                                                aria-selected="false">Engenharia</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="custom-tabs-metering-tab" data-toggle="pill"
                                                href="#metering" role="tab" aria-controls="custom-tabs-metering"
                                                aria-selected="false">Medição</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div class="tab-pane fade show active" id="default" role="tabpanel"
                                            aria-labelledby="custom-tabs-comercial-tab">
                                            <div class="list-group">
                                                <a href="{{ route('admin.service-orders.create-model', ['model' => 'default']) }}"
                                                    class="list-group-item list-group-item-action">Ordem de Serviço sem
                                                    modelo específico</a>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade show" id="comercial" role="tabpanel"
                                            aria-labelledby="custom-tabs-comercial-tab">
                                            <div class="list-group">
                                                <a href="{{ route('admin.service-orders.create', ['model' => 'air-block']) }}"
                                                    class="list-group-item list-group-item-action">Ficha
                                                    técnica orçamentária de bloqueador de ar</a>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="engineering" role="tabpanel"
                                            aria-labelledby="custom-tabs-engineering-tab">
                                            Engenharia
                                        </div>
                                        <div class="tab-pane fade" id="metering" role="tabpanel"
                                            aria-labelledby="custom-tabs-metering-tab">
                                            Medição
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
