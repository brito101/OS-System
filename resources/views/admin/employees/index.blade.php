@extends('adminlte::page')

@section('title', '- Funcionários')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)
@section('plugins.BsCustomFileInput', true)

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-users-cog"></i> Funcionários</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Funcionários</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    @can('Criar Funcionários')
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 d-flex justify-content-end pb-4">
                        <a class="btn btn-secondary" href="{{ Storage::url('worksheets/employees.xlsx') }}" download>Download
                            Planilha</a>
                    </div>
                </div>
            </div>
        </section>
    @endcan

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    @include('components.alert')

                    @can('Criar Clientes')
                        <div class="card card-solid">
                            <div class="card-header">
                                <i class="fas fa-fw fa-upload"></i> Importação de planilha para cadastro de produtos
                            </div>
                            <form action="{{ route('admin.employees.import') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body pb-0">
                                    <x-adminlte-input-file name="file" label="Arquivo" placeholder="Selecione o arquivo..."
                                        legend="Selecionar" />
                                </div>
                                <div class="card-footer">
                                    <button class="btn btn-primary">Importar</button>
                                </div>
                            </form>
                        </div>
                    @endcan

                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex flex-wrap justify-content-between col-12 align-content-center">
                                <h3 class="card-title align-self-center">Funcionários Cadastrados</h3>
                                @can('Criar Funcionários')
                                    <a href="{{ route('admin.employees.create') }}" title="Novo Funcionário"
                                        class="btn btn-success"><i class="fas fa-fw fa-plus"></i>Novo Funcionário</a>
                                @endcan
                            </div>
                        </div>

                        @php
                            $heads = [['label' => 'ID', 'width' => 5], 'Nome', 'Filial', 'Função', 'Celular', 'E-mail', 'Salário', 'PIX', ['label' => 'Ações', 'no-export' => true, 'width' => 20]];
                            $config = [
                                'order' => [[1, 'asc']],
                                'ajax' => url('/admin/employees'),
                                'columns' => [['data' => 'id', 'name' => 'id'], ['data' => 'name', 'name' => 'name'],
                                ['data' => 'subsidiary_name', 'name' => 'subsidiary_name'], ['data' => 'role', 'name' => 'role'],
                                ['data' => 'cell', 'name' => 'cell'], ['data' => 'email', 'name' => 'email'],
                                ['data' => 'salary', 'name' => 'salary'],
                                ['data' => 'pix', 'name' => 'pix'],
                                ['data' => 'action', 'name' => 'action', 'orderable' => false, 'searchable' => false]],
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
