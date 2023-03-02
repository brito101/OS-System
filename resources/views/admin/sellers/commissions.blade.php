@extends('adminlte::page')

@section('title', "- Comissões Cadastradas para o vendedor {$seller->name}")
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-coins"></i> Comissões - {{ $seller->name }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.sellers.index') }}">Vendedores</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.commissions.index') }}">Comissões</a></li>
                        <li class="breadcrumb-item active">Comissões - Vendedor</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="d-flex flex-wrap justify-content-between px-0">
                        <div class="col-12 col-sm-6 col-md-4 px-0 pr-md-2">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-success elevation-1">
                                    <i class="fas fa-fw fa-thumbs-up"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Comissões Pagas</span>
                                    <span class="info-box-number">{{ $pay }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6 col-md-4 px-0 px-md-2">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-down"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Comissões Pendentes</span>
                                    <span class="info-box-number">{{ $receive }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6 col-md-4 px-0 pl-md-2">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-primary elevation-1"><i
                                        class="fas fa-money-bill-wave"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Balanço</span>
                                    <span class="info-box-number">{{ $balance }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    @include('components.alert')

                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex flex-wrap justify-content-between col-12 align-content-center">
                                <h3 class="card-title align-self-center">Comissões Cadastradas para o vendedor
                                    <b>{{ $seller->name }}</b>
                                </h3>
                            </div>
                        </div>

                        @php
                            $heads = [['label' => 'ID', 'width' => 5], 'Autor', 'Filial', 'Produto', 'Obra', 'Valor da Obra', 'Percentual', 'Valor Total', 'Vencimento', 'Status', ['label' => 'Ações', 'no-export' => true, 'width' => 10]];
                            $config = [
                                'order' => [[0, 'desc']],
                                'ajax' => url('#'),
                                'columns' => [['data' => 'id', 'name' => 'id'], ['data' => 'author', 'name' => 'author'], ['data' => 'subsidiary', 'name' => 'subsidiary'], ['data' => 'product', 'name' => 'product'], ['data' => 'job', 'name' => 'job'], ['data' => 'job_value', 'name' => 'job_value'], ['data' => 'percentage', 'name' => 'percentage'], ['data' => 'total_value', 'name' => 'total_value'], ['data' => 'due_date', 'name' => 'due_date'], ['data' => 'status', 'name' => 'status'], ['data' => 'action', 'name' => 'action', 'orderable' => false, 'searchable' => false]],
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
                                    ['extend' => 'copy', 'className' => 'btn-default', 'text' => '<i class="fas fa-fw fa-lg fa-copy text-secondary"></i>', 'titleAttr' => 'Copiar', 'exportOptions' => ['columns' => ':not([dt-no-export])'], 'footer' => true],
                                    ['extend' => 'print', 'className' => 'btn-default', 'text' => '<i class="fas fa-fw fa-lg fa-print text-info"></i>', 'titleAttr' => 'Imprimir', 'exportOptions' => ['columns' => ':not([dt-no-export])'], 'footer' => true],
                                    ['extend' => 'csv', 'className' => 'btn-default', 'text' => '<i class="fas fa-fw fa-lg fa-file-csv text-primary"></i>', 'titleAttr' => 'Exportar para CSV', 'exportOptions' => ['columns' => ':not([dt-no-export])'], 'footer' => true],
                                    ['extend' => 'excel', 'className' => 'btn-default', 'text' => '<i class="fas fa-fw fa-lg fa-file-excel text-success"></i>', 'titleAttr' => 'Exportar para Excel', 'exportOptions' => ['columns' => ':not([dt-no-export])'], 'footer' => true],
                                    ['extend' => 'pdf', 'className' => 'btn-default', 'text' => '<i class="fas fa-fw fa-lg fa-file-pdf text-danger"></i>', 'titleAttr' => 'Exportar para PDF', 'exportOptions' => ['columns' => ':not([dt-no-export])'], 'footer' => true],
                                ],
                            ];
                        @endphp

                        <div class="card-body">
                            <x-adminlte-datatable id="table1" :heads="$heads" :heads="$heads" :config="$config"
                                striped hoverable beautify with-footer="comissions" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
