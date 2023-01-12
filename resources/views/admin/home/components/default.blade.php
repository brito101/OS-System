{{-- Users --}}
<div class="row">
    <div class="card col-12">
        <div class="card-header">
            Usuários
        </div>
        <div class="card-body px-0 pb-0 d-flex flex-wrap justify-content-center">
            <div class="col-12 col-sm-6 col-md-4">
                <div class="info-box">
                    <span class="info-box-icon bg-gradient-dark elevation-1"><i class="fas fa-code"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Programadores</span>
                        <span class="info-box-number">{{ $programmers }}</span>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-4">
                <div class="info-box">
                    <span class="info-box-icon bg-gradient-danger elevation-1"><i class="fas fa-user-shield"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Administradores</span>
                        <span class="info-box-number">{{ $administrators }}</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-gradient-primary elevation-1"><i
                            class="fas fa-user-friends"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Gerentes</span>
                        <span class="info-box-number">{{ $managers }}</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-gradient-cyan elevation-1"><i class="fas fa-users-cog"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Colaboradores</span>
                        <span class="info-box-number">{{ $collaborators }}</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-gradient-green elevation-1"><i
                            class="fas fa-fw fa-money-bill"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Financistas</span>
                        <span class="info-box-number">{{ $financiers }}</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-gradient-indigo elevation-1"><i class="fas fa-fw fa-box"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Estoquistas</span>
                        <span class="info-box-number">{{ $stockists }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- Company --}}
<div class="row">
    <div class="card col-12">
        <div class="card-header">
            Empresa
        </div>
        <div class="card-body px-0 pb-0 d-flex flex-wrap justify-content-center">
            <div class="col-12 col-md-4">
                <div class="small-box bg-gradient-gray">
                    <div class="inner">
                        <h3>{{ $subsidiariesList->count() }}</h3>
                        <p>Filiais</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <a href="{{ route('admin.subsidiaries.index') }}" class="small-box-footer">Visualizar <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="small-box bg-gradient-warning">
                    <div class="inner">
                        <h3>{{ $providers }}</h3>
                        <p>Fornecedores</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-truck"></i>
                    </div>
                    <a href="{{ route('admin.providers.index') }}" class="small-box-footer">Visualizar <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="small-box bg-gradient-success">
                    <div class="inner">
                        <h3>{{ $clients->count() }}</h3>
                        <p>Clientes</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-user-plus"></i>
                    </div>
                    <a href="{{ route('admin.clients.index') }}" class="small-box-footer">Visualizar <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
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
                <div class="info-box mb-3 bg-gradient-light">
                    <span class="info-box-icon"><i class="fas fa-clock"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Aguardando Orçamento</span>
                        <span class="info-box-number">{{ $serviceOrderHoldingBudget }}</span>
                    </div>
                </div>
                <div class="info-box mb-3 bg-gradient-info">
                    <span class="info-box-icon"><i class="fas fa-clock"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Aguardando Laudo</span>
                        <span class="info-box-number">{{ $serviceOrderAwaitingReport }}</span>
                    </div>
                </div>
                <div class="info-box mb-3 bg-gradient-danger">
                    <span class="info-box-icon"><i class="fas fa-exclamation-triangle"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Não Iniciadas</span>
                        <span class="info-box-number">{{ $serviceOrdersNotStarted }}</span>
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
                    <span class="info-box-icon"><i class="fas fa-clock"></i></span>
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
{{-- Finance --}}
<div class="row">
    <div class="card col-12">
        <div class="card-header">
            Financeiro: {{ date('Y') }}
        </div>
        <div class="card-body px-0 pb-0 d-flex flex-wrap justify-content-center">
            <div class="card col-12">
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
                        <canvas id="finance-chart" style="display: block; width: 489px; height: 300px;"
                            class="chartjs-render-monitor" width="489" height="300"></canvas>
                    </div>
                </div>
            </div>

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
                        <span class="info-box-icon bg-gradient-danger elevation-1"><i
                                class="fas fa-fw fa-cart-plus"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">O. de Compra Pendentes</span>
                            <span class="info-box-number">{{ $unexec_purchases }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 d-flex flex-wrap justify-content-between px-0">
                <div class="col-12 col-md-4">
                    <div class="card">
                        <div class="card-header border-transparent">
                            <h3 class="card-title">Receitas a Receber</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-body p-0" style="max-height: 300px; overflow-y: auto;">
                            <div class="table-responsive">
                                <table class="table m-0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Descrição</th>
                                            <th>Vencimento</th>
                                            <th>Valor</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($invoices->where('type', 'receita')->where('status', 'pendente') as $income)
                                            <tr>
                                                <td><a
                                                        href="{{ route('admin.finance-incomes.show', ['finance_income' => $income->id]) }}">{{ $income->id }}</a>
                                                </td>
                                                <td>{{ $income->description }}</td>
                                                <td>{{ $income->due_date }}</td>
                                                <td>{{ $income->value }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4">Sem receitas a receber</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                        </div>

                        <div class="card-footer clearfix">
                            <a href="{{ route('admin.finance-incomes.create') }}"
                                class="btn btn-sm btn-info float-left">Nova Receita</a>
                            <a href="{{ route('admin.finance-incomes.index') }}"
                                class="btn btn-sm btn-secondary
                            float-right">Listagem</a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="card">
                        <div class="card-header border-transparent">
                            <h3 class="card-title">Despesas a Pagar</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-body p-0" style="max-height: 300px; overflow-y: auto;">
                            <div class="table-responsive">
                                <table class="table m-0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Descrição</th>
                                            <th>Vencimento</th>
                                            <th>Valor</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($invoices->where('type', 'despesa')->where('status', 'pendente') as $expense)
                                            <tr>
                                                <td><a
                                                        href="{{ route('admin.finance-expenses.show', ['finance_expense' => $expense->id]) }}">{{ $expense->id }}</a>
                                                </td>
                                                <td>{{ $expense->description }}</td>
                                                <td>{{ $expense->due_date }}</td>
                                                <td>{{ $expense->value }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4">Sem despesas a pagar</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                        </div>

                        <div class="card-footer clearfix">
                            <a href="{{ route('admin.finance-expenses.create') }}"
                                class="btn btn-sm btn-info float-left">Nova Despesa</a>
                            <a href="{{ route('admin.finance-expenses.index') }}"
                                class="btn btn-sm btn-secondary
                            float-right">Listagem</a>
                        </div>

                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="card">
                        <div class="card-header border-transparent">
                            <h3 class="card-title">Reembolsos Pendentes</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-body p-0" style="max-height: 300px; overflow-y: auto;">
                            <div class="table-responsive">
                                <table class="table m-0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Descrição</th>
                                            <th>Vencimento</th>
                                            <th>Valor</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($invoices->where('type', 'reembolso')->where('status', 'pendente') as $refound)
                                            <tr>
                                                <td><a
                                                        href="{{ route('admin.finance-refunds.show', ['finance_refund' => $refound->id]) }}">{{ $refound->id }}</a>
                                                </td>
                                                <td>{{ $refound->description }}</td>
                                                <td>{{ $refound->due_date }}</td>
                                                <td>{{ $refound->value }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4">Sem reembolsos a pagar</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                        </div>

                        <div class="card-footer clearfix">
                            <a href="{{ route('admin.finance-refunds.create') }}"
                                class="btn btn-sm btn-info float-left">Novo Reembolso</a>
                            <a href="{{ route('admin.finance-refunds.index') }}"
                                class="btn btn-sm btn-secondary
                            float-right">Listagem</a>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-transparent">
                            <h3 class="card-title">Ordens de Compra a Executar</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-body p-0" style="max-height: 300px; overflow-y: auto;">
                            <div class="table-responsive">
                                <table class="table m-0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>NS</th>
                                            <th>Data</th>
                                            <th>Obra</th>
                                            <th>Solicitante</th>
                                            <th>Entrega</th>
                                            <th>Valor</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($purchases as $purchase)
                                            <tr>
                                                <td><a
                                                        href="{{ route('admin.finance-purchase-orders.show', ['finance_purchase_order' => $purchase->id]) }}">{{ $purchase->id }}</a>
                                                </td>
                                                <td>{{ $purchase->number_series }}</td>
                                                <td>{{ $purchase->date }}</td>
                                                <td>{{ $purchase->job }}</td>
                                                <td>{{ $purchase->requester }}</td>
                                                <td>{{ $purchase->forecast }}</td>
                                                <td>{{ $purchase->value }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7">Sem ordens de compra a executar</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                        </div>

                        <div class="card-footer clearfix">
                            <a href="{{ route('admin.finance-purchase-orders.create') }}"
                                class="btn btn-sm btn-info float-left">Nova Ordem de Compra</a>
                            <a href="{{ route('admin.finance-purchase-orders.index') }}"
                                class="btn btn-sm btn-secondary
                            float-right">Listagem</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- Commissions --}}
<div class="row">
    <div class="card col-12">
        <div class="card-header">
            Comissões
        </div>
        <div class="card-body px-0 pb-0 d-flex flex-wrap justify-content-center">
            <div class="col-12 d-flex flex-wrap justify-content-between px-0">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-transparent">
                            <h3 class="card-title">Comissões Pendentes</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-body p-0" style="max-height: 300px; overflow-y: auto;">
                            <div class="table-responsive">
                                <table class="table m-0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Vendedor</th>
                                            <th>Produto</th>
                                            <th>Obra</th>
                                            <th>Vencimento</th>
                                            <th>Valor Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($commissions as $commission)
                                            <tr>
                                                <td><a
                                                        href="{{ route('admin.commissions.show', ['commission' => $commission->id]) }}">{{ $commission->id }}</a>
                                                </td>
                                                <td>{{ $commission->seller }}</td>
                                                <td>{{ $commission->product }}</td>
                                                <td>{{ $commission->job }}</td>
                                                <td>{{ $commission->due_date }}</td>
                                                <td>{{ $commission->total_value }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6">Sem comissões pendentes</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                        </div>

                        <div class="card-footer clearfix">
                            <a href="{{ route('admin.commissions.create') }}"
                                class="btn btn-sm btn-info float-left">Nova Comissão</a>
                            <a href="{{ route('admin.commissions.index') }}"
                                class="btn btn-sm btn-secondary
                                float-right">Listagem</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- Inventory --}}
<div class="row">
    <div class="card col-12">
        <div class="card-header">
            Estoque Consolidado {{ date('Y') }}
        </div>
        <div class="card-body" style="max-height: 300px; overflow-y: auto;">
            <div class="table-responsive-lg">
                <table class="table table-bordered table-hover table-striped">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">Produto</th>
                            <th scope="col">Jan</th>
                            <th scope="col">Fev</th>
                            <th scope="col">Mar</th>
                            <th scope="col">Abr</th>
                            <th scope="col">Mai</th>
                            <th scope="col">Jun</th>
                            <th scope="col">Jul</th>
                            <th scope="col">Ago</th>
                            <th scope="col">Set</th>
                            <th scope="col">Out</th>
                            <th scope="col">Nov</th>
                            <th scope="col">Dez</th>
                        </tr>

                    </thead>
                    <tbody>
                        @foreach ($stocks as $product)
                            <tr>
                                <th scope="row">{{ $product['product'] }}</th>
                                @foreach ($product['months'] as $month)
                                    <td>{{ $month }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
{{-- Online Users --}}
<div class="row">
    <div class="col-12 px-0">
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
                    <canvas id="visitors-chart" style="display: block; width: 489px; height: 300px;"
                        class="chartjs-render-monitor" width="489" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

</div>
