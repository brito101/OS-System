<div draggable="true" class="draggable-item" data-item="{{ $kanban->id }}">
    <div class="card card-secondary card-outline">
        <div class="card-header" data-toggle="collapse" href="#collapse{{ $kanban->id }}" role="button"
            aria-expanded="false" aria-controls="collapse{{ $kanban->id }}">
            <h5 class="card-title" data-client_id="{{ $kanban->client_id }}">
                <span class="btn btn-tool btn-link">#{{ $kanban->id }}</span>{{ $kanban->client->name }}
            </h5>
            <div class="card-tools">
                <a href="#" class="btn btn-tool kanban-edit" data-edit="{{ $kanban->id }}">
                    <i class="fas fa-pen"></i>
                </a>
                <a href="#" class="btn btn-tool kanban-trash" data-trash="{{ $kanban->id }}">
                    <i class="fas fa-trash"></i>
                </a>
            </div>
        </div>

        <div class="collapse" id="collapse{{ $kanban->id }}">
            <div class="card-body">
                <p>
                    <b>Vendedor:</b><br /> <span class="kanban_seller">{{ $kanban->client->seller->name }}</span>
                </p>
                <p>
                    <b>Produto/Serviço:</b><br /> <span class="kanban_description">{{ $kanban->description }}</span>
                </p>
                <p>
                    <b>Produto/Serviço:</b><br /> <span class="kanban_proposal">
                        {{ $kanban->proposal }}</span>
                </p>
            </div>
        </div>
    </div>
</div>
