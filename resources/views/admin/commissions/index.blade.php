@extends('adminlte::page')

@section('title', '- Comissões')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-coins"></i> Comissões</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Comissões</li>
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

                    <div class="col-12 px-0">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Vendedores</h3>
                                <div class="card-tools">
                                    <span class="badge badge-info">Total de vendedores: {{ $sellers->count() }}</span>
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="card-body p-0">
                                <ul class="users-list clearfix d-flex nowrap" style="overflow-x: auto;">
                                    @forelse ($sellers as $seller)
                                        <li class="col-6 col-md-2">
                                            @if ($seller->photo)
                                                <img src="{{ url('storage/sellers/' . $seller->photo) }}"
                                                    alt="{{ $seller->name }}" class="img-circle img-fluid"
                                                    style="object-fit: cover; width: 100%; max-width: 75px; aspect-ratio: 1;">
                                            @else
                                                <img src="{{ asset('img/avatar.png') }}" alt="{{ $seller->name }}"
                                                    class="img-circle img-fluid" style="max-width: 75px;">
                                            @endif

                                            <a class="users-list-name"
                                                href="{{ route('admin.sellers.edit', ['seller' => $seller->id]) }}">{{ $seller->name }}</a>
                                            <a href="{{ route('admin.sellers.commissions', ['id' => $seller->id]) }}"
                                                target="_blank" title="Comissões" class="btn bg-warning"><i
                                                    class="text-black fa fa-coins"></i></a>
                                        </li>
                                    @empty
                                        <li>Não há vendedores cadastrados.</li>
                                    @endforelse
                                </ul>

                            </div>

                            <div class="card-footer text-center">
                                <a href="{{ route('admin.sellers.index') }}">Listagem</a>
                            </div>

                        </div>

                    </div>

                    @include('components.alert')

                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex flex-wrap justify-content-between col-12 align-content-center">
                                <h3 class="card-title align-self-center">Comissões Cadastradas</h3>
                                @can('Criar Comissões')
                                    <a href="{{ route('admin.commissions.create') }}" title="Nova Comissão"
                                        class="btn btn-success"><i class="fas fa-fw fa-plus"></i>Nova Comissão</a>
                                @endcan
                            </div>
                        </div>

                        @php
                            $heads = [['label' => 'ID', 'width' => 5], 'Autor', 'Filial', 'Vendedor', 'Produto', 'Obra', 'Valor da Obra', 'Valor da Comissão', 'Vencimento', 'Status', ['label' => 'Status', 'no-export' => true, 'width' => 5], ['label' => 'Ações', 'no-export' => true, 'width' => 20]];
                            $config = [
                                'order' => [[0, 'desc']],
                                'ajax' => url('/admin/commissions'),
                                'columns' => [['data' => 'id', 'name' => 'id'], ['data' => 'author', 'name' => 'author', 'visible' => false], ['data' => 'subsidiary', 'name' => 'subsidiary', 'visible' => false], ['data' => 'seller', 'name' => 'seller'], ['data' => 'product', 'name' => 'product'], ['data' => 'job', 'name' => 'job'], ['data' => 'job_value', 'name' => 'job_value'], ['data' => 'total_value', 'name' => 'total_value'], ['data' => 'due_date', 'name' => 'due_date'], ['data' => 'status', 'name' => 'status', 'visible' => false, 'searchable' => true], ['data' => 'btnStatus', 'name' => 'btnStatus'], ['data' => 'action', 'name' => 'action', 'orderable' => false, 'searchable' => false]],
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
                                    <div class="btn-group px-2" role="group" aria-label="Visualizar colunas">
                                        <form method="POST" action="{{ route('admin.commissions.changeStatus') }}">
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
                                striped hoverable beautify with-footer="comissions" />
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
