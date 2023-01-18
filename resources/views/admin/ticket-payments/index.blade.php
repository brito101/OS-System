@extends('adminlte::page')

@section('title', '- Pagamentos de Passagens')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-file-invoice-dollar"></i> Pagamentos de Passagens</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Pagamentos de Passagens</li>
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
                                <h3 class="card-title align-self-center">Pagamentos de Passagens Cadastrados</h3>
                                @can('Criar Pagamento de Passagens')
                                    <a href="{{ route('admin.ticket-payments.create') }}" title="Novo Pagamento de Passagem"
                                        class="btn btn-success"><i class="fas fa-fw fa-plus"></i>Novo Pagamento de Passagem</a>
                                @endcan
                            </div>
                        </div>

                        @php
                            $heads = [['label' => 'ID', 'width' => 5], 'Autor', 'Filial', 'Funcionário', 'Valor', 'Vencimento', ['label' => 'Data', 'no-export' => true], 'Status', ['label' => 'Status', 'no-export' => true, 'width' => 5], ['label' => 'Ações', 'no-export' => true, 'width' => 20]];
                            $config = [
                                'order' => [[0, 'desc']],
                                'ajax' => url('/admin/ticket-payments'),
                                'columns' => [['data' => 'id', 'name' => 'id'], ['data' => 'author', 'name' => 'author', 'visible' => false], ['data' => 'subsidiary', 'name' => 'subsidiary', 'visible' => false], ['data' => 'employee', 'name' => 'employee'], ['data' => 'total_value', 'name' => 'amount'], ['data' => 'due_date_pt', 'name' => 'due_date'], ['data' => 'due_date_pt', 'name' => 'due_date_pt', 'visible' => false], ['data' => 'status', 'name' => 'status', 'visible' => false, 'searchable' => true], ['data' => 'btnStatus', 'name' => 'btnStatus'], ['data' => 'action', 'name' => 'action', 'orderable' => false, 'searchable' => false]],
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
                                    ['extend' => 'pdf', 'className' => 'btn-default', 'text' => '<i class="fas  fa-fw fa-lg fa-file-pdf text-danger"></i>', 'titleAttr' => 'Exportar para PDF', 'exportOptions' => ['columns' => ':not([dt-no-export])']],
                                ],
                            ];
                        @endphp

                        <div class="card-body pb-0">
                            <div class="d-flex flex-wrap justify-content-between">
                                <div class="col-12 col-md-5">
                                    <span class="text-muted text-sm px-2">Alterar visualização das colunas:</span>
                                    <div class="btn-group px-2" role="group" aria-label="Visualizar colunas">
                                        <button type="button" class="toggle-vis btn btn-info"
                                            data-column="1">Autor</button>
                                        <button type="button" class="toggle-vis btn btn-info"
                                            data-column="2">Filial</button>
                                    </div>
                                </div>
                                <div class="col-12 col-md-7">
                                    <span class="text-muted text-sm px-2">Alterar status dos lançamentos (clique nas linhas
                                        para selecionar):</span>
                                    <div class="btn-group px-2" role="group" aria-label="Altera status">
                                        <form method="POST" action="{{ route('admin.ticket-payments.changeStatus') }}">
                                            @csrf
                                            <input type="hidden" name="ids" value="" id="ids">
                                            <button type="submit" class="change-status btn btn-info">Alterar</button>
                                        </form>
                                    </div>
                                </div>
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

        $('#table1 tbody').on('click', 'tr', function() {
            $(this).toggleClass('selected bg-dark');
            let rows = $('#table1')[0].rows;
            let ids = [];
            $.each(rows, function(i, el) {
                if ($(el).hasClass('selected')) {
                    ids.push(el.children[0].textContent);
                }
            });
            $("#ids").val(ids)
        });
    </script>
@endsection
