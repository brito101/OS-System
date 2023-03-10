@extends('adminlte::page')

@section('title', '- Orçamentos: Itens de Obra')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-list-ol"></i></i> Itens de Obra</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Orçamentos</a></li>
                        <li class="breadcrumb-item active">Itens de Obra</a></li>
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
                                <h3 class="card-title align-self-center">Itens de Obra Cadastrados</h3>
                                @can('Criar Itens de Obra')
                                    <a href="{{ route('admin.work-items.create') }}" title="Novo Item de Obra"
                                        class="btn btn-success"><i class="fas fa-fw fa-plus"></i>Novo Item de Obra</a>
                                @endcan
                            </div>
                        </div>

                        @php
                            $heads = [['label' => 'ID', 'width' => 5], 'Código de Mão de Obra', 'Descrição', 'Unidade', 'Categoria', 'Valor', ['label' => 'Valor_PT', 'no-export' => true], 'Imposto', ['label' => 'Imposto_PT', 'no-export' => true], 'Taxa Comercial', ['label' => 'Taxa Comercial_PT', 'no-export' => true], 'Taxa ADM', ['label' => 'ADM_PT', 'no-export' => true], ['label' => 'Ações', 'no-export' => true, 'width' => 10]];
                            $config = [
                                'order' => [[0, 'asc']],
                                'ajax' => url('/admin/budgets/work-items'),
                                'columns' => [['data' => 'id', 'name' => 'id'], ['data' => 'code', 'name' => 'code'], ['data' => 'description', 'name' => 'description'], ['data' => 'unity', 'name' => 'unity'], ['data' => 'category', 'name' => 'category'], ['data' => 'value_pt', 'name' => 'value'], ['data' => 'value_pt', 'name' => 'value_pt', 'visible' => false], ['data' => 'tax_pt', 'name' => 'tax'], ['data' => 'tax_pt', 'name' => 'tax_pt', 'visible' => false], ['data' => 'commercial_pt', 'name' => 'commercial'], ['data' => 'commercial_pt', 'name' => 'commercial_pt', 'visible' => false], ['data' => 'fee_pt', 'name' => 'fee'], ['data' => 'fee_pt', 'name' => 'fee_pt', 'visible' => false], ['data' => 'action', 'name' => 'action', 'orderable' => false, 'searchable' => false]],
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
                                striped hoverable beautify />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
