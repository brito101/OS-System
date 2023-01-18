@extends('adminlte::page')

@section('title', '- Pagamento de Passagem')

@section('adminlte_css')
    <style>
        textarea {
            overflow: auto;
        }
    </style>
@endsection

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-file-invoice-dollar"></i> Pagamento de Passagem #{{ $ticketPayment->id }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.ticket-payments.index') }}">Pagamentos de
                                Passagens</a></li>
                        <li class="breadcrumb-item active">Passagem</li>
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
                            <h3 class="card-title">Dados Cadastrais da Passagem</h3>
                        </div>

                        <div class="card-body pb-0 pt-1 text-muted text-right">Criada
                            {{ isset($ticketPayment->author) ? 'por ' . $ticketPayment->author : '' }} em
                            {{ $ticketPayment->created_at }} hs.</div>

                        <div class="card-body">

                            <div class="d-flex flex-wrap justify-content-between">
                                <div class="col-12 form-group px-0">
                                    <label for="employee">Funcionário</label>
                                    <input type="text" class="form-control bg-white" id="employee" name="employee"
                                        value="{{ $ticketPayment->employee }}" disabled>
                                </div>
                            </div>

                            <div class="d-flex flex-wrap justify-content-between">
                                <div class="col-12 col-md-3 form-group px-0 pr-md-2">
                                    <label for="total_value">Total</label>
                                    <input type="text" class="form-control money_format_2 bg-white" id="total_value"
                                        name="total_value" value="{{ $ticketPayment->total_value }}" disabled>
                                </div>

                                <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                    <label for="due_date">Vencimento</label>
                                    <input type="date" class="form-control bg-white" id="due_date" name="due_date"
                                        value="{{ $ticketPayment->due_date }}" required disabled>
                                </div>

                                <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                    <label for="status">Status</label>
                                    <input type="text" class="form-control bg-white" id="status" name="status"
                                        value="{{ $ticketPayment->status }}" disabled>
                                </div>

                                <div class="col-12 col-md-3 form-group px-0 pl-md-2">
                                    <label for="subsidiary_id">Filial</label>
                                    <input type="text" class="form-control bg-white" id="subsidiary_id"
                                        name="subsidiary_id" value="{{ $ticketPayment->subsidiary }}" disabled>
                                </div>
                            </div>

                            @if ($ticketPayment->observations)
                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 form-group px-0">
                                        <label for="observations">Observações</label>
                                        <textarea class="form-control bg-white" id="observations" name="observations" disabled>{{ $ticketPayment->observations }}</textarea>
                                    </div>
                                </div>
                            @endif

                        </div>

                        <div class="card-footer">
                            <a href="{{ route('admin.ticket-payments.pdf', ['id' => $ticketPayment->id]) }}"
                                target="_blank" class="btn btn-primary"><i class="fa fa-print"></i> Imprimir</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('custom_js')
    <script src="{{ asset('vendor/jquery/jquery.inputmask.bundle.min.js') }}"></script>
    <script src="{{ asset('js/money.js') }}"></script>
@endsection
