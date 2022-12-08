@component('mail::message')
    # Novo Evento na agenda

    Evento: {{ $title }}

    Descrição: {{ $description }}

    Início: {{ $start }}

    Término: {{ $end }}

    Autor: {{ $user }}

    * Esse e-mail é enviado automaticamente através do sistema!

    Obrigado,
    {{ config('app.name') }}
@endcomponent
