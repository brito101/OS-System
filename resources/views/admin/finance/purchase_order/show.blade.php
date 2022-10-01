@extends('adminlte::page')
@section('plugins.select2', true)
@section('plugins.BsCustomFileInput', true)

@section('title', '- Ordem de Compra')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-cart-plus"></i> Ordem de Compra #{{ $purchase->id }} - Nº
                        Série {{ $purchase->number_series }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.finance-purchase-orders.index') }}">Ordens de
                                Compra</a></li>
                        <li class="breadcrumb-item active">Ordem de Compra</li>
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
                            <h3 class="card-title">Dados Cadastrais da Ordem de Compra</h3>
                        </div>

                        <div class="card-body pb-0 pt-1 text-muted text-right">Criada
                            {{ isset($purchase->user->name) ? 'por ' . $purchase->user->name : '' }} em
                            {{ $purchase->created_at }} hs.</div>

                        <form>

                            <div class="card-body">

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-3 form-group px-0 pr-md-2">
                                        <label for="date">Data</label>
                                        <input type="text" class="form-control bg-white" id="date" name="date"
                                            value="{{ $purchase->date }}" disabled>
                                    </div>

                                    <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                        <label for="amount">Quantidade</label>
                                        <input type="text" class="form-control bg-white" id="amount" name="amount"
                                            value="{{ (int) $purchase->amount }}" disabled>
                                    </div>

                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                        <label for="job">Obra</label>
                                        <input type="text" class="form-control bg-white" id="job" name="job"
                                            value="{{ $purchase->job }}" disabled>
                                    </div>

                                </div>

                                <div class="d-flex flex-wrap justify-content-start">

                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="provider_id">Fornecedor</label>
                                        <input type="text" class="form-control bg-white" id="provider_id"
                                            name="provider_id" value="{{ $purchase->provider->alias_name }}" disabled>
                                    </div>

                                    <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                        <label for="value">Valor</label>
                                        <input type="text" class="form-control bg-white" id="value" name="value"
                                            value="{{ $purchase->value }}" disabled>
                                    </div>

                                    <div class="col-12 col-md-3 form-group px-0 pl-md-2">
                                        <label for="invoice">Nota Fiscal</label>
                                        <input type="text" class="form-control bg-white" id="invoice" name="invoice"
                                            value="{{ $purchase->invoice }}" disabled>
                                    </div>

                                </div>

                                <div class="d-flex flex-wrap justify-content-start" id="material">
                                    @foreach ($materials as $material)
                                        <div class="col-12 form-group px-0">
                                            <label for="material_{{ $loop->index }}">Material {{ $loop->index + 1 }}
                                            </label>
                                            <input type="text" class="form-control bg-white"
                                                id="material_{{ $loop->index }}" name="material_{{ $loop->index }}"
                                                value="{{ $material->description }}" disabled>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="d-flex flex-wrap justify-content-start">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="requester">Solicitante</label>
                                        <input type="text" class="form-control bg-white" id="requester" name="requester"
                                            value="{{ $purchase->requester }}" disabled>
                                    </div>

                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                        <label for="authorized">Autorizado por:</label>
                                        <input type="text" class="form-control bg-white" id="authorized"
                                            name="authorized" value="{{ $purchase->authorized }}" disabled>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-3 form-group px-0 pr-md-2">
                                        <label for="authorized_date">Data de Autorização</label>
                                        <input type="text" class="form-control bg-white" id="authorized_date"
                                            name="authorized_date" value="{{ $purchase->authorized_date }}" disabled>
                                    </div>

                                    <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                        <label for="forecast">Previsão de Entrega</label>
                                        <input type="text" class="form-control bg-white" id="forecast"
                                            name="forecast" value="{{ $purchase->forecast }}" disabled>
                                    </div>

                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                        <label for="freight">Frete</label>
                                        <input type="text" class="form-control bg-white" id="freight"
                                            name="freight" value="{{ $purchase->freight }}" disabled>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-9 form-group px-0 pr-md-2">
                                        <label for="subsidiary_id">Filial</label>
                                        <input type="text" class="form-control bg-white" id="subsidiary_id"
                                            name="subsidiary_id" value="{{ $purchase->subsidiary }}" disabled>
                                    </div>

                                    @if ($purchase->file)
                                        <div
                                            class="col-12 col-md-3 form-group px-0 px-md-2 d-flex align-items-end pb-3 mb-0">
                                            <a class="btn btn-primary w-100" download="anexo"
                                                href="{{ Storage::url($purchase->file) }}" title="anexo"><i
                                                    class="fa fa-file-download"></i> Anexo</a>
                                        </div>
                                    @endif

                                </div>

                                <div class="d-flex flex-wrap justify-content-start">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="purchase_mode">Forma de Pagamento</label>
                                        <input type="text" class="form-control bg-white" id="purchase_mode"
                                            name="purchase_mode" value="{{ $purchase->purchase_mode }}" disabled>
                                    </div>

                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                        <label for="status">Status</label>
                                        <input type="text" class="form-control bg-white" id="status"
                                            name="status" value="{{ $purchase->status }}" disabled>
                                    </div>
                                </div>

                            </div>

                            <div class="card-footer">
                                <a href="{{ route('admin.finance-purchase-orders.pdf', ['id' => $purchase->id]) }}"
                                    target="_blank" class="btn btn-primary"><i class="fa fa-print"></i> Imprimir</a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
