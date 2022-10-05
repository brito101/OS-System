@component('mail::message')
    # Nova Ordem de Compra

    Autor: {{ $name }} - {{ $email }}

    Número de série: {{ $number_series }}

    Obra: {{ $job }}

    Filial: {{ $subsidiary }}

    * Esse e-mail é enviado automaticamente através do sistema!

    Obrigado,
    {{ config('app.name') }}
@endcomponent
