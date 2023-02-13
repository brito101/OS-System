@extends('adminlte::page')

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

                <div class="col-12 d-flex flex-wrap justify-content-start">
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
                                                <label for="title">Título</label>
                                                <input type="text" class="form-control" id="title"
                                                    placeholder="Título do Cartão" name="title" value="{{ old('title') }}"
                                                    required>
                                            </div>

                                            <div class="col-12 form-group px-0">
                                                <label for="description">Descrição</label>
                                                <input type="text" class="form-control" id="description"
                                                    placeholder="Título do Cartão" name="description"
                                                    value="{{ old('description') }}">
                                            </div>

                                        </div>

                                        <div class="d-flex flex-wrap justify-content-start">
                                            <div class="col-12 col-md-3 form-group px-0 pr-md-2">
                                                <label for="value">Valor</label>
                                                <input type="text" class="form-control money_format_2" id="value"
                                                    placeholder="Valor em reais" name="value" value="{{ old('value') }}"
                                                    required>
                                            </div>
                                        </div>
                                    </div>

                                    <x-slot name="footerSlot">
                                        <button type="submit" class="btn btn-primary">Enviar</button>
                                        <x-adminlte-button theme="danger" data-dismiss="modal" label="Cancelar" />
                                    </x-slot>
                                </form>
                            </x-adminlte-modal>

                            {{-- Example button to open modal --}}
                            <x-adminlte-button label="Novo Cartão" data-toggle="modal" data-target="#modalKanban"
                                class="bg-teal" id="modalButton" icon="fas fa fa-plus" />

                        </div>
                    @endcan

                    <div class="col-12 col-md-3 p-2">
                        <div class="card card-row card-secondary">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Rascunho
                                </h3>
                            </div>
                            <div class="card-body draggable-area" data-area="draft">
                                @foreach ($draftKanbans as $kanban)
                                    <div draggable="true" class="draggable-item" data-item="{{ $kanban->id }}">
                                        <div class="card card-secondary card-outline">
                                            <div class="card-header" data-toggle="collapse"
                                                href="#collapse{{ $kanban->id }}" role="button" aria-expanded="false"
                                                aria-controls="collapse{{ $kanban->id }}">
                                                <h5 class="card-title">
                                                    <span
                                                        class="btn btn-tool btn-link">#{{ $kanban->id }}</span>{{ $kanban->title }}
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
                                                        {{ $kanban->value }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="px-4">
                                <p>Total: <span id="draftSum">{{ $draftSum }}</span></p>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-3 p-2">
                        <div class="card card-row card-danger">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Para Fazer
                                </h3>
                            </div>
                            <div class="card-body draggable-area" data-area="do">
                                @foreach ($doKanbans as $kanban)
                                    <div draggable="true" class="draggable-item" data-item="{{ $kanban->id }}">
                                        <div class="card card-secondary card-outline">
                                            <div class="card-header" data-toggle="collapse"
                                                href="#collapse{{ $kanban->id }}" role="button" aria-expanded="false"
                                                aria-controls="collapse{{ $kanban->id }}">
                                                <h5 class="card-title">
                                                    <span
                                                        class="btn btn-tool btn-link">#{{ $kanban->id }}</span>{{ $kanban->title }}
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
                                                        {{ $kanban->value }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="px-4">
                                <p>Total: <span id="doSum">{{ $doSum }}</span></p>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-3 p-2">
                        <div class="card card-row card-warning">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Em progresso
                                </h3>
                            </div>
                            <div class="card-body draggable-area" data-area="progress">
                                @foreach ($progressKanbans as $kanban)
                                    <div draggable="true" class="draggable-item" data-item="{{ $kanban->id }}">
                                        <div class="card card-secondary card-outline">
                                            <div class="card-header" data-toggle="collapse"
                                                href="#collapse{{ $kanban->id }}" role="button" aria-expanded="false"
                                                aria-controls="collapse{{ $kanban->id }}">
                                                <h5 class="card-title">
                                                    <span
                                                        class="btn btn-tool btn-link">#{{ $kanban->id }}</span>{{ $kanban->title }}
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
                                                        {{ $kanban->value }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="px-4">
                                <p>Total: <span id="progressSum">{{ $progressSum }}</span></p>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-3 p-2">
                        <div class="card card-row card-success">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Concluído
                                </h3>
                            </div>
                            <div class="card-body draggable-area" data-area="finish">
                                @foreach ($finishKanbans as $kanban)
                                    <div draggable="true" class="draggable-item" data-item="{{ $kanban->id }}">
                                        <div class="card card-secondary card-outline">
                                            <div class="card-header" data-toggle="collapse"
                                                href="#collapse{{ $kanban->id }}" role="button" aria-expanded="false"
                                                aria-controls="collapse{{ $kanban->id }}">
                                                <h5 class="card-title">
                                                    <span
                                                        class="btn btn-tool btn-link">#{{ $kanban->id }}</span>{{ $kanban->title }}
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
                                                        {{ $kanban->value }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="px-4">
                                <p>Total: <span id="finishSum">{{ $finishSum }}</span></p>
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

                    $('#draftSum').text((res.draftSum).toLocaleString('pt-br', {
                        style: 'currency',
                        currency: 'BRL'
                    }));
                    $('#doSum').text((res.doSum).toLocaleString('pt-br', {
                        style: 'currency',
                        currency: 'BRL'
                    }));
                    $('#progressSum').text((res.progressSum).toLocaleString('pt-br', {
                        style: 'currency',
                        currency: 'BRL'
                    }));
                    $('#finishSum').text((res.finishSum).toLocaleString('pt-br', {
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
                        $('#draftSum').text((res.draftSum).toLocaleString('pt-br', {
                            style: 'currency',
                            currency: 'BRL'
                        }));
                        $('#doSum').text((res.doSum).toLocaleString('pt-br', {
                            style: 'currency',
                            currency: 'BRL'
                        }));
                        $('#progressSum').text((res.progressSum).toLocaleString('pt-br', {
                            style: 'currency',
                            currency: 'BRL'
                        }));
                        $('#finishSum').text((res.finishSum).toLocaleString('pt-br', {
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
            formModal[2].value = ($(e.currentTarget).parent().parent().children()[0].innerText).replace(
                `#${itemEditId}`, '');
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
