@extends('adminlte::page')

@section('title', '- Dashboard')
@section('plugins.Chartjs', true)

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fa fa-fw fa-digital-tachograph"></i> Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content px-0">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-fw fa-piggy-bank"></i> Grupo GAB - Dados Bancários</h3>
            </div>
            <div class="card-body d-flex flex-wrap justify-content-center justify-content-md-start">
                {{-- ES Account --}}
                <div class="px-0 pr-md-2">
                    <x-adminlte-modal id="es1-account" title="Conta ES (Cora)" theme="success" icon="fas fa-piggy-bank"
                        size='lg'>
                        <h3>Conta ES</h3>
                        <p><b>Banco Cora (403)</b></p>
                        <p><b>Agência:</b> 0001</p>
                        <p><b>Conta Corrente:</b> 3624814-6</p>
                        <p><b>Chave Pix:</b> <span class="pix-account" style="cursor: copy">contacora@grupogab.com.br</span>
                        </p>
                        <x-slot name="footerSlot">
                            <x-adminlte-button theme="danger" label="Fechar" data-dismiss="modal" />
                        </x-slot>
                    </x-adminlte-modal>
                    <x-adminlte-button label="Conta ES (Cora)" data-toggle="modal" data-target="#es1-account"
                        class="bg-success" />
                </div>
                {{-- RJ Account --}}
                <div class="px-0 px-md-2">
                    <x-adminlte-modal id="rj1-account" title="Conta RJ (Cora)" theme="success" icon="fas fa-piggy-bank"
                        size='lg'>
                        <h3>Conta RJ</h3>
                        <p><b>Banco Cora (403)</b></p>
                        <p><b>Agência:</b> 0001</p>
                        <p><b>Conta Corrente:</b> 3082669-0</p>
                        <p><b>Chave Pix:</b> <span class="pix-account" style="cursor: copy">coraggff@grupogab.com.br</span>
                        </p>
                        <x-slot name="footerSlot">
                            <x-adminlte-button theme="danger" label="Fechar" data-dismiss="modal" />
                        </x-slot>
                    </x-adminlte-modal>
                    <x-adminlte-button label="Conta RJ (Cora)" data-toggle="modal" data-target="#rj1-account"
                        class="bg-success" />
                </div>
                {{-- RJ Account --}}
                <div class="px-0 pl-md-2">
                    <x-adminlte-modal id="rj2-account" title="Conta RJ (Bradesco)" theme="success" icon="fas fa-piggy-bank"
                        size='lg'>
                        <h3>Conta RJ</h3>
                        <p><b>Banco Bradesco</b></p>
                        <p><b>Agência:</b> 6738</p>
                        <p><b>Conta Corrente:</b> 4821-6</p>
                        <p><b>Chave Pix:</b> <span class="pix-account" style="cursor: copy">22.341.172/0001-61 </span></p>
                        <x-slot name="footerSlot">
                            <x-adminlte-button theme="danger" label="Fechar" data-dismiss="modal" />
                        </x-slot>
                    </x-adminlte-modal>
                    <x-adminlte-button label="Conta RJ (Bradesco)" data-toggle="modal" data-target="#rj2-account"
                        class="bg-success" />
                </div>
            </div>
        </div>
    </section>

    @can('Listar Eventos na Agenda')
        <section class="content px-0">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-fw fa-calendar"></i> Agenda do Dia</h3>
                </div>
                <div class="card-body d-flex flex-wrap justify-content-start px-0 pb-0">
                    @forelse ($schedules as $schedule)
                        <div class="col-6 col-md-3 p-2">
                            <a href="{{ route('admin.schedule.show', ['schedule' => $schedule->id]) }}"
                                class="btn bg-{{ $schedule->color }} w-100 text-left"
                                title="Evento na Agenda: {{ $schedule->title }}"><i class="fas fa-calendar"></i>
                                {{ Str::limit($schedule->title, 15) }}</i>
                            </a>
                        </div>
                    @empty
                        <p class="px-3">Não há agendamento de eventos para o dia</p>
                    @endforelse
                </div>
            </div>
        </section>
    @endcan

    <section class="content">
        <div class="container-fluid">

            @if (Auth::user()->hasRole('Programador|Administrador'))
                @include('admin.home.components.default')
            @endif

            @if (Auth::user()->hasRole('Gerente'))
                @include('admin.home.components.manager')
            @endif

            @if (Auth::user()->hasRole('Financeiro'))
                @include('admin.home.components.financier')
            @endif

            @if (Auth::user()->hasRole('Colaborador|Colaborador-NI'))
                @include('admin.home.components.colaborator')
            @endif

            @if (Auth::user()->hasRole('Estoquista'))
                @include('admin.home.components.stock')
            @endif

            @if (Auth::user()->hasRole('Colaborador Comercial'))
                @include('admin.home.components.commercial-colaborator')
            @endif

            @if (Auth::user()->hasRole('Leiturista'))
                @include('admin.home.components.reader')
            @endif

            @if (Auth::user()->hasRole('Manutenção de Bomba'))
                @include('admin.home.components.maintenance')
            @endif

        </div>
    </section>
@endsection

@section('custom_js')
    <script>
        $(".pix-account").on("click", function(e) {
            navigator.clipboard.writeText(e.target.textContent);
            alert("Pix copiado: " + e.target.textContent);
        });
    </script>

    {{-- Clients --}}
    @if (Auth::user()->hasRole('Programador|Administrador|Gerente|Colaborador|Colaborador-NI|Colaborador Comercial'))
        <script>
            const clientsSubsidiary = document.getElementById('clients-subsidiary-chart');
            if (clientsSubsidiary) {
                clientsSubsidiary.getContext('2d');
                const clientsSubsidiaryChart = new Chart(clientsSubsidiary, {
                    type: 'doughnut',
                    data: {
                        labels: {!! json_encode($clientsSubsidiaryChart['label']) !!},
                        datasets: [{
                            label: 'Clientes',
                            data: {!! json_encode($clientsSubsidiaryChart['data']) !!},
                            borderWidth: 1,
                            backgroundColor: [
                                'rgba(0, 63, 92, 0.5)',
                                'rgba(47, 75, 124, 0.5)',
                                'rgba(102, 81, 145, 0.5)',
                                'rgba(160, 81, 149, 0.5)',
                                'rgba(212, 80, 135, 0.5)',
                                'rgba(249, 93, 106, 0.5)',
                                'rgba(255, 124, 67, 0.5)',
                                'rgba(255, 166, 0, 0.5)'
                            ],
                            borderColor: [
                                'rgba(0, 63, 92)',
                                'rgb(47, 75, 124)',
                                'rgb(102, 81, 145)',
                                'rgb(160, 81, 149)',
                                'rgb(212, 80, 135)',
                                'rgb(249, 93, 106)',
                                'rgb(255, 124, 67)',
                                'rgb(255, 166, 0)'
                            ],
                        }]
                    },
                    options: {
                        responsive: true,
                        legend: {
                            position: 'left',
                        },
                    },
                });
            }

            const clientsStatus = document.getElementById('clients-status-chart');
            if (clientsStatus) {
                clientsStatus.getContext('2d');
                const clientsStatusChart = new Chart(clientsStatus, {
                    type: 'doughnut',
                    data: {
                        labels: {!! json_encode($clientsStatusChart['label']) !!},
                        datasets: [{
                            label: 'Clientes',
                            data: {!! json_encode($clientsStatusChart['data']) !!},
                            borderWidth: 1,
                            backgroundColor: [
                                'rgba(0, 63, 92, 0.5)',
                                'rgba(47, 75, 124, 0.5)',
                                'rgba(102, 81, 145, 0.5)',
                                'rgba(160, 81, 149, 0.5)',
                                'rgba(212, 80, 135, 0.5)',
                                'rgba(249, 93, 106, 0.5)',
                                'rgba(255, 124, 67, 0.5)',
                                'rgba(255, 166, 0, 0.5)',
                                'rgba(188, 245, 28, 0.5)',
                                'rgba(28, 245, 154, 0.5)',
                                'rgba(28, 167, 245, 0.5)',
                                'rgba(123, 28, 245, 0.5)',
                            ],
                            borderColor: [
                                'rgba(0, 63, 92)',
                                'rgb(47, 75, 124)',
                                'rgb(102, 81, 145)',
                                'rgb(160, 81, 149)',
                                'rgb(212, 80, 135)',
                                'rgb(249, 93, 106)',
                                'rgb(255, 124, 67)',
                                'rgb(255, 166, 0)',
                                'rgb(188, 245, 28)',
                                'rgb(28, 245, 154)',
                                'rgb(28, 167, 245)',
                                'rgb(123, 28, 245)',
                            ],
                        }]
                    },
                    options: {
                        responsive: true,
                        legend: {
                            position: 'left',
                        },
                    },
                });
            }
        </script>
    @endif
    {{-- Service Orders --}}
    @if (Auth::user()->hasRole(
            'Programador|Administrador|Gerente|Colaborador|Colaborador-NI|Colaborador Comercial|Leiturista|Manutenção de Bomba'))
        <script>
            const serviceOrdersPriority = document.getElementById('service-orders-priority-chart');
            if (serviceOrdersPriority) {
                const serviceOrdersPriorityChart = new Chart(serviceOrdersPriority, {
                    type: 'bar',
                    data: {
                        labels: ({!! json_encode($serviceOrdersPriorityChart['label']) !!}),
                        datasets: [{
                            label: 'Somente OS não iniciadas',
                            data: {!! json_encode($serviceOrdersPriorityChart['data']) !!},
                            backgroundColor: [
                                'rgba(0, 63, 92, 0.5)',
                                'rgba(47, 75, 124, 0.5)',
                                'rgba(102, 81, 145, 0.5)',
                                'rgba(160, 81, 149, 0.5)',
                                'rgba(212, 80, 135, 0.5)',
                                'rgba(249, 93, 106, 0.5)',
                                'rgba(255, 124, 67, 0.5)',
                                'rgba(255, 166, 0, 0.5)'
                            ],
                            borderColor: [
                                'rgba(0, 63, 92)',
                                'rgb(47, 75, 124)',
                                'rgb(102, 81, 145)',
                                'rgb(160, 81, 149)',
                                'rgb(212, 80, 135)',
                                'rgb(249, 93, 106)',
                                'rgb(255, 124, 67)',
                                'rgb(255, 166, 0)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }],
                            xAxes: [{
                                barThickness: 50,
                                maxBarThickness: 50
                            }]
                        },
                        legend: {
                            labels: {
                                boxWidth: 0,
                            }
                        },
                    },
                });
            }
        </script>
    @endif
    {{-- Finance --}}
    @if (Auth::user()->hasRole('Programador|Administrador|Gerente|Financeiro'))
        <script>
            const finance = document.getElementById('finance-chart');
            if (finance) {
                finance.getContext('2d');
                const financeChart = new Chart(finance, {
                    type: 'line',
                    data: {
                        labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
                        datasets: [{
                                label: 'Receitas Recebidas',
                                data: {!! json_encode($financeIncomesChart) !!},
                                borderWidth: 2,
                                fill: false,
                                borderColor: 'green',
                                pointStyle: 'circle',
                            },
                            {
                                label: 'Despesas Pendentes',
                                data: {!! json_encode($financeExpensesChart) !!},
                                borderWidth: 2,
                                fill: false,
                                borderColor: 'red',
                                pointStyle: 'rect',
                            },
                            {
                                label: 'Reembolsos Pendentes',
                                data: {!! json_encode($financeRefundsChart) !!},
                                borderWidth: 2,
                                fill: false,
                                borderColor: 'orange',
                                pointStyle: 'cross',
                            }

                        ]
                    },
                    options: {
                        tooltips: {
                            callbacks: {
                                label: function(tooltipItem, data) {
                                    return tooltipItem.yLabel.toLocaleString("pt-BR", {
                                        style: "currency",
                                        currency: "BRL"
                                    });
                                }
                            }
                        },
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                    callback: function(value, index, values) {
                                        return value.toLocaleString("pt-BR", {
                                            style: "currency",
                                            currency: "BRL"
                                        });
                                    }
                                }
                            }]
                        }
                    },
                });
            }
        </script>
    @endif
    {{-- Visitors --}}
    @if (Auth::user()->hasRole('Programador|Administrador'))
        <script>
            const ctx = document.getElementById('visitors-chart');
            if (ctx) {
                ctx.getContext('2d');
                const myChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: ({!! json_encode($chart->labels) !!}),
                        datasets: [{
                            label: 'Acessos por horário',
                            data: {!! json_encode($chart->dataset) !!},
                            borderWidth: 1,
                            borderColor: '#007bff',
                            backgroundColor: 'transparent'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        },
                        legend: {
                            labels: {
                                boxWidth: 0,
                            }
                        },
                    },
                });

                let getData = function() {

                    $.ajax({
                        url: "{{ route('admin.home.chart') }}",
                        type: "GET",
                        success: function(data) {
                            myChart.data.labels = data.chart.labels;
                            myChart.data.datasets[0].data = data.chart.dataset;
                            myChart.update();
                            $("#onlineusers").text(data.onlineUsers);
                            $("#accessdaily").text(data.access);
                            $("#percentvalue").text(data.percent);
                            const percentclass = $("#percentclass");
                            const percenticon = $("#percenticon");
                            percentclass.removeClass('text-success');
                            percentclass.removeClass('text-danger');
                            percenticon.removeClass('fa-arrow-up');
                            percenticon.removeClass('fa-arrow-down');
                            if (parseInt(data.percent) > 0) {
                                percentclass.addClass('text-success');
                                percenticon.addClass('fa-arrow-up');
                            } else {
                                percentclass.addClass('text-danger');
                                percenticon.addClass('fa-arrow-down');
                            }
                        }
                    });
                };
                setInterval(getData, 10000);
            }
        </script>
    @endif
@endsection
