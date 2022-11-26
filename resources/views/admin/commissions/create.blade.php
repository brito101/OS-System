@extends('adminlte::page')

@section('title', '- Cadastro de Comissão')
@section('plugins.select2', true)

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-coins"></i> Nova Comissão</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.commissions.index') }}">Comissões</a></li>
                        <li class="breadcrumb-item active">Nova Comissão</li>
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
                            <h3 class="card-title">Dados Cadastrais da Comissão</h3>
                        </div>

                        <form method="POST" action="{{ route('admin.commissions.store') }}">
                            @csrf
                            <div class="card-body">

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2 mb-0">
                                        <label for="seller_id">Vendedor</label>
                                        <x-adminlte-select2 name="seller_id" required>
                                            @foreach ($sellers as $seller)
                                                <option {{ old('seller_id') == $seller->id ? 'selected' : '' }}
                                                    value="{{ $seller->id }}">{{ $seller->name }}
                                                    ({{ $seller->document_person }})
                                                </option>
                                            @endforeach
                                        </x-adminlte-select2>
                                    </div>
                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                        <label for="product">Produto</label>
                                        <input type="text" class="form-control" id="product"
                                            placeholder="Descrição do Produto" name="product" value="{{ old('product') }}"
                                            required>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 form-group px-0">
                                        <label for="job">Obra</label>
                                        <input type="text" class="form-control" id="job"
                                            placeholder="Descrição da Obra" name="job" value="{{ old('job') }}"
                                            required>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-4 form-group px-0 pr-md-2">
                                        <label for="job_value">Valor da Obra</label>
                                        <input type="text" class="form-control money_format_2" id="job_value"
                                            placeholder="Descrição da Obra" name="job_value" value="{{ old('job_value') }}"
                                            required onchange="calc()">
                                    </div>
                                    <div class="col-12 col-md-4 form-group px-0 px-md-2">
                                        <label for="percentage">Percentual de Comissão</label>
                                        <input type="text" class="form-control percentage" id="percentage"
                                            placeholder="Valor da porcentagem" name="percentage"
                                            value="{{ old('percentage') }}" required onchange="calc()">
                                    </div>
                                    <div class="col-12 col-md-4 form-group px-0 pl-md-2">
                                        <label for="total_value">Total</label>
                                        <input type="text" class="form-control money_format_2" id="total_value"
                                            placeholder="Total da Comissão" name="total_value"
                                            value="{{ old('total_value') }}" required>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-4 form-group px-0 pr-md-2">
                                        <label for="due_date">Vencimento</label>
                                        <input type="text" class="form-control date" id="due_date"
                                            placeholder="dd/mm/yyyy" name="due_date" value="{{ old('due_date') }}"
                                            required>
                                    </div>

                                    <div class="col-12 col-md-4 form-group px-0 px-md-2 mb-0">
                                        <label for="status">Status</label>
                                        <x-adminlte-select2 name="status">
                                            <option {{ old('status') == 'pendente' ? 'selected' : '' }} value="pendente">
                                                Pendente
                                            </option>
                                            <option {{ old('status') == 'pago' ? 'selected' : '' }} value="pago">
                                                Pago
                                            </option>
                                        </x-adminlte-select2>
                                    </div>

                                    <div class="col-12 col-md-4 form-group px-0 pl-md-2 mb-0">
                                        <label for="subsidiary_id">Filial</label>
                                        <x-adminlte-select2 name="subsidiary_id" required>
                                            @foreach ($subsidiaries as $subsidiary)
                                                <option {{ old('subsidiary_id') == $subsidiary->id ? 'selected' : '' }}
                                                    value="{{ $subsidiary->id }}">{{ $subsidiary->alias_name }}
                                                </option>
                                            @endforeach
                                        </x-adminlte-select2>
                                    </div>
                                </div>

                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Enviar</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('custom_js')
    <script src="{{ asset('vendor/jquery/jquery.inputmask.bundle.min.js') }}"></script>
    <script src="{{ asset('js/money.js') }}"></script>
    <script src="{{ asset('js/date.js') }}"></script>
    <script>
        function calc() {
            let job_value = Number($("#job_value").val().toString().replace(["R$ ", ","], ['', "."]));
            let percentage = Number($("#percentage").val().toString().replace(" %", '').replace(",", '.'));

            total_value = (job_value * percentage / 100).toLocaleString('pt-br', {
                style: 'currency',
                currency: 'BRL'
            });
            $("#total_value").val(total_value);
        }
        calc();
    </script>
@endsection
