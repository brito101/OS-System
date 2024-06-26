@extends('adminlte::page')

@section('title', '- Financeiro: Reembolsos')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-sync"></i><i class="fas fa-fw fa-money-bill"></i> Reembolsos</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Reembolsos</li>
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
                                    <span class="info-box-text">Reembolsos Pagos</span>
                                    <span class="info-box-number">{{ $pay }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6 col-md-4 px-0 px-md-2">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-down"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Reembolsos Pendentes</span>
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
                                <h3 class="card-title align-self-center">Reembolsos Cadastrados</h3>
                                @can('Criar Despesas')
                                    <a href="{{ route('admin.finance-refunds.create') }}" title="Novo Reembolso"
                                        class="btn btn-success"><i class="fas fa-fw fa-plus"></i>Novo Reembolso</a>
                                @endcan
                            </div>
                        </div>

                        @php
                            $heads = [['label' => 'ID', 'width' => 5], 'Autor', 'Filial', 'Descrição', 'Valor', 'Vencimento', ['label' => 'Data', 'no-export' => true], 'Status', ['label' => 'Status', 'no-export' => true, 'width' => 5], ['label' => 'Ações', 'no-export' => true, 'width' => 20]];
                            $config = [
                                'order' => [[0, 'desc']],
                                'ajax' => url('/admin/finance-refunds'),
                                'columns' => [['data' => 'id', 'name' => 'id'], ['data' => 'author', 'name' => 'author', 'visible' => false], ['data' => 'subsidiary', 'name' => 'subsidiary', 'visible' => false], ['data' => 'description', 'name' => 'description'], ['data' => 'value', 'name' => 'value'], ['data' => 'due_date_pt', 'name' => 'due_date'], ['data' => 'due_date_pt', 'name' => 'due_date_pt', 'visible' => false], ['data' => 'status', 'name' => 'status', 'visible' => false], ['data' => 'btnStatus', 'name' => 'status'], ['data' => 'action', 'name' => 'action', 'orderable' => false, 'searchable' => false]],
                                'language' => ['url' => asset('vendor/datatables/js/pt-BR.json')],
                                'autoFill' => true,
                                'processing' => true,
                                'serverSide' => true,
                                'responsive' => true,
                                'pageLength' => 200,
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

                        <div class="card-body pb-0">
                            <div class="d-flex flex-wrap justify-content-between">
                                <div class="col-12 col-md-2">
                                    <div class="btn-group px-2" role="group" aria-label="Visualizar colunas">
                                        <button type="button" class="toggle-vis btn btn-info"
                                            data-column="1">Autor</button>
                                        <button type="button" class="toggle-vis btn btn-info"
                                            data-column="2">Filial</button>
                                    </div>
                                </div>

                                <div class="col-12 col-md-10 d-flex flex-wrap justify-content-center">
                                    <h5 class="col-12 h6 text-muted text-center">Alterações em lote</h5>
                                    <div class="px-2 col-12 col-md-3 d-flex justify-content-center">
                                        <form method="POST" action="{{ route('admin.finance-refunds.changeStatus') }}"
                                            class="w-100">
                                            @csrf
                                            <input type="hidden" name="ids" value="" id="ids"
                                                class="ids">
                                            <button type="submit" id="change-status"
                                                class="change-status btn btn-warning w-100"
                                                data-confirm="Confirma a alteração de status?"><i
                                                    class="fas fa-fw fa-sync"></i>
                                                Status</button>
                                        </form>
                                    </div>
                                    <div class="px-2 col-12 col-md-6 d-flex justify-content-center">
                                        <form method="POST" action="{{ route('admin.finance-refunds.changeValue') }}"
                                            class="d-flex flex-wrap justify-content-between w-100">
                                            @csrf
                                            <input type="hidden" name="ids" value="" id="ids"
                                                class="ids">
                                            <div class="form-group col-6 my-2 my-md-0 w-100">
                                                <input type="text" name="value" class="money_format_2 form-control">
                                            </div>
                                            <div class="col-6">
                                                <button type="submit" id="change-value"
                                                    class="btn btn-success my-2 my-md-0 w-100"
                                                    data-confirm="Confirma a alteração do valor?"><i
                                                        class="fas fa-fw fa-money-bill"></i> Valor</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="px-2 col-12 col-md-3 d-flex justify-content-center">
                                        <form method="POST" action="{{ route('admin.finance-refunds.batchDelete') }}"
                                            class="w-100">
                                            @csrf
                                            <input type="hidden" name="ids" value="" id="ids"
                                                class="ids">
                                            <button type="submit" id="batch-delete" class="btn btn-danger w-100"
                                                data-confirm="Confirma a exclusão desta seleção?"><i
                                                    class="fas fa-fw fa-trash"></i>
                                                Exclusão</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <x-adminlte-datatable id="table1" :heads="$heads" :heads="$heads" :config="$config"
                                striped hoverable beautify with-footer="invoice" />
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

        $('#table1 tbody').on('click', 'tr', function() {
            $(this).toggleClass('selected bg-dark');
            let rows = $('#table1')[0].rows;
            let ids = [];
            $.each(rows, function(i, el) {
                if ($(el).hasClass('selected')) {
                    ids.push(el.children[0].textContent);
                }
            });
            $(".ids").val(ids)
        });

        $("#batch-delete").on('click', function(e) {
            if (!confirm($(this).data('confirm'))) {
                e.stopImmediatePropagation();
                e.preventDefault();
            }
        });

        $("#change-value").on('click', function(e) {
            if (!confirm($(this).data('confirm'))) {
                e.stopImmediatePropagation();
                e.preventDefault();
            }
        });

        $("#change-status").on('click', function(e) {
            if (!confirm($(this).data('confirm'))) {
                e.stopImmediatePropagation();
                e.preventDefault();
            }
        });
    </script>
    <script src="{{ asset('vendor/jquery/jquery.inputmask.bundle.min.js') }}"></script>
    <script src="{{ asset('js/money.js') }}"></script>
@endsection
