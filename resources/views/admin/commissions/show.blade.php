@extends('adminlte::page')

@section('title', '- Comissão')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-coins"></i> Comissão #{{ $commission->id }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.commissions.index') }}">Comissões</a></li>
                        <li class="breadcrumb-item active">Comissão</li>
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
                            <h3 class="card-title">Dados Cadastrais da Comissão</h3>
                        </div>

                        <div class="card-body pb-0 pt-1 text-muted text-right">Criada
                            {{ isset($commission->author) ? 'por ' . $commission->author : '' }} em
                            {{ $commission->created_at }} hs.</div>

                        <form>
                            <div class="card-body">

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="seller_id">Vendedor</label>
                                        <input type="text" class="form-control bg-white" id="seller_id" name="seller_id"
                                            value="{{ $commission->seller }}" disabled>
                                    </div>
                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                        <label for="product">Produto</label>
                                        <input type="text" class="form-control bg-white" id="product"name="product"
                                            value="{{ $commission->product }}" disabled>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 form-group px-0">
                                        <label for="job">Obra</label>
                                        <input type="text" class="form-control bg-white" id="job" name="job"
                                            value="{{ $commission->job }}" disabled>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-4 form-group px-0 pr-md-2">
                                        <label for="job_value">Valor da Obra</label>
                                        <input type="text" class="form-control bg-white" id="job_value" name="job_value"
                                            value="{{ $commission->job_value }}" disabled>
                                    </div>
                                    <div class="col-12 col-md-4 form-group px-0 px-md-2">
                                        <label for="percentage">Percentual de Comissão</label>
                                        <input type="text" class="form-control bg-white" id="percentage"
                                            name="totpercentageal_value" value="{{ $commission->percentage }}" disabled>
                                    </div>
                                    <div class="col-12 col-md-4 form-group px-0 pl-md-2">
                                        <label for="total_value">Total</label>
                                        <input type="text" class="form-control bg-white" id="total_value"
                                            name="total_value" value="{{ $commission->total_value }}" disabled>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-4 form-group px-0 pr-md-2">
                                        <label for="due_date">Vencimento</label>
                                        <input type="text" class="form-control bg-white" id="due_date" name="due_date"
                                            value="{{ $commission->due_date }}" disabled>
                                    </div>

                                    <div class="col-12 col-md-4 form-group px-0 px-md-2">
                                        <label for="status">Status</label>
                                        <input type="text" class="form-control bg-white" id="status" name="status"
                                            value="{{ $commission->status }}" disabled>
                                    </div>

                                    <div class="col-12 col-md-4 form-group px-0 pl-md-2">
                                        <label for="subsidiary_id">Filial</label>
                                        <input type="text" class="form-control bg-white" id="subsidiary_id"
                                            name="subsidiary_id" value="{{ $commission->subsidiary }}" disabled>
                                    </div>
                                </div>

                            </div>

                            <div class="card-footer">
                                <a href="{{ route('admin.commissions.pdf', ['id' => $commission->id]) }}" target="_blank"
                                    class="btn btn-primary"><i class="fa fa-print"></i> Imprimir</a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
