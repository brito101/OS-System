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
                        <canvas id="finance-chart" style="display: block; width: 489px; height: 200px;"
                            class="chartjs-render-monitor" width="800" height="200"></canvas>
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

                        <div class="card-body p-0">
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

                        <div class="card-body p-0">
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

                        <div class="card-body p-0">
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

                        <div class="card-body p-0">
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
