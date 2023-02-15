@extends('adminlte::page')
@section('plugins.select2', true)

@section('title', '- Kanban')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-square"></i> Kanban</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Kanban</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-0 px-md-3">
        @include('components.alert')
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                @can('Criar Kanban')
                    <div class="col-12">
                        <x-adminlte-modal id="modalKanban" title="Cartão Kanban" size="lg" theme="teal"
                            icon="fas fa-square" v-centered static-backdrop scrollable>
                            <form method="POST" action="{{ route('admin.kanban.store') }}">
                                @csrf
                                <div class="card-body">
                                    <input type="hidden" name="id" value="">
                                    <div class="d-flex flex-wrap justify-content-between">
                                        <div class="col-12 form-group px-0">
                                            <label for="client_id">Cliente</label>
                                            <x-adminlte-select2 name="client_id" required>
                                                <option disabled selected value="">Selecione</option>
                                                @foreach ($clients as $client)
                                                    <option {{ old('client_id') == $client->id ? 'selected' : '' }}
                                                        value="{{ $client->id }}">{{ $client->name }}
                                                        ({{ $client->document_person }})
                                                    </option>
                                                @endforeach
                                            </x-adminlte-select2>
                                        </div>

                                        <div class="col-12 form-group px-0">
                                            <label for="description">Descrição do serviço ou produto</label>
                                            <input type="text" class="form-control" id="description"
                                                placeholder="Descrição do serviço ou produto" name="description"
                                                value="{{ old('description') }}">
                                        </div>

                                    </div>

                                    <div class="d-flex flex-wrap justify-content-start">
                                        <div class="col-12 col-md-3 form-group px-0 pr-md-2">
                                            <label for="proposal">Valor da Proposta</label>
                                            <input type="text" class="form-control money_format_2" id="proposal"
                                                placeholder="Valor em reais" name="proposal" value="{{ old('proposal') }}"
                                                required>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Enviar</button>
                                </div>
                            </form>
                            <x-slot name="footerSlot">
                                <x-adminlte-button theme="danger" data-dismiss="modal" label="Cancelar" />
                            </x-slot>
                        </x-adminlte-modal>

                        {{-- Example button to open modal --}}
                        <x-adminlte-button label="Novo Lead" data-toggle="modal" data-target="#modalKanban" class="bg-teal"
                            id="modalButton" icon="fas fa fa-plus" />

                    </div>
                @endcan

                <div class="row d-flex flex-nowrap px-2 h-100 pt-2" style="overflow-x: auto">
                    <div class="col-12 col-md-3 p-2">
                        <div class="card card-row card-light">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Visita Agendada
                                </h3>
                            </div>
                            <div class="card-body draggable-area" data-area="scheduledVisit">
                                @foreach ($scheduledVisit as $kanban)
                                    <div draggable="true" class="draggable-item" data-item="{{ $kanban->id }}">
                                        <div class="card card-secondary card-outline">
                                            <div class="card-header" data-toggle="collapse"
                                                href="#collapse{{ $kanban->id }}" role="button" aria-expanded="false"
                                                aria-controls="collapse{{ $kanban->id }}">
                                                <h5 class="card-title" data-client_id="{{ $kanban->client_id }}">
                                                    <span
                                                        class="btn btn-tool btn-link">#{{ $kanban->id }}</span>{{ $kanban->client->name }}
                                                </h5>
                                                <div class="card-tools">
                                                    <a href="#" class="btn btn-tool kanban-edit"
                                                        data-edit="{{ $kanban->id }}">
                                                        <i class="fas fa-pen"></i>
                                                    </a>
                                                    <a href="#" class="btn btn-tool kanban-trash"
                                                        data-trash="{{ $kanban->id }}">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="collapse" id="collapse{{ $kanban->id }}">
                                                <div class="card-body">
                                                    <p>
                                                        {{ $kanban->description }}
                                                    </p>
                                                    <p>
                                                        {{ $kanban->proposal }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="px-4">
                                <p>Total: <span id="scheduledVisitSum">{{ $scheduledVisitSum }}</span></p>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-3 p-2">
                        <div class="card card-row card-secondary">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Vistoria Executada
                                </h3>
                            </div>
                            <div class="card-body draggable-area" data-area="performedInspection">
                                @foreach ($performedInspection as $kanban)
                                    <div draggable="true" class="draggable-item" data-item="{{ $kanban->id }}">
                                        <div class="card card-secondary card-outline">
                                            <div class="card-header" data-toggle="collapse"
                                                href="#collapse{{ $kanban->id }}" role="button" aria-expanded="false"
                                                aria-controls="collapse{{ $kanban->id }}">
                                                <h5 class="card-title" data-client_id="{{ $kanban->client_id }}">
                                                    <span
                                                        class="btn btn-tool btn-link">#{{ $kanban->id }}</span>{{ $kanban->client->name }}
                                                </h5>
                                                <div class="card-tools">
                                                    <a href="#" class="btn btn-tool kanban-edit"
                                                        data-edit="{{ $kanban->id }}">
                                                        <i class="fas fa-pen"></i>
                                                    </a>
                                                    <a href="#" class="btn btn-tool kanban-trash"
                                                        data-trash="{{ $kanban->id }}">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="collapse" id="collapse{{ $kanban->id }}">
                                                <div class="card-body">
                                                    <p>
                                                        {{ $kanban->description }}
                                                    </p>
                                                    <p>
                                                        {{ $kanban->proposal }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="px-4">
                                <p>Total: <span id="performedInspectionSum">{{ $performedInspectionSum }}</span></p>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-3 p-2">
                        <div class="card card-row card-primary">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Envio de Proposta
                                </h3>
                            </div>
                            <div class="card-body draggable-area" data-area="submissionProposal">
                                @foreach ($submissionProposal as $kanban)
                                    <div draggable="true" class="draggable-item" data-item="{{ $kanban->id }}">
                                        <div class="card card-secondary card-outline">
                                            <div class="card-header" data-toggle="collapse"
                                                href="#collapse{{ $kanban->id }}" role="button" aria-expanded="false"
                                                aria-controls="collapse{{ $kanban->id }}">
                                                <h5 class="card-title" data-client_id="{{ $kanban->client_id }}">
                                                    <span
                                                        class="btn btn-tool btn-link">#{{ $kanban->id }}</span>{{ $kanban->client->name }}
                                                </h5>
                                                <div class="card-tools">
                                                    <a href="#" class="btn btn-tool kanban-edit"
                                                        data-edit="{{ $kanban->id }}">
                                                        <i class="fas fa-pen"></i>
                                                    </a>
                                                    <a href="#" class="btn btn-tool kanban-trash"
                                                        data-trash="{{ $kanban->id }}">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="collapse" id="collapse{{ $kanban->id }}">
                                                <div class="card-body">
                                                    <p>
                                                        {{ $kanban->description }}
                                                    </p>
                                                    <p>
                                                        {{ $kanban->proposal }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="px-4">
                                <p>Total: <span id="submissionProposalSum">{{ $submissionProposalSum }}</span></p>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-3 p-2">
                        <div class="card card-row card-orange">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Negociação
                                </h3>
                            </div>
                            <div class="card-body draggable-area" data-area="negotiation">
                                @foreach ($negotiation as $kanban)
                                    <div draggable="true" class="draggable-item" data-item="{{ $kanban->id }}">
                                        <div class="card card-secondary card-outline">
                                            <div class="card-header" data-toggle="collapse"
                                                href="#collapse{{ $kanban->id }}" role="button" aria-expanded="false"
                                                aria-controls="collapse{{ $kanban->id }}">
                                                <h5 class="card-title" data-client_id="{{ $kanban->client_id }}">
                                                    <span
                                                        class="btn btn-tool btn-link">#{{ $kanban->id }}</span>{{ $kanban->client->name }}
                                                </h5>
                                                <div class="card-tools">
                                                    <a href="#" class="btn btn-tool kanban-edit"
                                                        data-edit="{{ $kanban->id }}">
                                                        <i class="fas fa-pen"></i>
                                                    </a>
                                                    <a href="#" class="btn btn-tool kanban-trash"
                                                        data-trash="{{ $kanban->id }}">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="collapse" id="collapse{{ $kanban->id }}">
                                                <div class="card-body">
                                                    <p>
                                                        {{ $kanban->description }}
                                                    </p>
                                                    <p>
                                                        {{ $kanban->proposal }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="px-4">
                                <p>Total: <span id="negotiationSum">{{ $negotiationSum }}</span></p>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-3 p-2">
                        <div class="card card-row card-warning">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Assembléia Marcada
                                </h3>
                            </div>
                            <div class="card-body draggable-area" data-area="scheduledMeeting">
                                @foreach ($scheduledMeeting as $kanban)
                                    <div draggable="true" class="draggable-item" data-item="{{ $kanban->id }}">
                                        <div class="card card-secondary card-outline">
                                            <div class="card-header" data-toggle="collapse"
                                                href="#collapse{{ $kanban->id }}" role="button" aria-expanded="false"
                                                aria-controls="collapse{{ $kanban->id }}">
                                                <h5 class="card-title" data-client_id="{{ $kanban->client_id }}">
                                                    <span
                                                        class="btn btn-tool btn-link">#{{ $kanban->id }}</span>{{ $kanban->client->name }}
                                                </h5>
                                                <div class="card-tools">
                                                    <a href="#" class="btn btn-tool kanban-edit"
                                                        data-edit="{{ $kanban->id }}">
                                                        <i class="fas fa-pen"></i>
                                                    </a>
                                                    <a href="#" class="btn btn-tool kanban-trash"
                                                        data-trash="{{ $kanban->id }}">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="collapse" id="collapse{{ $kanban->id }}">
                                                <div class="card-body">
                                                    <p>
                                                        {{ $kanban->description }}
                                                    </p>
                                                    <p>
                                                        {{ $kanban->proposal }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="px-4">
                                <p>Total: <span id="scheduledMeetingSum">{{ $scheduledMeetingSum }}</span></p>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-3 p-2">
                        <div class="card card-row card-success">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Fechamento
                                </h3>
                            </div>
                            <div class="card-body draggable-area" data-area="closure">
                                @foreach ($closure as $kanban)
                                    <div draggable="true" class="draggable-item" data-item="{{ $kanban->id }}">
                                        <div class="card card-secondary card-outline">
                                            <div class="card-header" data-toggle="collapse"
                                                href="#collapse{{ $kanban->id }}" role="button" aria-expanded="false"
                                                aria-controls="collapse{{ $kanban->id }}">
                                                <h5 class="card-title" data-client_id="{{ $kanban->client_id }}">
                                                    <span
                                                        class="btn btn-tool btn-link">#{{ $kanban->id }}</span>{{ $kanban->client->name }}
                                                </h5>
                                                <div class="card-tools">
                                                    <a href="#" class="btn btn-tool kanban-edit"
                                                        data-edit="{{ $kanban->id }}">
                                                        <i class="fas fa-pen"></i>
                                                    </a>
                                                    <a href="#" class="btn btn-tool kanban-trash"
                                                        data-trash="{{ $kanban->id }}">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="collapse" id="collapse{{ $kanban->id }}">
                                                <div class="card-body">
                                                    <p>
                                                        {{ $kanban->description }}
                                                    </p>
                                                    <p>
                                                        {{ $kanban->proposal }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="px-4">
                                <p>Total: <span id="closureSum">{{ $closureSum }}</span></p>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-3 p-2">
                        <div class="card card-row card-danger">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Perdido / Motivo
                                </h3>
                            </div>
                            <div class="card-body draggable-area" data-area="lost">
                                @foreach ($lost as $kanban)
                                    <div draggable="true" class="draggable-item" data-item="{{ $kanban->id }}">
                                        <div class="card card-secondary card-outline">
                                            <div class="card-header" data-toggle="collapse"
                                                href="#collapse{{ $kanban->id }}" role="button" aria-expanded="false"
                                                aria-controls="collapse{{ $kanban->id }}">
                                                <h5 class="card-title" data-client_id="{{ $kanban->client_id }}">
                                                    <span
                                                        class="btn btn-tool btn-link">#{{ $kanban->id }}</span>{{ $kanban->client->name }}
                                                </h5>
                                                <div class="card-tools">
                                                    <a href="#" class="btn btn-tool kanban-edit"
                                                        data-edit="{{ $kanban->id }}">
                                                        <i class="fas fa-pen"></i>
                                                    </a>
                                                    <a href="#" class="btn btn-tool kanban-trash"
                                                        data-trash="{{ $kanban->id }}">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="collapse" id="collapse{{ $kanban->id }}">
                                                <div class="card-body">
                                                    <p>
                                                        {{ $kanban->description }}
                                                    </p>
                                                    <p>
                                                        {{ $kanban->proposal }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="px-4">
                                <p>Total: <span id="lostSum">{{ $lostSum }}</span></p>
                            </div>
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
    <script>
        let item = null;
        let area = null;
        let itemDestroy = null;
        const formModal = $("form")[1];

        function updateKanban() {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '{{ route('admin.kanban-ajax.update') }}',
                data: {
                    item,
                    area
                },
                success: function(res) {
                    item = null;
                    area = null;

                    $('#scheduledVisitSum').text((res.scheduledVisitSum).toLocaleString('pt-br', {
                        style: 'currency',
                        currency: 'BRL'
                    }));
                    $('#performedInspectionSum').text((res.performedInspectionSum).toLocaleString('pt-br', {
                        style: 'currency',
                        currency: 'BRL'
                    }));
                    $('#submissionProposalSum').text((res.submissionProposalSum).toLocaleString('pt-br', {
                        style: 'currency',
                        currency: 'BRL'
                    }));
                    $('#negotiationSum').text((res.negotiationSum).toLocaleString('pt-br', {
                        style: 'currency',
                        currency: 'BRL'
                    }));
                    $('#scheduledMeetingSum').text((res.scheduledMeetingSum).toLocaleString('pt-br', {
                        style: 'currency',
                        currency: 'BRL'
                    }));
                    $('#closureSum').text((res.closureSum).toLocaleString('pt-br', {
                        style: 'currency',
                        currency: 'BRL'
                    }));
                    $('#lostSum').text((res.lostSum).toLocaleString('pt-br', {
                        style: 'currency',
                        currency: 'BRL'
                    }));
                },
            });
        }

        // items functions
        function dragStart(e) {
            e.currentTarget.classList.add('dragging');
        }

        function dragEnd(e) {
            e.currentTarget.classList.remove('dragging');
        }

        // areas functions
        function dragOver(e) {
            let dragItem = document.querySelector('.draggable-item.dragging');
            e.currentTarget.appendChild(dragItem);
            item = dragItem.dataset.item;
            area = e.target.dataset.area;
            if (item && area) {
                updateKanban();
            }
        }

        // Events
        document.querySelectorAll('.draggable-item').forEach(item => {
            item.addEventListener('dragstart', dragStart);
            item.addEventListener('dragend', dragEnd);
        });

        document.querySelectorAll('.draggable-area').forEach(area => {
            area.addEventListener('dragover', dragOver);
            area.addEventListener('drop', dragOver);
        });

        $(".kanban-trash").on("click", function(e) {
            let itemDestroy = $(e.currentTarget).data('trash');
            if (window.confirm("Confirma a exclusão deste Cartão?")) {
                let itemDestroy = $(e.currentTarget).data('trash');
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'DELETE',
                    url: '{{ route('admin.kanban-ajax.destroy') }}',
                    data: {
                        itemDestroy
                    },
                    success: function(res) {
                        itemDestroy = null;
                        $('#scheduledVisitSum').text((res.scheduledVisitSum).toLocaleString('pt-br', {
                            style: 'currency',
                            currency: 'BRL'
                        }));
                        $('#performedInspectionSum').text((res.performedInspectionSum).toLocaleString(
                            'pt-br', {
                                style: 'currency',
                                currency: 'BRL'
                            }));
                        $('#submissionProposalSum').text((res.submissionProposalSum).toLocaleString(
                            'pt-br', {
                                style: 'currency',
                                currency: 'BRL'
                            }));
                        $('#negotiationSum').text((res.negotiationSum).toLocaleString('pt-br', {
                            style: 'currency',
                            currency: 'BRL'
                        }));
                        $('#scheduledMeetingSum').text((res.scheduledMeetingSum).toLocaleString(
                            'pt-br', {
                                style: 'currency',
                                currency: 'BRL'
                            }));
                        $('#closureSum').text((res.closureSum).toLocaleString('pt-br', {
                            style: 'currency',
                            currency: 'BRL'
                        }));
                        $('#lostSum').text((res.lostSum).toLocaleString('pt-br', {
                            style: 'currency',
                            currency: 'BRL'
                        }));
                        $(e.currentTarget).parent().parent().parent().remove();
                        alert('Exclusão Realizada');
                    },
                });
            }
        });

        $(".kanban-edit").on("click", function(e) {
            let itemEditId = $(e.currentTarget).data('edit');
            $("#modalButton").trigger('click');
            formModal[1].value = (itemEditId);
            let client_id = $(e.currentTarget).parent().parent().children()[0].dataset.client_id;
            $("#client_id").select2("val", `${client_id}`);
            formModal[3].value = ($(e.currentTarget).parent().parent().parent().children()[1].firstElementChild
                .children[0].innerText).trim();
            formModal[4].value = ($(e.currentTarget).parent().parent().parent().children()[1].firstElementChild
                .children[1].innerText).trim();
        });

        $("#modalButton").on("click", function() {
            formModal[1].value = null;
            formModal[2].value = null;
            formModal[3].value = null;
            formModal[4].value = null;
        });
    </script>
@endsection
