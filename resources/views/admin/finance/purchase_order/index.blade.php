@extends('adminlte::page')

@section('title', '- Financeiro: Ordens de Compra')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-cart-plus"></i> Ordens de Compra</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Ordens de Compra</li>
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
                                <h3 class="card-title align-self-center">Ordens de Compra Cadastradas</h3>
                                @can('Criar Ordens de Compra')
                                    <a href="{{ route('admin.finance-purchase-orders.create') }}" title="Nova Ordem de Compra"
                                        class="btn btn-success"><i class="fas fa-fw fa-plus"></i>Nova Ordem de Compra</a>
                                @endcan
                            </div>
                        </div>

                        @php
                            $heads = [['label' => 'ID', 'width' => 5], 'Autor', 'Filial', 'NS', 'Data', 'Obra', 'Solicitante', 'Entrega', 'Valor', 'Status', ['label' => 'Status', 'no-export' => true, 'width' => 5], ['label' => 'Ações', 'no-export' => true, 'width' => 20]];
                            $config = [
                                'order' => [[0, 'desc']],
                                'ajax' => url('/admin/finance-purchase-orders'),
                                'columns' => [['data' => 'id', 'name' => 'id'], ['data' => 'author', 'name' => 'author', 'visible' => false], ['data' => 'subsidiary', 'name' => 'subsidiary', 'visible' => false], ['data' => 'number_series', 'name' => 'number_series'], ['data' => 'date', 'name' => 'date'], ['data' => 'job', 'name' => 'job'], ['data' => 'requester', 'name' => 'requester'], ['data' => 'forecast', 'name' => 'forecast'], ['data' => 'value', 'name' => 'value'], ['data' => 'status', 'name' => 'status', 'visible' => false], ['data' => 'btnStatus', 'name' => 'btnStatus'], ['data' => 'action', 'name' => 'action', 'orderable' => false, 'searchable' => false]],
                                'language' => ['url' => asset('vendor/datatables/js/pt-BR.json')],
                                'autoFill' => true,
                                'processing' => true,
                                'serverSide' => true,
                                'responsive' => true,
                                'dom' => '<"d-flex flex-wrap col-12 justify-content-between"Bf>rtip',
                                'buttons' => [
                                    ['extend' => 'pageLength', 'className' => 'btn-default'],
                                    ['extend' => 'copy', 'className' => 'btn-default', 'text' => '<i class="fas fa-fw fa-lg fa-copy text-secondary"></i>', 'titleAttr' => 'Copiar', 'exportOptions' => ['columns' => ':not([dt-no-export])']],
                                    ['extend' => 'print', 'className' => 'btn-default', 'text' => '<i class="fas fa-fw fa-lg fa-print text-info"></i>', 'titleAttr' => 'Imprimir', 'exportOptions' => ['columns' => ':not([dt-no-export])']],
                                    ['extend' => 'csv', 'className' => 'btn-default', 'text' => '<i class="fas fa-fw fa-lg fa-file-csv text-primary"></i>', 'titleAttr' => 'Exportar para CSV', 'exportOptions' => ['columns' => ':not([dt-no-export])']],
                                    ['extend' => 'excel', 'className' => 'btn-default', 'text' => '<i class="fas fa-fw fa-lg fa-file-excel text-success"></i>', 'titleAttr' => 'Exportar para Excel', 'exportOptions' => ['columns' => ':not([dt-no-export])']],
                                    ['extend' => 'pdf', 'className' => 'btn-default', 'text' => '<i class="fas fa-fw fa-lg fa-file-pdf text-danger"></i>', 'titleAttr' => 'Exportar para PDF', 'exportOptions' => ['columns' => ':not([dt-no-export])']],
                                ],
                            ];
                        @endphp

                        <div class="card-body pb-0">
                            <span class="text-muted text-sm px-2">Alterar visualização das colunas:</span>
                            <div class="btn-group px-2" role="group" aria-label="Visualizar colunas">
                                <button type="button" class="toggle-vis btn btn-info" data-column="1">Autor</button>
                                <button type="button" class="toggle-vis btn btn-info" data-column="2">Filial</button>
                            </div>
                        </div>

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

@section('custom_js')
    <script>
        $('button.toggle-vis').on('click', function(e) {
            e.preventDefault();
            var column = $('#table1').DataTable().column($(this).attr('data-column'));
            column.visible(!column.visible());
        });
    </script>
@endsection
