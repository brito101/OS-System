@extends('adminlte::page')

@section('title', '- Despesa')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-minus"></i><i class="fas fa-fw fa-money-bill"></i> Despesa #{{ $invoice->id }}
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.finance-expenses.index') }}">Despesas</a></li>
                        <li class="breadcrumb-item active">Despesa</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Dados Cadastrais da Receita</h3>
                        </div>

                        <div class="card-body pb-0 pt-1 text-muted text-right">Criada
                            {{ isset($invoice->user->name) ? 'por ' . $invoice->user->name : '' }} em
                            {{ $invoice->created_at }} hs.</div>

                        <form>

                            <div class="card-body">

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="description">Descrição</label>
                                        <input type="text" class="form-control bg-white" id="description"
                                            name="description" value="{{ $invoice->description }}" disabled>
                                    </div>

                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                        <label for="category">Categoria</label>
                                        <input type="text" class="form-control bg-white" id="category" name="category"
                                            value="{{ $invoice->category }}" disabled>
                                    </div>

                                </div>

                                <div class="d-flex flex-wrap justify-content-start">

                                    <div class="col-12 col-md-3 form-group px-0 pr-md-2">
                                        <label for="value">Valor</label>
                                        <input type="text" class="form-control bg-white" id="value"name="value"
                                            value="{{ $invoice->value }}" disabled>
                                    </div>

                                    <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                        <label for="due_date">Data de Vencimento</label>
                                        <input type="text" class="form-control bg-white" id="due_date" name="due_date"
                                            value="{{ $invoice->due_date }}" disabled>
                                    </div>

                                    <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                        <label for="repetition">Repetição</label>
                                        <input type="text" class="form-control bg-white" id="repetition"
                                            name="repetition" value="{{ $invoice->repetition }}" disabled>
                                    </div>

                                    @if ($invoice->quota > 1)
                                        <div class="col-12 col-md-3 form-group px-0 pl-md-2" id="quota_field">
                                            <label for="quota">Parcelas</label>
                                            <input type="text" class="form-control bg-white" id="quota"
                                                name="repetition" value="{{ $invoice->quota }}" disabled>
                                        </div>
                                    @endif
                                </div>

                                @if ($invoice->annotation)
                                    <div class="d-flex flex-wrap justify-content-between">
                                        <div class="col-12 form-group px-0">
                                            <label for="annotation">Anotação</label>
                                            <textarea type="text" class="form-control bg-white" id="annotation" name="annotation" rows="2">{{ $invoice->annotation }}</textarea>
                                        </div>
                                    </div>
                                @endif

                                <div class="d-flex flex-wrap justify-content-start">
                                    <div class="col-12 col-md-9 form-group px-0 pr-md-2">
                                        <label for="subsidiary_id">Filial</label>
                                        <input type="text" class="form-control bg-white" id="subsidiary_id"
                                            name="subsidiary_id" value="{{ $invoice->subsidiary->alias_name }}" disabled>
                                    </div>

                                    @if ($invoice->file)
                                        <div
                                            class="col-12 col-md-3 form-group px-0 px-md-2 d-flex align-items-end pb-3 mb-0">
                                            <a class="btn btn-primary w-100" download="anexo"
                                                href="{{ Storage::url($invoice->file) }}" title="anexo"><i
                                                    class="fa fa-file-download"></i> Anexo</a>
                                        </div>
                                    @endif

                                </div>

                                <div class="d-flex flex-wrap justify-content-start">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="purchase_mode">Método de Pagamento</label>
                                        <input type="text" class="form-control bg-white" id="purchase_mode"
                                            name="purchase_mode" value="{{ $invoice->purchase_mode }}" disabled>
                                    </div>

                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                        <label for="status">Status</label>
                                        <input type="text" class="form-control bg-white" id="status" name="status"
                                            value="{{ $invoice->status }}" disabled>
                                    </div>
                                </div>

                                @if ($invoice->provider)
                                    <div class="d-flex flex-wrap justify-content-between">
                                        <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                            <label for="provider">Fornecedor</label>
                                            <input type="text" class="form-control bg-white" id="provider"
                                                name="provider" value="{{ $invoice->provider->alias_name }}" disabled>
                                        </div>
                                    </div>
                                @endif

                            </div>

                            <div class="card-footer">
                                <a href="{{ route('admin.finance-expenses.pdf', ['id' => $invoice->id]) }}"
                                    target="_blank" class="btn btn-primary"><i class="fa fa-print"></i> Imprimir</a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
