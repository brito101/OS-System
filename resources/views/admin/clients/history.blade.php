@extends('adminlte::page')
@section('title', '- Timeline de Cliente')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Timeline do cliente #{{ $client->id }}: {{ $client->name }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.clients.index') }}">Clientes</a></li>
                        <li class="breadcrumb-item active">Timeline</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">

                    <div class="timeline">

                        @forelse ($histories as $history)
                            <div class="time-label">
                                <span class="bg-info">{{ $history->created_at }}</span>
                            </div>
                            <div>
                                @switch($history->action)
                                    @case('criado')
                                        <i class="fas fa-user-plus bg-purple"></i>
                                    @break

                                    @case('editado')
                                        <i class="fas fa-edit bg-green"></i>
                                    @break

                                    @case('deletado')
                                        <i class="fas fa-trash bg-danger"></i>
                                    @break

                                    @case('restaurado')
                                        <i class="fas fa-life-ring bg-orange"></i>
                                    @break

                                    @default
                                        <i class="fas fa-edit bg-green"></i>
                                @endswitch

                                <div class="timeline-item col-12 col-md-8" style="max-width: 80%">
                                    <h3 class="timeline-header no-border">
                                        Cliente <a href="{{ route('admin.clients.show', ['client' => $history->client]) }}"
                                            target="_blank">{{ $history->client->name }}</a> {{ $history->action }} por
                                        {{ $history->user->name }}.</h3>
                                    <div class="timeline-body">
                                        Status nesta data: <b>{{ $history->trade_status }}</b>.
                                    </div>
                                    @if ($history->subsidiary)
                                        <div class="timeline-body pt-0">
                                            Filial nesta data: {{ $history->subsidiary->alias_name }} de
                                            {{ $history->subsidiary->city }}/{{ $history->subsidiary->state }}.
                                        </div>
                                    @endif
                                </div>
                            </div>
                            @empty
                                <div class="time-label">
                                    <span class="bg-info">{{ date('d/m/Y H:i', strtotime($client->updated_at)) }}</span>
                                </div>
                                <div>
                                    <i class="fas fa-exclamation bg-warning"></i>

                                    <div class="timeline-item col-12 col-md-8" style="max-width: 80%">
                                        <h3 class="timeline-header no-border">
                                            Cliente <a href="{{ route('admin.clients.show', ['client' => $client->id]) }}"
                                                target="_blank">{{ $client->name }}</a> não possui dados históricos no momento.
                                        </h3>
                                        <div class="timeline-body">
                                            Status nesta data: <b>{{ $client->trade_status }}</b>.
                                        </div>
                                        @isset($client->subsidiary)
                                            <div class="timeline-body pt-0">
                                                Filial nesta data: {{ $client->subsidiary->alias_name }} de
                                                {{ $client->subsidiary->city }}/{{ $client->subsidiary->state }}.
                                            </div>
                                        @endisset
                                    </div>
                                </div>
                            @endforelse

                            @if ($histories->count() == 0 || !in_array('criado', $histories->pluck('action')->toArray()))
                                <div class="time-label">
                                    <span class="bg-info">{{ date('d/m/Y H:i', strtotime($client->created_at)) }}</span>
                                </div>
                                <div>
                                    <i class="fas fa-user-plus bg-purple"></i>
                                    <div class="timeline-item col-12 col-md-8" style="max-width: 80%">
                                        <h3 class="timeline-header no-border">
                                            Cliente <a href="{{ route('admin.clients.show', ['client' => $client->id]) }}"
                                                target="_blank">{{ $client->name }}</a> criado.</h3>
                                    </div>
                                </div>
                            @endif
                            <div>
                                <i class="fas fa-clock bg-gray"></i>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </section>
    @endsection
