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
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                @if (Auth::user()->hasRole('Programador|Administrador'))
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-gradient-danger elevation-1"><i
                                    class="fas fa-user-shield"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Administradores</span>
                                <span class="info-box-number">{{ $administrators }}</span>
                            </div>
                        </div>
                    </div>
                @endif

                @if (Auth::user()->hasRole('Programador|Administrador|Gerente'))
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-gradient-gray elevation-1"><i class="fas fa-building"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Filiais</span>
                                <span class="info-box-number">{{ $subsidiariesList }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-gradient-primary elevation-1"><i
                                    class="fas fa-user-friends"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Gerentes</span>
                                <span class="info-box-number">{{ $managers }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-gradient-cyan elevation-1"><i class="fas fa-users-cog"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Colaboradores</span>
                                <span class="info-box-number">{{ $collaborators }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-gradient-green elevation-1"><i
                                    class="fas fa-fw fa-money-bill"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Financistas</span>
                                <span class="info-box-number">{{ $financiers }}</span>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-gradient-teal elevation-1"><i class="fas fa-user-plus"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Clientes</span>
                            <span class="info-box-number">{{ $clients }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-gradient-warning elevation-1"><i class="fas fa-truck"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Fornecedores</span>
                            <span class="info-box-number">{{ $providers }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-gradient-light elevation-1"><i class="fas fa-fw fa-list"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Ordens de Serviço</span>
                            <span class="info-box-number">{{ $service_orders }}</span>
                        </div>
                    </div>
                </div>

                @if (Auth::user()->hasRole('Programador|Administrador|Gerente|Financeiro'))
                    <div class="col-12 d-flex flex-wrap px-0">
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-gradient-lime elevation-1"><i
                                        class="fas fa-fw fa-plus"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Receitas pagas</span>
                                    <span class="info-box-number">{{ $paid_incomes }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-gradient-danger elevation-1"><i
                                        class="fas fa-fw fa-plus"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Receitas pendentes</span>
                                    <span class="info-box-number">{{ $unpaid_incomes }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-gradient-lime elevation-1"><i
                                        class="fas fa-fw fa-minus"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Despesas Pagas</span>
                                    <span class="info-box-number">{{ $paid_expenses }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-gradient-danger elevation-1"><i
                                        class="fas fa-fw fa-minus"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Despesas Pendentes</span>
                                    <span class="info-box-number">{{ $unpaid_expenses }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-gradient-lime elevation-1"><i
                                        class="fas fa-fw fa-sync"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Reembolsos Pagos</span>
                                    <span class="info-box-number">{{ $paid_refunds }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-gradient-danger elevation-1"><i
                                        class="fas fa-fw fa-sync"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Reembolsos Pendentes</span>
                                    <span class="info-box-number">{{ $unpaid_refunds }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-gradient-lime elevation-1"><i
                                        class="fas fa-fw fa-cart-plus"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">O. de Compra Executadas</span>
                                    <span class="info-box-number">{{ $exec_purchases }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-gradient-lime elevation-1"><i
                                        class="fas fa-fw fa-cart-plus"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">O. de Compra Pendentes</span>
                                    <span class="info-box-number">{{ $unexec_purchases }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

            </div>


            <div class="row px-0">

                <div class="col-12 col-lg-6">
                    <div class="card">
                        <div class="card-header border-0">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title">Usuários Online: <span id="onlineusers">{{ $onlineUsers }}</span>
                                </h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex">
                                <p class="d-flex flex-column">
                                    <span class="text-bold text-lg" id="accessdaily">{{ $access }}</span>
                                    <span>Acessos Diários</span>
                                </p>
                                <p class="ml-auto d-flex flex-column text-right">
                                    <span id="percentclass" class="{{ $percent > 0 ? 'text-success' : 'text-danger' }}">
                                        <i id="percenticon"
                                            class="fas {{ $percent > 0 ? 'fa-arrow-up' : 'fa-arrow-down' }}  mr-1"></i><span
                                            id="percentvalue">{{ $percent }}</span>%
                                    </span>
                                    <span class="text-muted">em relação ao dia anterior</span>
                                </p>
                            </div>

                            <div class="position-relative mb-4">
                                <div class="chartjs-size-monitor" z>
                                    <div class="chartjs-size-monitor-expand">
                                        <div class=""></div>
                                    </div>
                                    <div class="chartjs-size-monitor-shrink">
                                        <div class=""></div>
                                    </div>
                                </div>
                                <canvas id="visitors-chart" style="display: block; width: 489px; height: 200px;"
                                    class="chartjs-render-monitor" width="489" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


        </div>
    </section>
@endsection

@section('custom_js')
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
@endsection
