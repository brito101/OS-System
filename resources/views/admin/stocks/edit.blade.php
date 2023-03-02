@extends('adminlte::page')
@section('plugins.select2', true)

@section('title', '- Edição de Movimentação')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-box-open"></i> Editar Movimentação</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.stocks.index') }}">Movimentação</a></li>
                        <li class="breadcrumb-item active">Editar Movimentação</li>
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

                        <form method="POST" action="{{ route('admin.stocks.update', ['stock' => $stock->id]) }}">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="id" value="{{ $stock->id }}">

                            <div class="card-body">

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-5 form-group px-0 pr-md-2">
                                        <label for="product_id">Produto</label>
                                        <x-adminlte-select2 name="product_id">
                                            @foreach ($products as $product)
                                                <option
                                                    {{ old('product_id') == $product->id ? 'selected' : ($stock->product_id == $product->id ? 'selected' : '') }}
                                                    value="{{ $product->id }}">{{ $product->name }}
                                                </option>
                                            @endforeach
                                        </x-adminlte-select2>
                                    </div>

                                    <div class="col-12 col-md-4 form-group px-0 px-md-2">
                                        <label for="provider_id">Fornecedor</label>
                                        <x-adminlte-select2 name="provider_id">

                                            @foreach ($providers as $provider)
                                                <option
                                                    {{ old('provider_id') == $provider->id ? 'selected' : ($stock->provider_id == $provider->id ? 'selected' : '') }}
                                                    value="{{ $provider->id }}">{{ $provider->alias_name }}
                                                </option>
                                            @endforeach
                                        </x-adminlte-select2>
                                    </div>

                                    <div class="col-12 col-md-3 form-group px-0 pl-md-2">
                                        <label for="day">Dia</label>
                                        <input type="text" class="form-control date" id="day"
                                            placeholder="dd/mm/yyyy" name="day" value="{{ old('day') ?? $stock->day }}"
                                            required>
                                    </div>

                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-5 form-group px-0 pr-md-2">
                                        <label for="subsidiary_id">Filial</label>
                                        <x-adminlte-select2 name="subsidiary_id">
                                            <option
                                                {{ old('subsidiary_id') == null ? 'selected' : ($stock->subsidiary_id == null ? 'selected' : '') }}
                                                value="">
                                                Global</option>
                                            @foreach ($subsidiaries as $subsidiary)
                                                <option
                                                    {{ old('subsidiary_id') == $subsidiary->id ? 'selected' : ($stock->subsidiary_id == $subsidiary->id ? 'selected' : '') }}
                                                    value="{{ $subsidiary->id }}">{{ $subsidiary->alias_name }}
                                                </option>
                                            @endforeach
                                        </x-adminlte-select2>
                                    </div>

                                    <div class="col-12 col-md-7 form-group px-0 pl-md-2">
                                        <label for="job">Obra</label>
                                        <input type="text" class="form-control" name="job" id="job"
                                            value="{{ old('job') ?? $stock->job }}">
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-4 form-group px-0 pr-md-2">
                                        <label for="liberator">Liberado por</label>
                                        <input type="text" class="form-control" name="liberator" id="liberator"
                                            value="{{ old('liberator') ?? $stock->liberator }}">
                                    </div>

                                    <div class="col-12 col-md-4 form-group px-0 px-md-2">
                                        <label for="stripper">Retirado por</label>
                                        <input type="text" class="form-control" name="stripper" id="stripper"
                                            value="{{ old('stripper') ?? $stock->stripper }}">
                                    </div>

                                    <div class="col-12 col-md-4 form-group px-0 pl-md-2">
                                        <label for="lecturer">Conferente</label>
                                        <input type="text" class="form-control" name="lecturer" id="lecturer"
                                            value="{{ old('lecturer') ?? $stock->lecturer }}">
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-3 form-group px-0 pr-md-2">
                                        <label for="value">Valor</label>
                                        <input type="text" class="form-control money_format_2" id="value"
                                            placeholder="Valor em reais" name="value"
                                            value="{{ old('value') ?? $stock->value }}" required>
                                    </div>

                                    <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                        <label for="validity">Validade do Produto</label>
                                        <input type="text" class="form-control date" id="validity"
                                            placeholder="data ou nulo" name="validity"
                                            value="{{ old('validity') ?? $stock->validity }}">
                                    </div>

                                    <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                        <label for="input">Entrada</label>
                                        <input type="number" step="1" class="form-control" id="input"
                                            name="input" value="{{ old('input') ?? $stock->input }}">
                                    </div>
                                    <div class="col-12 col-md-3 form-group px-0 pl-md-2">
                                        <label for="output">Saída</label>
                                        <input type="number" step="1" class="form-control" id="output"
                                            name="output" value="{{ old('output') ?? $stock->output }}">
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 form-group px-0">
                                        <label for="observations">Observações</label>
                                        <textarea name="observations" rows="2" class="form-control" id="observations">{{ old('observations') ?? $stock->observations }}</textarea>
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

                                <div class="d-flex flex-wrap justify-content-between">
                                    <label for="cover_base64">Capturar Foto</label>
                                    <input type="hidden" id="cover_base64" name="cover_base64" />
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div
                                        class="embed-responsive embed-responsive-16by9 col-12 col-md-6 form-group px-0 pr-md-2">
                                        <video id="player" autoplay class="embed-responsive-item"></video>
                                    </div>

                                    <div
                                        class="embed-responsive embed-responsive-16by9 col-12 col-md-6 form-group px-0 pl-md-2">
                                        <canvas id="canvas" class="embed-responsive-item"
                                            style="max-width: 75%; left: 12.5%;"></canvas>
                                    </div>
                                    <button id="capture" class="btn btn-secondary"><i class="fa fa-camera mr-1"></i>
                                        Capturar</button>
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
    <script src="{{ asset('js/capture.js') }}"></script>
@endsection
