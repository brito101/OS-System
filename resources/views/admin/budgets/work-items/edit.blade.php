@extends('adminlte::page')
@section('plugins.select2', true)

@section('title', '- Edição de Item de Obra')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-list-ol"></i> Editar Item de Obra</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Orçamentos</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.work-items.index') }}">Itens de Obra</a></li>
                        <li class="breadcrumb-item active">Editar Item de Obra</li>
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
                            <h3 class="card-title">Dados Cadastrais do Item de Obra</h3>
                        </div>

                        <form method="POST"
                            action="{{ route('admin.work-items.update', ['work_item' => $workItem->id]) }}">
                            @method('PUT')
                            <input type="hidden" name="id" value="{{ $workItem->id }}">
                            @csrf
                            <div class="card-body">

                                <div class="d-flex flex-wrap justify-content-start">
                                    <div class="col-12 col-md-2 form-group px-0 pr-md-2">
                                        <label for="code">Código de Mão de Obra</label>
                                        <input type="text" class="form-control" id="code"
                                            placeholder="Código de Mão de Obra" name="code"
                                            value="{{ old('code') ?? $workItem->code }}" required>
                                    </div>

                                    <div class="col-12 col-md-6 form-group px-0 px-md-2">
                                        <label for="description">Descrição</label>
                                        <input type="text" class="form-control" id="description"
                                            placeholder="Texto descritivo" name="description"
                                            value="{{ old('description') ?? $workItem->description }}" required>
                                    </div>

                                    <div class="col-12 col-md-2 form-group px-0 pr-md-2 mb-0">
                                        <label for="unity">Unidade</label>
                                        <x-adminlte-select2 name="unity">
                                            <option
                                                {{ old('unity') == 'UN' ? 'selected' : ($workItem->unity == 'UN' ? 'selected' : '') }}
                                                value="UN">
                                                UN
                                            </option>
                                            <option
                                                {{ old('unity') == 'Metro Linear' ? 'selected' : ($workItem->unity == 'Metro Linear' ? 'selected' : '') }}
                                                value="Metro Linear">
                                                Metro Linear
                                            </option>
                                            <option
                                                {{ old('unity') == 'KM' ? 'selected' : ($workItem->unity == 'KM' ? 'selected' : '') }}
                                                value="KM">
                                                KM
                                            </option>
                                        </x-adminlte-select2>
                                    </div>

                                    <div class="col-12 col-md-2 form-group px-0 pl-md-2">
                                        <label for="value">Valor</label>
                                        <input type="text" class="form-control money_format_2" id="value"
                                            name="value" value="{{ old('value') ?? $workItem->value_pt }}" required>
                                    </div>

                                </div>

                                <div class="d-flex flex-wrap justify-content-start">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2 mb-0">
                                        <label for="category">Categoria</label>
                                        <x-adminlte-select2 name="category">
                                            <option
                                                {{ old('category') == 'Água' ? 'selected' : ($workItem->category == 'Água' ? 'selected' : '') }}
                                                value="Água">
                                                Água
                                            </option>
                                            <option
                                                {{ old('category') == 'Gás' ? 'selected' : ($workItem->category == 'Gás' ? 'selected' : '') }}
                                                value="Gás">
                                                Gás
                                            </option>
                                            <option
                                                {{ old('category') == 'Geral' ? 'selected' : ($workItem->category == 'Geral' ? 'selected' : '') }}
                                                value="Geral">
                                                Geral
                                            </option>
                                            <option
                                                {{ old('category') == 'Hidrômetro' ? 'selected' : ($workItem->category == 'Hidrômetro' ? 'selected' : '') }}
                                                value="Hidrômetro">
                                                Hidrômetro
                                            </option>
                                            <option
                                                {{ old('category') == 'Sistema' ? 'selected' : ($workItem->category == 'Sistema' ? 'selected' : '') }}
                                                value="Sistema">
                                                Sistema
                                            </option>
                                        </x-adminlte-select2>
                                    </div>

                                    <div class="col-12 col-md-2 form-group px-0 px-md-2">
                                        <label for="tax">Imposto</label>
                                        <input type="text" class="form-control percentage" id="tax"
                                            placeholder="Valor em porcentagem" name="tax"
                                            value="{{ old('tax') ?? $workItem->tax_pt }}" required>
                                    </div>

                                    <div class="col-12 col-md-2 form-group px-0 px-md-2">
                                        <label for="commercial">Taxa Comercial</label>
                                        <input type="text" class="form-control decimal" id="commercial" name="commercial"
                                            value="{{ old('commercial') ?? $workItem->commercial_pt }}" required>
                                    </div>

                                    <div class="col-12 col-md-2 form-group px-0 px-md-2">
                                        <label for="fee">Taxa ADM</label>
                                        <input type="text" class="form-control decimal" id="fee" name="fee"
                                            value="{{ old('fee') ?? $workItem->fee_pt }}" required>
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
    <script>
        $(".decimal").inputmask({
            alias: "decimal",
            radixPoint: ",",
            groupSeparator: ".",
            postfix: "",
            integerDigits: 9,
            digits: 2,
            allowMinus: false,
            digitsOptional: true,
            placeholder: "0"
        });
    </script>
@endsection
