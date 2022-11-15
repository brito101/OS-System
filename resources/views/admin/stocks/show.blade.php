@extends('adminlte::page')
@section('plugins.select2', true)

@section('title', '- Movimentação')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-box-open"></i> Movimentação #{{ $stock->id }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.stocks.index') }}">Movimentação</a></li>
                        <li class="breadcrumb-item active">Movimentação</li>
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
                            <h3 class="card-title">Dados Cadastrais da Movimentação</h3>
                        </div>

                        <div class="card-body pb-0 pt-1 text-muted text-right">Criada
                            {{ isset($stock->user->name) ? 'por ' . $stock->user->name : '' }} em
                            {{ $stock->created_at }} hs.</div>

                        <form>
                            <div class="card-body">

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-5 form-group px-0 pr-md-2">
                                        <label for="product_id">Produto</label>
                                        <input type="text" class="form-control bg-white" id="product_id"
                                            name="product_id" value="{{ $stock->product }}" disabled>
                                    </div>

                                    <div class="col-12 col-md-4 form-group px-0 px-md-2">
                                        <label for="provider_id">Fornecedor</label>
                                        <input type="text" class="form-control bg-white" id="provider_id"
                                            name="provider_id" value="{{ $stock->provider->alias_name ?? null }}" disabled>
                                    </div>

                                    <div class="col-12 col-md-3 form-group px-0 pl-md-2">
                                        <label for="day">Dia</label>
                                        <input type="text" class="form-control bg-white" id="day" name="day"
                                            value="{{ $stock->day }}" disabled>
                                    </div>

                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-5 form-group px-0 pr-md-2">
                                        <label for="subsidiary_id">Filial</label>
                                        <input type="text" class="form-control bg-white" id="subsidiary_id"
                                            name="subsidiary_id" value="{{ $stock->subsidiary }}" disabled>
                                    </div>

                                    <div class="col-12 col-md-7 form-group px-0 pl-md-2">
                                        <label for="job">Obra</label>
                                        <input type="text" class="form-control bg-white" id="job" name="job"
                                            value="{{ $stock->job }}" disabled>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-4 form-group px-0 pr-md-2">
                                        <label for="liberator">Liberado por</label>
                                        <input type="text" class="form-control bg-white" id="liberator" name="liberator"
                                            value="{{ $stock->liberator }}" disabled>
                                    </div>

                                    <div class="col-12 col-md-4 form-group px-0 px-md-2">
                                        <label for="stripper">Retirado por</label>
                                        <input type="text" class="form-control bg-white" id="stripper" name="stripper"
                                            value="{{ $stock->stripper }}" disabled>
                                    </div>

                                    <div class="col-12 col-md-4 form-group px-0 pl-md-2">
                                        <label for="lecturer">Conferente</label>
                                        <input type="text" class="form-control bg-white" id="lecturer" name="lecturer"
                                            value="{{ $stock->lecturer }}" disabled>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-3 form-group px-0 pr-md-2">
                                        <label for="value">Valor</label>
                                        <input type="text" class="form-control bg-white" id="value" name="value"
                                            value="{{ $stock->value }}" disabled>
                                    </div>

                                    <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                        <label for="validity">Validade do Produto</label>
                                        <input type="text" class="form-control bg-white" id="validity" name="validity"
                                            value="{{ $stock->validity }}" disabled>
                                    </div>

                                    <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                        <label for="input">Entrada</label>
                                        <input type="text" class="form-control bg-white" id="input" name="input"
                                            value="{{ $stock->input }}" disabled>
                                    </div>
                                    <div class="col-12 col-md-3 form-group px-0 pl-md-2">
                                        <label for="output">Saída</label>
                                        <input type="text" class="form-control bg-white" id="output"
                                            name="output" value="{{ $stock->output }}" disabled>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 form-group px-0">
                                        <label for="observations">Observações</label>
                                        <textarea name="observations" class="form-control bg-white" id="observations" disabled>{{ $stock->observations }}</textarea>
                                    </div>
                                </div>

                                @if ($stock->photo != null)
                                    <div class="d-flex flex-wrap justify-content-center">
                                        <div
                                            class="embed-responsive embed-responsive-16by9 col-12 col-md-6 form-group px-0">
                                            <img src="{{ url('storage/inventories/' . $stock->photo) }}"
                                                alt="Imagem capturada"
                                                class="embed-responsive-item shadow-sm border border-1 border-primary rounded"
                                                style="max-width: 75%; left: 12.5%;"></canvas>
                                        </div>
                                    </div>
                                @endif

                            </div>

                            <div class="card-footer">
                                <a href="{{ route('admin.stocks.pdf', ['id' => $stock->id]) }}" target="_blank"
                                    class="btn btn-primary"><i class="fa fa-print"></i> Imprimir</a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
