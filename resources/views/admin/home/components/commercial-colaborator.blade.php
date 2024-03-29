{{-- Clients --}}
<div class="row">
    <div class="card col-12">
        <div class="card-header">
            Clientes
        </div>
        <div class="card-body px-0 pb-0 d-flex flex-wrap justify-content-center">
            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="card-header border-0">
                        <p class="mb-0">Por Filiais</p>
                    </div>
                    <div class="cardy-body py-2">
                        <div class="chart-responsive">
                            <div class="chartjs-size-monitor">
                                <div class="chartjs-size-monitor-expand">
                                    <div class=""></div>
                                </div>
                                <div class="chartjs-size-monitor-shrink">
                                    <div class=""></div>
                                </div>
                            </div>
                            <canvas id="clients-subsidiary-chart" style="display: block; width: 203px; height: 100px;"
                                class="chartjs-render-monitor" width="203" height="100"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="card-header border-0">
                        <p class="mb-0">Por Status</p>
                    </div>
                    <div class="cardy-body py-2">
                        <div class="chart-responsive">
                            <div class="chartjs-size-monitor">
                                <div class="chartjs-size-monitor-expand">
                                    <div class=""></div>
                                </div>
                                <div class="chartjs-size-monitor-shrink">
                                    <div class=""></div>
                                </div>
                            </div>
                            <canvas id="clients-status-chart" style="display: block; width: 203px; height: 100px;"
                                class="chartjs-render-monitor" width="203" height="100"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- Service Order --}}
<div class="row">
    <div class="card col-12">
        <div class="card-header">
            Ordens de Serviço
        </div>
        <div class="card-body px-0 pb-0 d-flex flex-wrap justify-content-center">
            <div class="col-12 col-md-4">
                <div class="info-box mb-3 bg-gradient-lightblue">
                    <span class="info-box-icon"><i class="fas fa-list"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Ordens de Serviço</span>
                        <span class="info-box-number">{{ $serviceOrders->count() }}</span>
                    </div>
                </div>
                <div class="info-box mb-3 bg-gradient-danger">
                    <span class="info-box-icon"><i class="fas fa-exclamation-triangle"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Não Iniciadas</span>
                        <span class="info-box-number">{{ $serviceOrdersNotStarted }}</span>
                    </div>
                </div>
                <div class="info-box mb-3 bg-gradient-light">
                    <span class="info-box-icon"><i class="fas fa-clock"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Aguardando Orçamento</span>
                        <span class="info-box-number">{{ $serviceOrderHoldingBudget }}</span>
                    </div>
                </div>
                <div class="info-box mb-3 bg-gradient-teal">
                    <span class="info-box-icon"><i class="fas fa-crosshairs"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Orçamento Enviado</span>
                        <span class="info-box-number">{{ $serviceOrderBudgetSend }}</span>
                    </div>
                </div>
                <div class="info-box mb-3 bg-gradient-info">
                    <span class="info-box-icon"><i class="fas fa-clock"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Aguardando Laudo</span>
                        <span class="info-box-number">{{ $serviceOrderAwaitingReport }}</span>
                    </div>
                </div>
                <div class="info-box mb-3 bg-gradient-indigo">
                    <span class="info-box-icon"><i class="fas fa-arrow-alt-circle-right"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Laudo Enviado</span>
                        <span class="info-box-number">{{ $serviceOrderReportSend }}</span>
                    </div>
                </div>
                <div class="info-box mb-3 bg-gradient-warning">
                    <span class="info-box-icon"><i class="fas fa-bullhorn"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Atrasadas</span>
                        <span class="info-box-number">{{ $serviceOrdersLate }}</span>
                    </div>
                </div>
                <div class="info-box mb-3 bg-gradient-primary">
                    <span class="info-box-icon"><i class="fas fa-walking"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Em Andamento</span>
                        <span class="info-box-number">{{ $serviceOrdersStarted }}</span>
                    </div>
                </div>
                <div class="info-box mb-3 bg-gradient-success">
                    <span class="info-box-icon"><i class="fas fa-check"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Concluídas</span>
                        <span class="info-box-number">{{ $serviceOrdersConcluded }}</span>
                    </div>
                </div>
                <div class="info-box mb-3 bg-gradient-lime">
                    <span class="info-box-icon"><i class="fas fa-check-double"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Concluídas com envio de Proposta</span>
                        <span class="info-box-number">{{ $serviceOrdersConcludedProposal }}</span>
                    </div>
                </div>
                <div class="info-box mb-3 bg-gradient-dark">
                    <span class="info-box-icon"><i class="fas fa-trash"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Canceladas</span>
                        <span class="info-box-number">{{ $serviceOrdersCanceled }}</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-8">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title">Prioridades</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="position-relative mb-4">
                            <div class="chartjs-size-monitor" z>
                                <div class="chartjs-size-monitor-expand">
                                    <div class=""></div>
                                </div>
                                <div class="chartjs-size-monitor-shrink">
                                    <div class=""></div>
                                </div>
                            </div>
                            <canvas id="service-orders-priority-chart"
                                style="display: block; width: 489px; height: 478px;" class="chartjs-render-monitor"
                                width="489" height="478"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
