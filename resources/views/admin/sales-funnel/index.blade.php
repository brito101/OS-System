@extends('adminlte::page')
@section('plugins.select2', true)
@section('plugins.BsCustomFileInput', true)

@section('title', '- Funil de Vendas')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-filter"></i> Funil de Vendas</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Funil de Vendas</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-0 px-md-2">
        @include('components.alert')
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                @can('Criar Funil de Vendas')
                    <div class="col-12">
                        <x-adminlte-modal id="modalKanban" title="Funil de Vendas" size="lg" theme="teal"
                            icon="fas fa-filter" v-centered static-backdrop scrollable>
                            <form method="POST" action="{{ route('admin.sales-funnel.store') }}">
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
                        <div class="d-flex flex-wrap justify-content-between">
                            <x-adminlte-button label="Novo Lead" data-toggle="modal" data-target="#modalKanban" class="bg-teal"
                                id="modalButton" icon="fas fa fa-plus" />

                            <a class="btn btn-secondary" href="{{ Storage::url('worksheets/sales_funnel.xlsx') }}"
                                download>Download
                                Planilha</a>
                        </div>

                    </div>
                @endcan

                <div class="col-12 col-md-6 mt-3">
                    <div class="card card-solid">
                        <div class="card-header">
                            <i class="fas fa-fw fa-search"></i> Pesquisa por Vendedor
                        </div>
                        <form method="POST" action="{{ route('admin.sales-funnel.search-seller') }}">
                            @csrf
                            <div class="card-body pb-0">
                                <div class="d-flex flex-wrap justify-content-start">
                                    <div class="col-12 col-md-7 form-group px-0 pr-2">
                                        <x-adminlte-select2 name="seller_id" required>
                                            <option disabled selected value="">Selecione</option>
                                            @foreach ($sellers as $seller)
                                                <option {{ old('seller_id') == $seller->id ? 'selected' : '' }}
                                                    value="{{ $seller->id }}">{{ $seller->name }}
                                                </option>
                                            @endforeach
                                        </x-adminlte-select2>
                                    </div>
                                    <div class="col-12 col-md-5 form-group px-0 pl-2">
                                        <button type="submit" class="btn btn-primary">Pequisar</button>
                                        @if (Route::current()->getName() == 'admin.sales-funnel.search-seller')
                                            <a href="{{ route('admin.sales-funnel.index') }}"
                                                class="btn btn-secondary mx-0 ml-md-2"><i
                                                    class="fas fa-arrow-circle-left"></i> Voltar</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                @can('Criar Funil de Vendas')
                    <div class="col-12 col-md-6 mt-3">
                        <div class="card card-solid">
                            <div class="card-header">
                                <i class="fas fa-fw fa-upload"></i> Importação de planilha para cadastro
                            </div>
                            <form action="{{ route('admin.sales-funnel.import') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="card-body d-flex flex-wrap justify-content-between">
                                    <x-adminlte-input-file name="file" class="col-12 col-md-9"
                                        placeholder="Selecione o arquivo..." legend="Selecionar" />
                                    <button class="btn btn-primary col-12 col-md-3 h-25">Importar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endcan

                <div class="row d-flex flex-nowrap px-2 h-100 pt-2" style="overflow-x: auto">

                    <div class="col-12 col-md-3 p-2">
                        <div class="card card-row card-light">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Visita Agendada <span class="badge badge-pill badge-dark"
                                        id="scheduledVisitCount">{{ $scheduledVisitCount }}</span>
                                </h3>
                            </div>
                            <div class="card-body draggable-area" data-area="scheduledVisit">
                                @foreach ($scheduledVisit as $kanban)
                                    @include('admin.sales-funnel.components.kanban-card')
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
                                    Vistoria Executada <span class="badge badge-pill badge-dark"
                                        id="performedInspectionCount">{{ $performedInspectionCount }}</span>
                                </h3>
                            </div>
                            <div class="card-body draggable-area" data-area="performedInspection">
                                @foreach ($performedInspection as $kanban)
                                    @include('admin.sales-funnel.components.kanban-card')
                                @endforeach
                            </div>
                            <div class="px-4">
                                <p>Total: <span id="performedInspectionSum">{{ $performedInspectionSum }}</span></p>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-3 p-2">
                        <div class="card card-row card-purple">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Aguardando Proposta <span class="badge badge-pill badge-dark"
                                        id="waitingProposalCount">{{ $waitingProposalCount }}</span>
                                </h3>
                            </div>
                            <div class="card-body draggable-area" data-area="waitingProposal">
                                @foreach ($waitingProposal as $kanban)
                                    @include('admin.sales-funnel.components.kanban-card')
                                @endforeach
                            </div>
                            <div class="px-4">
                                <p>Total: <span id="waitingProposalSum">{{ $waitingProposalSum }}</span></p>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-3 p-2">
                        <div class="card card-row card-primary">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Envio de Proposta <span class="badge badge-pill badge-dark"
                                        id="submissionProposalCount">{{ $submissionProposalCount }}</span>
                                </h3>
                            </div>
                            <div class="card-body draggable-area" data-area="submissionProposal">
                                @foreach ($submissionProposal as $kanban)
                                    @include('admin.sales-funnel.components.kanban-card')
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
                                    Negociação <span class="badge badge-pill badge-dark"
                                        id="negotiationCount">{{ $negotiationCount }}</span>
                                </h3>
                            </div>
                            <div class="card-body draggable-area" data-area="negotiation">
                                @foreach ($negotiation as $kanban)
                                    @include('admin.sales-funnel.components.kanban-card')
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
                                    Assembléia Marcada <span class="badge badge-pill badge-dark"
                                        id="scheduledMeetingCount">{{ $scheduledMeetingCount }}</span>
                                </h3>
                            </div>
                            <div class="card-body draggable-area" data-area="scheduledMeeting">
                                @foreach ($scheduledMeeting as $kanban)
                                    @include('admin.sales-funnel.components.kanban-card')
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
                                    Fechamento <span class="badge badge-pill badge-dark"
                                        id="closureCount">{{ $closureCount }}</span>
                                </h3>
                            </div>
                            <div class="card-body draggable-area" data-area="closure">
                                @foreach ($closure as $kanban)
                                    @include('admin.sales-funnel.components.kanban-card')
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
                                    Perdido / Motivo <span class="badge badge-pill badge-dark"
                                        id="lostCount">{{ $lostCount }}</span>
                                </h3>
                            </div>
                            <div class="card-body draggable-area" data-area="lost">
                                @foreach ($lost as $kanban)
                                    @include('admin.sales-funnel.components.kanban-card')
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
        const seller_id = {{ $seller_id ?? 'null' }};
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
                url: '{{ route('admin.sales-funnel-ajax.update') }}',
                data: {
                    item,
                    area,
                    seller_id
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
                    $('#waitingProposalSum').text((res.waitingProposalSum).toLocaleString('pt-br', {
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

                    $('#scheduledVisitCount').text(res.scheduledVisitCount);
                    $('#performedInspectionCount').text(res.performedInspectionCount);
                    $('#waitingProposalCount').text(res.waitingProposalCount);
                    $('#submissionProposalCount').text(res.submissionProposalCount);
                    $('#negotiationCount').text(res.negotiationCount);
                    $('#scheduledMeetingCount').text(res.scheduledMeetingCount);
                    $('#closureCount').text(res.closureCount);
                    $('#lostCount').text(res.lostCount);
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
                    url: '{{ route('admin.sales-funnel-ajax.destroy') }}',
                    data: {
                        itemDestroy,
                        seller_id
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
                        $('#waitingProposalSum').text((res.waitingProposalSum).toLocaleString(
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

                        $('#scheduledVisitCount').text(res.scheduledVisitCount);
                        $('#performedInspectionCount').text(res.performedInspectionCount);
                        $('#waitingProposalCount').text(res.waitingProposalCount);
                        $('#submissionProposalCount').text(res.submissionProposalCount);
                        $('#negotiationCount').text(res.negotiationCount);
                        $('#scheduledMeetingCount').text(res.scheduledMeetingCount);
                        $('#closureCount').text(res.closureCount);
                        $('#lostCount').text(res.lostCount);

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
            formModal[3].value = $(e.currentTarget).parent().parent().parent().find(".kanban_description")
                .text();
            formModal[4].value = $(e.currentTarget).parent().parent().parent().find(".kanban_proposal")
                .text();
        });

        $("#modalButton").on("click", function() {
            formModal[1].value = null;
            formModal[2].value = null;
            formModal[3].value = null;
            formModal[4].value = null;
        });
    </script>
@endsection
