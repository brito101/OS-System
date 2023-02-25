@extends('adminlte::page')

@section('title', '- Ordens de Serviço Pendentes')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-list"></i> Ordens de Serviço Pendentes</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.service-orders.index') }}">Ordens de Serviço</a>
                        </li>
                        <li class="breadcrumb-item active">Ordens de Serviço Pendentes</li>
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
                            <div class="d-flex flex-wrap justify-content-between col-12 align-content-center">
                                <h3 class="card-title align-self-center">Ordens de Serviço Pendentes Cadastradas</h3>
                            </div>
                        </div>

                        @php
                            $heads = [['label' => 'ID', 'width' => 5], 'NS', 'Atividade', 'Filial', 'Autor', 'Cliente', 'Endereço', 'Participante', 'Prioridade', 'Prazo', ['label' => 'Prazo_BR', 'no-export' => true], 'Status', 'Prontificação', ['label' => 'Prontificação_BR', 'no-export' => true], ['label' => 'Ações', 'no-export' => true, 'width' => 15]];
                            $config = [
                                'order' => [[0, 'desc']],
                                'ajax' => url('/admin/service-orders-pending'),
                                'columns' => [['data' => 'id', 'name' => 'id'], ['data' => 'number_series', 'name' => 'number_series'], ['data' => 'activity', 'name' => 'activity'], ['data' => 'subsidiary', 'name' => 'subsidiary'], ['data' => 'author', 'name' => 'author'], ['data' => 'client', 'name' => 'client'], ['data' => 'address', 'name' => 'address'], ['data' => 'collaborator', 'name' => 'collaborator'], ['data' => 'priority', 'name' => 'priority'], ['data' => 'deadline_pt', 'name' => 'deadline'], ['data' => 'deadline_pt', 'name' => 'deadline_pt', 'visible' => false], ['data' => 'status', 'name' => 'status'], ['data' => 'readiness_date_pt', 'name' => 'readiness_date'], ['data' => 'readiness_date_pt', 'name' => 'readiness_date_pt', 'visible' => false], ['data' => 'action', 'name' => 'action', 'orderable' => false, 'searchable' => false]],
                                'language' => ['url' => asset('vendor/datatables/js/pt-BR.json')],
                                'autoFill' => true,
                                'processing' => true,
                                'serverSide' => true,
                                'responsive' => true,
                                'pageLength' => 50,
                                'lengthMenu' => [[10, 50, 100, 500, 1000, -1], [10, 50, 100, 500, 1000, 'Tudo']],
                                'dom' => '<"d-flex flex-wrap col-12 justify-content-between"Bf>rtip',
                                'buttons' => [
                                    ['extend' => 'pageLength', 'className' => 'btn-default'],
                                    ['extend' => 'copy', 'className' => 'btn-default', 'text' => '<i class="fas fa-fw fa-lg fa-copy text-secondary"></i>', 'titleAttr' => 'Copiar', 'exportOptions' => ['columns' => ':not([dt-no-export])']],
                                    ['extend' => 'print', 'className' => 'btn-default', 'text' => '<i class="fas fa-fw fa-lg fa-print text-info"></i>', 'titleAttr' => 'Imprimir', 'exportOptions' => ['columns' => ':not([dt-no-export])']],
                                    ['extend' => 'csv', 'className' => 'btn-default', 'text' => '<i class="fas fa-fw fa-lg fa-file-csv text-primary"></i>', 'titleAttr' => 'Exportar para CSV', 'exportOptions' => ['columns' => ':not([dt-no-export])']],
                                    ['extend' => 'excel', 'className' => 'btn-default', 'text' => '<i class="fas fa-fw fa-lg fa-file-excel text-success"></i>', 'titleAttr' => 'Exportar para Excel', 'exportOptions' => ['columns' => ':not([dt-no-export])']],
                                    ['extend' => 'pdf', 'orientation' => 'landscape', 'className' => 'btn-default', 'text' => '<i class="fas fa-fw fa-lg fa-file-pdf text-danger"></i>', 'titleAttr' => 'Exportar para PDF', 'exportOptions' => ['columns' => ':not([dt-no-export])']],
                                ],
                            ];
                        @endphp

                        <div class="card-body">
                            <x-adminlte-datatable id="table1" :heads="$heads" :heads="$heads" :config="$config"
                                striped hoverable beautify />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
