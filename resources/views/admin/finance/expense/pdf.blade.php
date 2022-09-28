@extends('adminlte::page')
@section('adminlte_css')
    <style>
        @page {
            margin: 2cm;
        }
    </style>
@endsection

@section('title', '- Despesa')

@section('content')

    <div class="card">
        <div class="d-flex flex-wrap justify-content-center">
            <img src="{{ asset('img/logo.png') }}" class="col-2" style="width: 100px">
            <h2 class="text-center col-9 d-flex align-items-center ml-5 mt-3 display-5 font-weight-bold">Receita
                #{{ $invoice->id }}
            </h2>
        </div>

        <div class="card-header">
            <h3 class="card-title">Dados Cadastrais da Despesa</h3>
        </div>

        <div class="card-body pb-0 pt-1 text-muted text-right">Criada
            {{ isset($invoice->user->name) ? 'por ' . $invoice->user->name : '' }} em
            {{ $invoice->created_at }} hs.</div>

        <form>

            <div class="card-body">

                <div class="d-flex flex-wrap justify-content-between">
                    <div class="col-6 form-group pr-2">
                        <label for="description">Descrição</label>
                        <input type="text" class="form-control bg-white" id="description" name="description"
                            value="{{ $invoice->description }}" disabled>
                    </div>

                    <div class="col-6 form-group pl-2">
                        <label for="category">Categoria</label>
                        <input type="text" class="form-control bg-white" id="category" name="category"
                            value="{{ $invoice->category }}" disabled>
                    </div>

                </div>

                <div class="d-flex flex-wrap justify-content-start">

                    <div class="col-3 form-group pr-2">
                        <label for="value">Valor</label>
                        <input type="text" class="form-control bg-white" id="value" name="value"
                            value="{{ $invoice->value }}" disabled>
                    </div>

                    <div class="col-3 form-group px-2">
                        <label for="due_date">Data de Vencimento</label>
                        <input type="text" class="form-control bg-white" id="due_date" name="due_date"
                            value="{{ $invoice->due_date }}" disabled>
                    </div>

                    <div class="col-3 form-group px-2">
                        <label for="repetition">Repetição</label>
                        <input type="text" class="form-control bg-white" id="repetition" name="repetition"
                            value="{{ $invoice->repetition }}" disabled>
                    </div>

                    @if ($invoice->quota > 1)
                        <div class="col-3 form-group pl-2">
                            <label for="quota">Parcelas</label>
                            <input type="text" class="form-control bg-white" id="quota" name="repetition"
                                value="{{ $invoice->quota }}" disabled>
                        </div>
                    @endif

                </div>

                @if ($invoice->annotation)
                    <div class="d-flex flex-wrap justify-content-between">
                        <div class="col-12 form-group px-0">
                            <label for="annotation">Anotação</label>
                            <textarea type="text" class="form-control bg-white" id="annotation" name="annotation" rows="2">{{ $invoice->annotation }}</textarea>
                        </div>
                    </div>
                @endif

                <div class="d-flex flex-wrap justify-content-start">
                    <div class="col-12 form-group px-2">
                        <label for="subsidiary_id">Filial</label>
                        <input type="text" class="form-control bg-white" id="subsidiary_id" name="subsidiary_id"
                            value="{{ $invoice->subsidiary->alias_name }}" disabled>
                    </div>
                </div>

                <div class="d-flex flex-wrap justify-content-start">
                    <div class="col-6 form-group pr-2">
                        <label for="purchase_mode">Método de Pagamento</label>
                        <input type="text" class="form-control bg-white" id="purchase_mode" name="purchase_mode"
                            value="{{ $invoice->purchase_mode }}" disabled>
                    </div>

                    <div class="col-6 form-group pl-2">
                        <label for="status">Status</label>
                        <input type="text" class="form-control bg-white" id="status" name="status"
                            value="{{ $invoice->status }}" disabled>
                    </div>
                </div>

            </div>
        </form>

    </div>
@endsection

@section('custom_js')
    <script>
        window.onload = function() {
            $(".main-footer").remove();
            window.print();
            setTimeout(function() {
                window.close();
            }, 1000);
        }
    </script>
@endsection
