@extends('adminlte::page')

@section('title', '- Cadastro de Produto')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-box"></i> Novo Produto</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Produtos</a></li>
                        <li class="breadcrumb-item active">Novo Produto</li>
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
                            <h3 class="card-title">Dados Cadastrais do Produto</h3>
                        </div>

                        <form method="POST" action="{{ route('admin.products.store') }}">
                            @csrf
                            <div class="card-body">

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 form-group px-0">
                                        <label for="name">Nome</label>
                                        <input type="text" class="form-control" id="name"
                                            placeholder="Nome do Produto" name="name" value="{{ old('name') }}"
                                            required>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 form-group px-0">
                                        <label for="description">Descrição do Produto</label>
                                        <textarea name="description" rows="2" class="form-control" id="description">{{ old('description') }}</textarea>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="min_stock">Estoque Mínimo</label>
                                        <input type="number" step="1" class="form-control" id="min_stock"
                                            name="min_stock" value="{{ old('min_stock') }}">
                                    </div>
                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                        <label for="max_stock">Estoque Máximo</label>
                                        <input type="number" step="1" class="form-control" id="max_stock"
                                            name="max_stock" value="{{ old('max_stock') }}">
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
