@extends('adminlte::page')
@section('adminlte_css')
    <style>
        @page {
            margin: 2cm;
        }
    </style>
@endsection

@section('title', '- Ordem de Serviço')

@section('content')

    <div class="card">
        <div class="d-flex flex-wrap justify-content-center">
            {{-- <img src="{{ asset('img/logo.png') }}" style="width: 500px;"> --}}
            <h2 class="w-100 text-center">Ordem de Serviço</h2>
        </div>
        <div class="card-header">
            <h3 class="card-title">Dados Cadastrais da Ordem de Serviço</h3>
        </div>

        <form>
            <div class="card-body">

                <div class="d-flex flex-wrap justify-content-between">
                    <div class="col-6 form-group pr-2">
                        <label for="activity_id">Atividade</label>
                        <input type="text" class="form-control bg-white" id="activity_id" name="activity_id"
                            value="{{ $serviceOrder->activity->name }}" disabled>
                    </div>
                    <div class="col-6 form-group pl-2">
                        <label for="client_id">Cliente</label>
                        <input type="text" class="form-control bg-white" id="client_id" name="client_id"
                            value="{{ $serviceOrder->client->name }}" disabled>
                    </div>
                </div>

                <div class="d-flex flex-wrap justify-content-between">
                    <div class="col-12 form-group px-0">
                        <label for="description">Descrição do Serviço</label>
                        <textarea name="description" rows="2" class="form-control bg-white" id="description" disabled>{{ $serviceOrder->description }}</textarea>
                    </div>
                </div>

                <div class="d-flex flex-wrap justify-content-between">
                    <div class="col-6 form-group pr-2">
                        <label for="zipcode">CEP</label>
                        <input type="text" class="form-control bg-white" id="zipcode" name="zipcode"
                            value="{{ $serviceOrder->zipcode }}" disabled>
                    </div>
                    <div class="col-6 form-group pl-2">
                        <label for="street">Rua</label>
                        <input type="text" class="form-control bg-white" id="street" name="street"
                            value="{{ $serviceOrder->street }}" disabled>
                    </div>
                </div>

                <div class="d-flex flex-wrap justify-content-between">
                    <div class="col-6 form-group pr-2">
                        <label for="number">Número</label>
                        <input type="text" class="form-control bg-white" id="number" name="number"
                            value="{{ $serviceOrder->number }}" disabled>
                    </div>
                    <div class="col-6 form-group pl-2">
                        <label for="complement">Complemento</label>
                        <input type="text" class="form-control bg-white" id="complement" name="complement"
                            value="{{ $serviceOrder->complement }}" disabled>
                    </div>
                </div>

                <div class="d-flex flex-wrap justify-content-between">
                    <div class="col-6 form-group pr-2">
                        <label for="neighborhood">Bairro</label>
                        <input type="text" class="form-control bg-white" id="neighborhood" name="neighborhood"
                            value="{{ $serviceOrder->neighborhood }}" disabled>
                    </div>
                    <div class="col-6 form-group pl-2">
                        <label for="city">Cidade</label>
                        <input type="text" class="form-control bg-white" id="city" name="city"
                            value="{{ $serviceOrder->city }}" disabled>
                    </div>
                </div>

                <div class="d-flex flex-wrap justify-content-between">
                    <div class="col-6 form-group pr-2">
                        <label for="state">Estado</label>
                        <input type="text" class="form-control bg-white" id="state" name="state"
                            value="{{ $serviceOrder->state }}" disabled>
                    </div>

                    <div class="col-6 form-group pl-2">
                        <label for="telephone">Telefone de Contato</label>
                        <input type="text" class="form-control bg-white" id="telephone" name="telephone"
                            value="{{ $serviceOrder->telephone }}" disabled>
                    </div>
                </div>

                <div class="d-flex flex-wrap justify-content-between">
                    <div class="col-6 form-group pr-2">
                        <label for="user_id">Participante</label>
                        <input type="text" class="form-control bg-white" id="user_id" name="user_id"
                            value="{{ $serviceOrder->user->name }} ({{ $serviceOrder->user->roles->first()->name }})"
                            disabled>
                    </div>

                    <div class="col-3 form-group px-2">
                        <label for="execution_date">Data de Execução</label>
                        <input type="text" class="form-control bg-white" id="execution_date" name="execution_date"
                            value="{{ $serviceOrder->execution_date }}" disabled>
                    </div>

                    <div class="col-3 form-group pl-2">
                        <label for="deadline">Data Limite</label>
                        <input type="text" class="form-control bg-white" id="deadline" name="deadline"
                            value="{{ $serviceOrder->execution_date }}" disabled>
                    </div>
                </div>

                <div class="d-flex flex-wrap justify-content-between">
                    <div class="col-6 form-group pr-2">
                        <label for="priority">Prioridade</label>
                        <input type="text" class="form-control bg-white" id="priority" name="priority"
                            value="{{ $serviceOrder->priority }}" disabled>
                    </div>

                    <div class="col-6 form-group pl-2">
                        <label for="status">Status</label>
                        <input type="text" class="form-control bg-white" id="status" name="status"
                            value="{{ $serviceOrder->status }}" disabled>
                    </div>
                </div>

                <div class="d-flex flex-wrap justify-content-between">
                    <div class="col-12 form-group px-2">
                        <label for="state">Observações</label>
                        <div class="p-2 border rounded">
                            {!! $serviceOrder->observations !!}
                        </div>
                    </div>
                </div>

                @if ($serviceOrder->costumer_signature)
                    <div class="col-12 form-group px-0">
                        <label>Assinatura do Cliente:</label>
                        <p class="small text-muted mb-n2">Assinatura atual</p>
                        <div class="border rounded my-2">
                            <img id="costumer_sig_img" class="img-fluid"
                                src="{{ asset('storage/signatures/' . $serviceOrder->costumer_signature) }}"
                                alt="">
                        </div>
                    </div>
                @endif

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
