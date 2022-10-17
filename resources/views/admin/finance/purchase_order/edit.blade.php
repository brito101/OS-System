@extends('adminlte::page')
@section('plugins.select2', true)
@section('plugins.BsCustomFileInput', true)

@section('title', '- Edição de Ordem de Compra')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-cart-plus"></i> Editar Ordem de Compra</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.finance-purchase-orders.index') }}">Ordens de
                                Compra</a></li>
                        <li class="breadcrumb-item active">Editar Ordem de Compra</li>
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

                        <form method="POST"
                            action="{{ route('admin.finance-purchase-orders.update', ['finance_purchase_order' => $purchase->id]) }}"
                            enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <input type="hidden" value="{{ $purchase->id }}" name="id">
                            <div class="card-body">

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-3 form-group px-0 pr-md-2">
                                        <label for="date">Data</label>
                                        <input type="text" class="form-control date" id="date"
                                            placeholder="dd/mm/yyyy" name="date"
                                            value="{{ old('date') ?? $purchase->date }}" required>
                                    </div>

                                    <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                        <label for="amount">Quantidade</label>
                                        <input type="number" class="form-control" id="amount"
                                            placeholder="Quantidade de itens" name="amount"
                                            value="{{ old('amount') ?? (int) $purchase->amount }}" required>
                                    </div>

                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                        <label for="job">Obra</label>
                                        <input type="text" class="form-control" id="job"
                                            placeholder="Descrição da obra" name="job"
                                            value="{{ old('job') ?? $purchase->job }}" required>
                                    </div>

                                </div>

                                <div class="d-flex flex-wrap justify-content-start">

                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2 mb-0">
                                        <label for="provider_id">Fornecedor</label>
                                        <x-adminlte-select2 name="provider_id">
                                            @foreach ($providers as $provider)
                                                <option
                                                    {{ old('provider_id') == $provider->id ? 'selected' : ($purchase->provider_id == $provider->id ? 'selected' : '') }}
                                                    value="{{ $provider->id }}">{{ $provider->alias_name }}
                                                </option>
                                            @endforeach
                                        </x-adminlte-select2>
                                    </div>

                                    <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                        <label for="value">Valor</label>
                                        <input type="text" class="form-control money_format_2" id="value"
                                            placeholder="Valor em reais" name="value"
                                            value="{{ old('value') ?? $purchase->value }}" required>
                                    </div>

                                    <div class="col-12 col-md-3 form-group px-0 pl-md-2">
                                        <label for="invoice">Nota Fiscal</label>
                                        <input type="text" class="form-control" id="invoice"
                                            placeholder="Dados da nota fiscal" name="invoice"
                                            value="{{ old('invoice') ?? $purchase->invoice }}" required>
                                    </div>

                                </div>

                                @if ($materials->count() > 0)
                                    <div class="d-flex flex-wrap justify-content-start" id="material"
                                        data-material-qtd="{{ $materials->count() - 1 }}">
                                        @foreach ($materials as $material)
                                            <div class="col-12 form-group px-0"
                                                id="container_material_{{ $loop->index }}">
                                                <label for="material_{{ $loop->index }}">Material</label>
                                                <input type="text" class="form-control"
                                                    id="material_{{ $loop->index }}" placeholder="Descrição do Material"
                                                    name="material_{{ $loop->index }}"
                                                    value="{{ old('material_' . $loop->index) ?? $material->description }}"
                                                    maxlength="191">
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="d-flex flex-wrap justify-content-start" id="material"
                                        data-material-qtd="0">
                                        <div class="col-12 form-group px-0" id="container_material_0">
                                            <label for="material_0">Material</label>
                                            <input type="text" class="form-control" id="material_0"
                                                placeholder="Descrição do Material" name="material_0"
                                                value="{{ old('material_0') }}" maxlength="191">
                                        </div>
                                    </div>
                                @endif

                                <div class="d-flex flex-wrap justify-content-start">
                                    <div class="col-12 col-md-2 form-group px-0 pr-md-2">
                                        <button class="btn btn-info w-100" data-material="open"><i
                                                class="fa fa-plus"></i>
                                            Material</button>
                                    </div>

                                    <div class="col-12 col-md-2 form-group px-0 pl-md-2">
                                        <button class="btn btn-danger w-100" data-material="close"><i
                                                class="fa fa-minus"></i>
                                            Material</button>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-start">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="requester">Solicitante</label>
                                        <input type="text" class="form-control" id="requester"
                                            placeholder="Solicitante" name="requester"
                                            value="{{ old('requester') ?? $purchase->requester }}" required>
                                    </div>

                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                        <label for="authorized">Autorizado por:</label>
                                        <input type="text" class="form-control" id="authorized"
                                            placeholder="Quem autorizou a ordem de compra" name="authorized"
                                            value="{{ old('authorized') ?? $purchase->authorized }}" required>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-3 form-group px-0 pr-md-2">
                                        <label for="authorized_date">Data de Autorização</label>
                                        <input type="text" class="form-control date" id="authorized_date"
                                            placeholder="dd/mm/yyyy" name="authorized_date"
                                            value="{{ old('authorized_date') ?? $purchase->authorized_date }}" required>
                                    </div>

                                    <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                        <label for="forecast">Previsão de Entrega</label>
                                        <input type="text" class="form-control date" id="forecast"
                                            placeholder="dd/mm/yyyy" name="forecast"
                                            value="{{ old('forecast') ?? $purchase->forecast }}" required>
                                    </div>

                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                        <label for="freight">Frete</label>
                                        <input type="text" class="form-control" id="freight"
                                            placeholder="Dados de frete" name="freight"
                                            value="{{ old('freight') ?? $purchase->freight }}">
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2 mb-0">
                                        <label for="subsidiary_id">Filial</label>
                                        <x-adminlte-select2 name="subsidiary_id">
                                            @foreach ($subsidiaries as $subsidiary)
                                                <option
                                                    {{ old('subsidiary_id') == $subsidiary->id ? 'selected' : ($purchase->subsidiary_id == $subsidiary->id ? 'selected' : '') }}
                                                    value="{{ $subsidiary->id }}">{{ $subsidiary->alias_name }}
                                                </option>
                                            @endforeach
                                        </x-adminlte-select2>
                                    </div>

                                    @if ($purchase->file)
                                        <div
                                            class="col-12 col-md-2 form-group px-0 px-md-2 mb-0 d-flex align-items-end pb-3">
                                            <a class="btn btn-primary w-100" download="anexo"
                                                href="{{ Storage::url($purchase->file) }}" title="anexo"><i
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
                                        class="col-12 {{ $purchase->file ? 'col-md-3' : 'col-md-6' }} form-group px-0 pl-md-2 mb-0">
                                        <x-adminlte-input-file name="file"
                                            label="{{ $purchase->file ? 'Atualizar ' : '' }}Anexo"
                                            placeholder="Selecione um arquivo..." />
                                    </div>

                                </div>

                                <div class="d-flex flex-wrap justify-content-start">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="purchase_mode">Forma de Pagamento</label>
                                        <input type="text" class="form-control" id="purchase_mode"
                                            placeholder="Modalidade de Pagamento" name="purchase_mode"
                                            value="{{ old('purchase_mode') ?? $purchase->purchase_mode }}" required>
                                    </div>

                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2 mb-0">
                                        <label for="status">Status</label>
                                        <x-adminlte-select2 name="status">
                                            <option
                                                {{ old('status') == 'executada' ? 'selected' : ($purchase->status == 'executada' ? 'selected' : '') }}
                                                value="executada">
                                                Executada
                                            </option>
                                            <option
                                                {{ old('status') == 'não executada' ? 'selected' : ($purchase->status == 'não executada' ? 'selected' : '') }}
                                                value="não executada">
                                                Não Executada
                                            </option>
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
    <script src="{{ asset('js/material.js') }}"></script>
@endsection