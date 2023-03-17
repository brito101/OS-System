@extends('adminlte::page')
@section('plugins.select2', true)

@section('title', '- Cadastro Orçamento de Obra')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-comments-dollar"></i> Novo Orçamento de Obra</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.construction-budget.index') }}">Orçamentos de
                                Obra</a></li>
                        <li class="breadcrumb-item active">Novo Orçamento de Obra</li>
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
                            <h3 class="card-title">Dados Cadastrais do Orçamento de Obra</h3>
                        </div>

                        <form method="POST" action="{{ route('admin.construction-budget.store') }}">
                            @csrf
                            <div class="card-body">

                                @foreach ($items as $item)
                                    <div class="d-flex flex-wrap justify-content-start border-bottom border-1">
                                        <div
                                            class="col-12 col-md-3 form-group px-0 pr-md-2 d-flex flex-wrap align-content-center align-items-center">
                                            <h5 class="h6 mt-4 col-12">{{ $item->id }} - {{ $item->description }}
                                            </h5>
                                            <small class="col-12 text-muted">Código de Mão de Obra:
                                                {{ $item->code }}</small>
                                        </div>
                                        <div class="col-12 col-md-1 form-group px-0 px-md-2">
                                            <label for="{{ 'item_' . $item->id . '_qtd' }}">Quantidade</label>
                                            <input type="text" class="form-control decimal item_qtd"
                                                id="{{ 'item_' . $item->id . '_qtd' }}" placeholder="{{ $item->unity }}"
                                                name="{{ 'item_' . $item->id . '_qtd' }}"
                                                value="{{ old('item_' . $item->id . '_qtd') }}"
                                                data-value="{{ $item->value }}"
                                                data-next="{{ 'item_' . $item->id . '_total_tax' }}">
                                        </div>

                                        <input type="hidden" name="{{ 'item_' . $item->id . '_tax' }}"
                                            value="{{ $item->tax }}" disabled>

                                        <div class="col-12 col-md-2 form-group px-0 px-md-2">
                                            <label for="{{ 'item_' . $item->id . '_total_tax' }}">Valor Total sem Impostos
                                                <span class="badge badge-info ml-2" style="cursor: pointer"
                                                    title="Valor unitário: {{ $item->value_pt }}"><i
                                                        class="fa fa-dollar-sign"></i></span></label>
                                            <input type="text" class="form-control money_format_2"
                                                id="{{ 'item_' . $item->id . '_total_tax' }}"
                                                name="{{ 'item_' . $item->id . '_total_tax' }}"
                                                value="{{ old('item_' . $item->id . '_total_tax') }}">
                                        </div>
                                    </div>
                                @endforeach

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

    <script>
        $(".item_qtd").on("change", function(e) {
            let value = $(e.currentTarget).data('value');
            let next = $(e.currentTarget).data('next');
            let total = e.currentTarget.value * value;
            $(`#${next}`).val(total);
        });
    </script>
@endsection
