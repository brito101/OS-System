@extends('adminlte::page')

@section('title', '- Cadastro de Pagamento de Passagem')
@section('plugins.select2', true)

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-file-invoice-dollar"></i> Novo Pagamento de Passagem</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.ticket-payments.index') }}">Pagamentos de
                                Passagens</a></li>
                        <li class="breadcrumb-item active">Novo Pagamento de Passagem</li>
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
                            <h3 class="card-title">Dados Cadastrais da Passagem</h3>
                        </div>

                        <form method="POST" action="{{ route('admin.ticket-payments.store') }}">
                            @csrf
                            <div class="card-body">

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 form-group px-0">
                                        <label for="employee">Funcionário</label>
                                        <input type="text" class="form-control" id="employee"
                                            placeholder="Nome do Funcionário" name="employee" value="{{ old('employee') }}"
                                            required>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-3 form-group px-0 pr-md-2">
                                        <label for="total_value">Total</label>
                                        <input type="text" class="form-control money_format_2" id="total_value"
                                            placeholder="Total da Comissão" name="total_value"
                                            value="{{ old('total_value') }}" required>
                                    </div>

                                    <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                        <label for="due_date">Vencimento</label>
                                        <input type="date" class="form-control" id="due_date" placeholder="dd/mm/yyyy"
                                            name="due_date" value="{{ old('due_date') }}" required>
                                    </div>

                                    <div class="col-12 col-md-3 form-group px-0 px-md-2 mb-0">
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

                                    <div class="col-12 col-md-3 form-group px-0 pl-md-2 mb-0">
                                        <label for="subsidiary_id">Filial</label>
                                        <x-adminlte-select2 name="subsidiary_id">
                                            <option {{ old('subsidiary_id') == '' ? 'selected' : '' }} value="">Sem
                                                Filial</option>
                                            @foreach ($subsidiaries as $subsidiary)
                                                <option {{ old('subsidiary_id') == $subsidiary->id ? 'selected' : '' }}
                                                    value="{{ $subsidiary->id }}">{{ $subsidiary->alias_name }}
                                                </option>
                                            @endforeach
                                        </x-adminlte-select2>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 form-group px-0">
                                        <label for="observations">Observações</label>
                                        <textarea class="form-control" id="observations" placeholder="Dias trabalhados, valor da diária etc..."
                                            name="observations" rows="2">{{ old('observations') }}</textarea>
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
@endsection
