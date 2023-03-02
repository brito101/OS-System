@extends('adminlte::page')

@section('title', '- Estoque Consolidado')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-chart-area"></i> Estoque Consolidado</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Estoque Consolidado</li>
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
                            <div class="d-flex flex-wrap justify-content-between col-12 align-content-center">
                                <div class="col-12 col-sm-9 align-content-center d-flex">
                                    <h3 class="card-title align-self-center">Estoque Consolidado - {{ $year }}</h3>
                                </div>
                                <form method="POST" action="{{ route('admin.stocks.consolidated') }}"
                                    class="col-12 col-sm-3 mt-2 md-sm-0 d-flex justify-content-center">
                                    @csrf
                                    <input type="number" min="1900" max="{{ date('Y') }}" step="1"
                                        value="{{ old('year') ?? $year }}" name="year" class="form-control" />
                                    <button type="submit" class="btn btn-primary ml-2"><i
                                            class="fa fa-search"></i></button>
                                </form>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive-lg">
                                <table class="table table-bordered table-hover table-striped">
                                    <thead class="table-light">
                                        <tr>
                                            <th scope="col">Produto</th>
                                            <th scope="col">Jan</th>
                                            <th scope="col">Fev</th>
                                            <th scope="col">Mar</th>
                                            <th scope="col">Abr</th>
                                            <th scope="col">Mai</th>
                                            <th scope="col">Jun</th>
                                            <th scope="col">Jul</th>
                                            <th scope="col">Ago</th>
                                            <th scope="col">Set</th>
                                            <th scope="col">Out</th>
                                            <th scope="col">Nov</th>
                                            <th scope="col">Dez</th>
                                        </tr>

                                    </thead>
                                    <tbody>
                                        @foreach ($stocks as $product)
                                            <tr>
                                                <th scope="row">{{ $product['product'] }}</th>
                                                @foreach ($product['months'] as $month)
                                                    <td>{{ $month }}</td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
