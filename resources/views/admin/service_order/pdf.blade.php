@extends('adminlte::page')
@section('adminlte_css')
<style>
    @page {
        margin: 2cm;
    }

    textarea {
        overflow: hidden;
        resize: none;
    }
</style>
@endsection

@section('title', '- Ordem de Serviço')

@section('content')

<div class="card">
    <div class="d-flex flex-wrap justify-content-center">
        <img src="{{ asset('img/logo.png') }}" class="col-2" style="width: 100px">
        <h2 class="text-center col-9 d-flex align-items-center ml-5 mt-3 display-5 font-weight-bold">Ordem de Serviço nº
            {{ $serviceOrder->number_series }}
        </h2>
    </div>
    <div class="card-header">
        <h3 class="card-title">Dados Cadastrais da Ordem de Serviço</h3>
    </div>

    <div class="card-body pb-0 pt-1 text-muted text-right">Criada
        {{ isset($serviceOrder->author->name) ? 'por ' . $serviceOrder->author->name : '' }} em
        {{ $serviceOrder->created_at }} hs.
    </div>

    <form>
        <div class="card-body">

            <div class="d-flex flex-wrap justify-content-between">
                <div class="col-12 form-group px-0">
                    <label for="activity_id">Atividade</label>
                    <input type="text" class="form-control bg-white" id="activity_id" name="activity_id" value="{{ $serviceOrder->activity->name }}" disabled>
                </div>
            </div>

            <div class="d-flex flex-wrap justify-content-between">
                <div class="col-12 form-group px-0">
                    <label for="client_id">Cliente</label>
                    <input type="text" class="form-control bg-white" id="client_id" name="client_id" value="{{ $serviceOrder->client->name }} ({{ $serviceOrder->client->document_person }})" disabled>
                </div>
            </div>

            <div class="d-flex flex-wrap justify-content-between">
                <div class="col-12 form-group px-0">
                    <label for="description">Descrição do Serviço</label>
                    <textarea name="description" class="form-control bg-white" id="description" disabled>{{ $serviceOrder->description }}</textarea>
                </div>
            </div>

            <div class="d-flex flex-wrap justify-content-between">
                <div class="col-6 form-group pr-2">
                    <label for="zipcode">CEP</label>
                    <input type="text" class="form-control bg-white" id="zipcode" name="zipcode" value="{{ $serviceOrder->zipcode }}" disabled>
                </div>
                <div class="col-6 form-group pl-2">
                    <label for="street">Rua</label>
                    <input type="text" class="form-control bg-white" id="street" name="street" value="{{ $serviceOrder->street }}" disabled>
                </div>
            </div>

            <div class="d-flex flex-wrap justify-content-between">
                <div class="col-6 form-group pr-2">
                    <label for="number">Número</label>
                    <input type="text" class="form-control bg-white" id="number" name="number" value="{{ $serviceOrder->number }}" disabled>
                </div>
                <div class="col-6 form-group pl-2">
                    <label for="complement">Complemento</label>
                    <input type="text" class="form-control bg-white" id="complement" name="complement" value="{{ $serviceOrder->complement }}" disabled>
                </div>
            </div>

            <div class="d-flex flex-wrap justify-content-between">
                <div class="col-6 form-group pr-2">
                    <label for="neighborhood">Bairro</label>
                    <input type="text" class="form-control bg-white" id="neighborhood" name="neighborhood" value="{{ $serviceOrder->neighborhood }}" disabled>
                </div>
                <div class="col-6 form-group pl-2">
                    <label for="city">Cidade</label>
                    <input type="text" class="form-control bg-white" id="city" name="city" value="{{ $serviceOrder->city }}" disabled>
                </div>
            </div>

            <div class="d-flex flex-wrap justify-content-between">
                <div class="col-6 form-group pr-2">
                    <label for="state">Estado</label>
                    <input type="text" class="form-control bg-white" id="state" name="state" value="{{ $serviceOrder->state }}" disabled>
                </div>

                <div class="col-6 form-group pl-2">
                    <label for="telephone">Telefone de Contato</label>
                    <input type="text" class="form-control bg-white" id="telephone" name="telephone" value="{{ $serviceOrder->telephone }}" disabled>
                </div>
            </div>

            <div class="d-flex flex-wrap justify-content-between">
                <div class="col-12 form-group px-0">
                    <label for="user_id">Participante</label>
                    <input type="text" class="form-control bg-white" id="user_id" name="user_id" value="{{ $serviceOrder->user->name }} ({{ $serviceOrder->user->roles->first()->name }})" disabled>
                </div>
            </div>

            <div class="d-flex flex-wrap justify-content-between">
                <div class="col-12 form-group px-0">
                    <label for="subsidiary_id">Filial</label>
                    <input type="text" class="form-control bg-white" id="subsidiary_id" name="subsidiary_id" value="{{ $serviceOrder->subsidiary->alias_name ?? null }}" disabled>

                </div>
            </div>

            <div class="d-flex flex-wrap justify-content-between">
                <div class="col-6 form-group pr-2">
                    <label for="priority">Prioridade</label>
                    <input type="text" class="form-control bg-white" id="priority" name="priority" value="{{ $serviceOrder->priority }}" disabled>
                </div>

                <div class="col-3 form-group px-2">
                    <label for="execution_date">Data de Execução</label>
                    <input type="text" class="form-control bg-white" id="execution_date" name="execution_date" value="{{ $serviceOrder->execution_date }}" disabled>
                </div>

                <div class="col-3 form-group pl-2">
                    <label for="deadline">Data Limite</label>
                    <input type="text" class="form-control bg-white" id="deadline" name="deadline" value="{{ $serviceOrder->execution_date }}" disabled>
                </div>
            </div>

            @if ($serviceOrder->observations)
            <div class="d-flex flex-wrap justify-content-between">
                <div class="col-12 form-group px-2">
                    <label for="observations">Observações</label>
                    <div class="p-2 border rounded" id="observations">
                        {!! $serviceOrder->observations !!}
                    </div>
                </div>
            </div>
            @endif

            <div class="d-flex flex-wrap justify-content-start">
                <div class="col-3 form-group pr-2">
                    <label for="status">Status</label>
                    <input type="text" class="form-control bg-white" id="status" name="status" value="{{ $serviceOrder->status }}" disabled>
                </div>

                @if ($serviceOrder->readiness_date)
                <div class="col-3 form-group px-2">
                    <label for="readiness_date">Data de Prontificação</label>
                    <input type="text" class="form-control bg-white" id="readiness_date" name="readiness_date" value="{{ $serviceOrder->readiness_date }}" disabled>
                </div>
                @endif

                @if ($serviceOrder->start_time)
                <div class="col-3 form-group px-2">
                    <label for="start_time">Horário de Início</label>
                    <input type="text" class="form-control bg-white" id="start_time" name="start_time" value="{{ $serviceOrder->start_time }}" disabled>
                </div>
                @endif

                @if ($serviceOrder->end_time)
                <div class="col-3 form-group pl-2">
                    <label for="end_time">Horário de Conclusão</label>
                    <input type="text" class="form-control bg-white" id="end_time" name="end_time" value="{{ $serviceOrder->end_time }}" disabled>
                </div>
                @endif
            </div>

            @if ($serviceOrder->remarks)
            <div class="d-flex flex-wrap justify-content-between">
                <div class="col-12 form-group px-0">
                    <label for="remarks">Observações de execução</label>
                    <textarea name="remarks" class="form-control bg-white" id="remarks" disabled>{{ $serviceOrder->remarks }}</textarea>
                </div>
            </div>
            @endif

            @if ($serviceOrder->photo != null)
            <div class="d-flex flex-wrap justify-content-center">
                <div class="embed-responsive embed-responsive-16by9 col-6 form-group px-0">
                    <img src="{{ url('storage/service-orders/' . $serviceOrder->photo) }}" alt="Imagem capturada" class="embed-responsive-item shadow-sm border border-1 border-primary rounded" style="max-width: 75%; left: 12.5%;"></canvas>
                </div>
            </div>
            @endif

            @if ($observations->count() > 0)
            <div class="d-flex flex-wrap justify-content-start mt-4" id="observation" data-observation-qtd="{{ $observations->count() - 1 }}">
                @foreach ($observations as $item)
                <label for="observation_{{ $loop->index }}">Observação sobre Etapa de
                    Execução - Autor: {{ $item->user->name }} em
                    {{ date('d/m/Y H:i', strtotime($item->created_at)) }}</label>
                <div class="col-12 form-group px-0 d-flex flex-wrap justify-content-start" id="container_observation_{{ $loop->index }}">
                    <div class="col-12 px-0">
                        <textarea class="form-control bg-white" id="observation_{{ $loop->index }}" placeholder="Observação sobre a execução" name="observation_{{ $loop->index }}" disabled>{{ $item->observation }}</textarea>
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            @if ($serviceOrder->photos->count() > 0)
            <label>Imagens</label>
            <div class="col-12 form-group px-0 d-flex flex-wrap justify-content-start">
                @foreach ($serviceOrder->photos as $photo)
                <div class="col-3 p-2 card">
                    <div class="card-body d-flex justify-content-center align-items-center">
                        <img class="img-fluid" src="{{ asset('storage/' . $photo->photo) }}" alt="">
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            @if ($serviceOrder->costumer_signature)
            <div class="col-12 form-group px-0">
                <label>Assinatura do Cliente:</label>
                <p class="small text-muted mb-n2">Assinatura atual</p>
                <div class="border rounded my-2">
                    <img id="costumer_sig_img" class="img-fluid" src="{{ asset('storage/signatures/' . $serviceOrder->costumer_signature) }}" alt="">
                </div>
            </div>
            @endif

            <div class="d-flex flex-wrap justify-content-between">
                @if ($serviceOrder->costumer_name)
                <div class="col-6 form-group pr-2">
                    <label for="costumer_name">Nome de quem assinou</label>
                    <input type="text" class="form-control bg-white" id="costumer_name" name="costumer_name" value="{{ $serviceOrder->costumer_name }}" disabled>
                </div>
                @endif

                @if ($serviceOrder->costumer_document)
                <div class="col-6 form-group pl-2">
                    <label for="costumer_document">Documento de quem assinou</label>
                    <input type="text" class="form-control bg-white" id="costumer_document" name="costumer_document" value="{{ $serviceOrder->costumer_document }}" disabled>
                </div>
                @endif
            </div>

        </div>
    </form>

</div>
@endsection

@section('custom_js')
<script>
    window.onload = function() {
        var _print = window.print;
        window.print = function() {
            $('textarea').each(function() {
                $(this).height($(this).prop('scrollHeight') + 30);
            });
            _print();
        }
        $(".main-footer").remove();
        window.print();
        setTimeout(function() {
            window.close();
        }, 1000);
    }
</script>
@endsection
