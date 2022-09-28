@extends('adminlte::page')
@section('plugins.select2', true)
@section('plugins.BsCustomFileInput', true)

@section('title', '- Edição de Despesa')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-minus"></i><i class="fas fa-fw fa-money-bill"></i> Editar Despesa
                        #{{ $invoice->id }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.finance-expenses.index') }}">Despesas</a></li>
                        <li class="breadcrumb-item active">Editar Despesa</li>
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
                            <h3 class="card-title">Dados Cadastrais da Despesa</h3>
                        </div>

                        <form method="POST"
                            action="{{ route('admin.finance-expenses.update', ['finance_expense' => $invoice->id]) }}"
                            enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <input type="hidden" value="{{ $invoice->id }}" name="id">
                            <div class="card-body">

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="description">Descrição</label>
                                        <input type="text" class="form-control" id="description"
                                            placeholder="Descrição da receita" name="description"
                                            value="{{ old('description') ?? $invoice->description }}" required>
                                    </div>

                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                        <label for="category">Categoria</label>
                                        <input type="text" class="form-control" id="category"
                                            placeholder="Nome da Categoria" name="category"
                                            value="{{ old('category') ?? $invoice->category }}" required>
                                    </div>

                                </div>

                                <div class="d-flex flex-wrap justify-content-start">

                                    <div class="col-12 col-md-3 form-group px-0 pr-md-2">
                                        <label for="value">Valor</label>
                                        <input type="text" class="form-control money_format_2" id="value"
                                            placeholder="Valor em reais" name="value"
                                            value="{{ old('value') ?? $invoice->value }}" required>
                                    </div>

                                    <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                        <label for="due_date">Data de Vencimento</label>
                                        <input type="text" class="form-control date" id="due_date"
                                            placeholder="dd/mm/yyyy" name="due_date"
                                            value="{{ old('due_date') ?? $invoice->due_date }}" required>
                                    </div>

                                    <div class="col-12 col-md-3 form-group px-0 px-md-2 mb-0">
                                        <label for="repetition">Repetição</label>
                                        <x-adminlte-select2 name="repetition">
                                            <option
                                                {{ old('repetition') == 'única' ? 'selected' : ($invoice->repetition == 'única' ? 'selected' : '') }}
                                                value="única">
                                                Única
                                            </option>
                                            <option
                                                {{ old('repetition') == 'mensal' ? 'selected' : ($invoice->repetition == 'mensal' ? 'selected' : '') }}
                                                value="mensal">
                                                Mensal
                                            </option>
                                            <option
                                                {{ old('repetition') == 'anual' ? 'selected' : ($invoice->repetition == 'anual' ? 'selected' : '') }}
                                                value="anual">
                                                Anual
                                            </option>
                                        </x-adminlte-select2>
                                    </div>

                                    <div class="col-12 col-md-3 form-group px-0 pl-md-2" id="quota_field">
                                        <label for="quota">Parcelas</label>
                                        <input type="number" min="1" class="form-control" id="quota"
                                            placeholder="Quantidade de Parcelas" name="quota"
                                            value="{{ old('quota') ?? $invoice->quota }}">
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 form-group px-0">
                                        <label for="annotation">Anotação</label>
                                        <textarea type="text" class="form-control" id="annotation" placeholder="Anotação, caso exista" name="annotation"
                                            rows="2">{{ old('annotation') ?? $invoice->annotation }}</textarea>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2 mb-0">
                                        <label for="subsidiary_id">Filial</label>
                                        <x-adminlte-select2 name="subsidiary_id">
                                            @foreach ($subsidiaries as $subsidiary)
                                                <option
                                                    {{ old('subsidiary_id') == $subsidiary->id ? 'selected' : ($invoice->subsidiary_id == $subsidiary->id ? 'selected' : '') }}
                                                    value="{{ $subsidiary->id }}">{{ $subsidiary->alias_name }}
                                                </option>
                                            @endforeach
                                        </x-adminlte-select2>
                                    </div>

                                    @if ($invoice->file)
                                        <div
                                            class="col-12 col-md-2 form-group px-0 px-md-2 mb-0 d-flex align-items-end pb-3">
                                            <a class="btn btn-primary w-100" download="anexo"
                                                href="{{ Storage::url($invoice->file) }}" title="anexo"><i
                                                    class="fa fa-file-download"></i> Anexo atual</a>
                                        </div>

                                        <div class="col-12 col-md-1 form-group px-0 px-md-2 mb-0">
                                            <label for="remove_file">Excluir?</label>
                                            <x-adminlte-select2 name="remove_file">
                                                <option {{ old('remove_file') == 'não' ? 'selected' : '' }}
                                                    value="não">
                                                    Não
                                                </option>
                                                <option {{ old('remove_file') == 'sim' ? 'selected' : '' }}
                                                    value="sim">
                                                    Sim
                                                </option>
                                            </x-adminlte-select2>
                                        </div>
                                    @endif

                                    <div
                                        class="col-12 {{ $invoice->file ? 'col-md-3' : 'col-md-6' }} form-group px-0 pl-md-2 mb-0">
                                        <x-adminlte-input-file name="file"
                                            label="{{ $invoice->file ? 'Atualizar ' : '' }}Anexo"
                                            placeholder="Selecione um arquivo..." />
                                    </div>

                                </div>

                                <div class="d-flex flex-wrap justify-content-start">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2 mb-0">
                                        <label for="purchase_mode">Método de Pagamento</label>
                                        <x-adminlte-select2 name="purchase_mode">
                                            <option
                                                {{ old('purchase_mode') == 'boleto' ? 'selected' : ($invoice->purchase_mode == 'boleto' ? 'selected' : '') }}
                                                value="boleto">
                                                Boleto
                                            </option>
                                            <option
                                                {{ old('purchase_mode') == 'cartão de crédito' ? 'selected' : ($invoice->purchase_mode == 'cartão de créditoto' ? 'selected' : '') }}
                                                value="cartão de crédito">
                                                Cartão de Crédito
                                            </option>
                                            <option
                                                {{ old('purchase_mode') == 'dinheiro' ? 'selected' : ($invoice->purchase_mode == 'dinheiro' ? 'selected' : '') }}
                                                value="dinheiro">
                                                Dinheiro
                                            </option>
                                            <option
                                                {{ old('purchase_mode') == 'PIX' ? 'selected' : ($invoice->purchase_mode == 'PIX' ? 'selected' : '') }}
                                                value="PIX">
                                                PIX
                                            </option>
                                            <option
                                                {{ old('purchase_mode') == 'transferência' ? 'selected' : ($invoice->purchase_mode == 'transferência' ? 'selected' : '') }}
                                                value="transferência">
                                                Transferência
                                            </option>
                                        </x-adminlte-select2>
                                    </div>

                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2 mb-0">
                                        <label for="status">Status</label>
                                        <x-adminlte-select2 name="status">
                                            <option
                                                {{ old('status') == 'pendente' ? 'selected' : ($invoice->status == 'pendente' ? 'selected' : '') }}
                                                value="pendente">
                                                Pendente
                                            </option>
                                            <option
                                                {{ old('status') == 'pago' ? 'selected' : ($invoice->status == 'pago' ? 'selected' : '') }}
                                                value="pago">
                                                Pago
                                            </option>
                                        </x-adminlte-select2>
                                    </div>
                                </div>

                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Atualizar</button>
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
    <script src="{{ asset('js/invoices.js') }}"></script>
@endsection
