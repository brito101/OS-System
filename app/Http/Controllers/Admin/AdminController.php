<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Collaborator;
use App\Models\Commission;
use App\Models\Financier;
use App\Models\Guest;
use App\Models\Inventory;
use App\Models\Invoice;
use App\Models\Manager;
use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\Schedule;
use App\Models\Seller;
use App\Models\Subsidiary as ModelsSubsidiary;
use App\Models\User;
use App\Models\Views\Client;
use App\Models\Views\FinanceExpense;
use App\Models\Views\FinanceIncome;
use App\Models\Views\FinanceRefund;
use App\Models\Views\Provider;
use App\Models\Views\ServiceOrder;
use App\Models\Views\Subsidiary;
use App\Models\Views\User as ViewsUser;
use App\Models\Views\Visit;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        $role = Auth::user()->roles->first()->name;

        switch ($role) {
            case 'Gerente':
                /** Company */
                $managers = Auth::user()->managers->pluck('subsidiary_id');
                $subsidiariesList = ModelsSubsidiary::whereIn('id', $managers)->get();
                $states = array_unique($subsidiariesList->pluck('state')->toArray());
                sort($states);
                $statesSearch = implode(',', $states);
                $providers = Provider::where('coverage', 'like', '%' . $statesSearch . '%')->orWhere('coverage', null)->count();
                $clients = Client::select('alias_name', 'trade_status')->where('trade_status', '!=', 'Restrito')->whereIn('subsidiary_id', $managers)->orWhere('subsidiary_id', null)->get();
                /** Users */
                $users = ViewsUser::all('type');
                $programmers = 0;
                $administrators = 0;
                $managers = Manager::whereIn('subsidiary_id',  $subsidiariesList->pluck('id'))->count();
                $financiers = Financier::whereIn('subsidiary_id', $subsidiariesList->pluck('id'))->count();
                $collaborators = Collaborator::whereIn('subsidiary_id', $subsidiariesList->pluck('id'))->count();
                $stockists = $users->where('type', 'Estoquista')->count();
                /** Clients */
                $clientsSubsidiary = $clients->groupBy('alias_name')->toArray();
                $clientsSubsidiaryChart = [];
                foreach ($clientsSubsidiary as $key => $value) {
                    if ($key == '') {
                        $key = 'Sem filial';
                    }
                    $clientsSubsidiaryChart['label'][] = $key;
                    $clientsSubsidiaryChart['data'][] = count($value);
                }
                $clientsStatus = $clients->groupBy('trade_status')->toArray();
                $clientsStatusChart = [];
                foreach ($clientsStatus as $key => $value) {
                    $clientsStatusChart['label'][] = $key;
                    $clientsStatusChart['data'][] = count($value);
                }
                /** Service Orders */
                $serviceOrders = ServiceOrder::select('status', 'priority', 'subsidiary')
                    ->whereIn('subsidiary_id', $subsidiariesList->pluck('id'))
                    ->orWhere('user_id', Auth::user()->id)
                    ->orWhere('author_id', Auth::user()->id)->get();
                $serviceOrdersNotStarted = $serviceOrders->where('status', 'Não iniciado')->count();
                $serviceOrdersLate = $serviceOrders->where('status', 'Atrasado')->count();
                $serviceOrdersStarted = $serviceOrders->where('status', 'Iniciado')->count();
                $serviceOrdersConcluded = $serviceOrders->where('status', 'Concluído')->count();
                $serviceOrdersCanceled = $serviceOrders->where('status', 'Cancelado')->count();
                $serviceOrdersSubsidiary = $serviceOrders->groupBy('subsidiary')->toArray();
                $serviceOrdersPriority = $serviceOrders->where('status', 'Não iniciado')->groupBy('priority')->toArray();
                $serviceOrdersPriorityChart = [];
                foreach ($serviceOrdersPriority as $key => $value) {
                    $serviceOrdersPriorityChart['label'][] = $key;
                    $serviceOrdersPriorityChart['data'][] = count($value);
                }
                /** Finance */
                $invoices = Invoice::where(function ($query) use ($subsidiariesList) {
                    $query->whereIn('subsidiary_id', $subsidiariesList->pluck('id'))
                        ->orWhere('subsidiary_id', null);
                })->whereYear('due_date', date('Y'))
                    ->orderBy('due_date', 'desc')->get();
                $financeIncomesChart = [];
                $financeExpensesChart = [];
                $financeRefundsChart = [];
                for ($i = 1; $i <= 12; $i++) {
                    $incomesValue = 0;
                    $expensesValue = 0;
                    $refundsValue = 0;
                    foreach ($invoices as $val) {
                        $invoiceMonth = explode('/', $val->due_date);
                        $month = (int)$invoiceMonth[1];
                        $value = str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $val->value)));
                        if ($month == $i) {
                            if ($val->type == 'receita' && $val->status == 'pago') {
                                $incomesValue += $value;
                            }
                            if ($val->type == 'despesa' && $val->status == 'pendente') {
                                $expensesValue += $value;
                            }
                            if ($val->type == 'reembolso' && $val->status == 'pendente') {
                                $refundsValue += $value;
                            }
                        }
                    }
                    $financeIncomesChart[] = $incomesValue;
                    $financeExpensesChart[] = $expensesValue;
                    $financeRefundsChart[] = $refundsValue;
                }
                $paid_incomes = $invoices->where('status', 'pago')->where('type', 'receita')->count();
                $unpaid_incomes = $invoices->where('status', 'pendente')->where('type', 'receita')->count();
                $paid_expenses = $invoices->where('status', 'pago')->where('type', 'despesa')->count();
                $unpaid_expenses = $invoices->where('status', 'pendente')->where('type', 'despesa')->count();
                $paid_refunds = $invoices->where('status', 'pago')->where('type', 'reembolso')->count();
                $unpaid_refunds = $invoices->where('status', 'pendente')->where('type', 'reembolso')->count();
                $purchases = PurchaseOrder::whereIn('subsidiary_id', $subsidiariesList->pluck('id'))->whereYear('date', date('Y'))
                    ->orderBy('forecast', 'desc')->get();
                $exec_purchases = $purchases->where('status', 'executada')->count();
                $unexec_purchases = $purchases->where('status', 'não executada')->count();
                //Commissions
                $sellers = Seller::orderBy('name')->get();
                $commissions = Commission::where('status', 'pendente')->whereIn('subsidiary_id', $subsidiariesList->pluck('id'))->orderBy('due_date', 'desc')->get();
                //Inventory
                $products = Product::select('id', 'name')->orderBy('name')->get();
                $stocks = [];
                foreach ($products as $product) {
                    $items = [];
                    for ($i = 1; $i <= 12; $i++) {
                        $inventories = Inventory::select(DB::raw('sum(input - output) as total'))
                            ->where('product_id', $product->id)
                            ->whereMonth('day', $i)
                            ->whereYear('day', date('Y'))
                            ->first();

                        $items[$i] = $inventories->total ?? 0;
                    }
                    $stocks[] = [
                        'product' => $product->name,
                        'months' => $items
                    ];
                }
                // Schedule
                $guests = Guest::where('user_id', Auth::user()->id)->pluck('schedule_id');
                $schedules = Schedule::whereDate('start', '<=', date('Y-m-d'))
                    ->whereDate('end', '>=', date('Y-m-d'))
                    ->where('user_id', Auth::user()->id)
                    ->orWhereIn('id', $guests)
                    ->get();
                break;
            case 'Financeiro':
                /** Company */
                $financiers = Auth::user()->financiers->pluck('subsidiary_id');
                $subsidiariesList = ModelsSubsidiary::whereIn('id', $financiers)->get();
                $states = array_unique($subsidiariesList->pluck('state')->toArray());
                sort($states);
                $statesSearch = implode(',', $states);
                $providers = Provider::where('coverage', 'like', '%' . $statesSearch . '%')->orWhere('coverage', null)->count();
                $clients = Client::select('alias_name', 'trade_status')->where('trade_status', '!=', 'Restrito')->whereIn('subsidiary_id', $financiers)->orWhere('subsidiary_id', null)->get();
                /** Users */
                $programmers = 0;
                $administrators = 0;
                $managers = 0;
                $financiers = 0;
                $collaborators = 0;
                $stockists = 0;
                /** Clients */
                $clientsStatusChart = [];
                $clientsSubsidiaryChart = [];
                /** Service Orders */
                $serviceOrders = null;
                $serviceOrdersNotStarted = 0;
                $serviceOrdersLate = 0;
                $serviceOrdersStarted = 0;
                $serviceOrdersConcluded = 0;
                $serviceOrdersCanceled = 0;
                $serviceOrdersSubsidiary = 0;
                $serviceOrdersPriorityChart = [];
                /** Finance */
                $invoices = Invoice::where(function ($query) use ($subsidiariesList) {
                    $query->whereIn('subsidiary_id', $subsidiariesList->pluck('id'))
                        ->orWhere('subsidiary_id', null);
                })->whereYear('due_date', date('Y'))
                    ->orderBy('due_date', 'desc')->get();
                $financeIncomesChart = [];
                $financeExpensesChart = [];
                $financeRefundsChart = [];
                for ($i = 1; $i <= 12; $i++) {
                    $incomesValue = 0;
                    $expensesValue = 0;
                    $refundsValue = 0;
                    foreach ($invoices as $val) {
                        $invoiceMonth = explode('/', $val->due_date);
                        $month = (int)$invoiceMonth[1];
                        $value = str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $val->value)));
                        if ($month == $i) {
                            if ($val->type == 'receita' && $val->status == 'pago') {
                                $incomesValue += $value;
                            }
                            if ($val->type == 'despesa' && $val->status == 'pendente') {
                                $expensesValue += $value;
                            }
                            if ($val->type == 'reembolso' && $val->status == 'pendente') {
                                $refundsValue += $value;
                            }
                        }
                    }
                    $financeIncomesChart[] = $incomesValue;
                    $financeExpensesChart[] = $expensesValue;
                    $financeRefundsChart[] = $refundsValue;
                }
                $paid_incomes = $invoices->where('status', 'pago')->where('type', 'receita')->count();
                $unpaid_incomes = $invoices->where('status', 'pendente')->where('type', 'receita')->count();
                $paid_expenses = $invoices->where('status', 'pago')->where('type', 'despesa')->count();
                $unpaid_expenses = $invoices->where('status', 'pendente')->where('type', 'despesa')->count();
                $paid_refunds = $invoices->where('status', 'pago')->where('type', 'reembolso')->count();
                $unpaid_refunds = $invoices->where('status', 'pendente')->where('type', 'reembolso')->count();
                $purchases = PurchaseOrder::whereIn('subsidiary_id', $subsidiariesList->pluck('id'))->whereYear('date', date('Y'))
                    ->orderBy('forecast', 'desc')->get();
                $exec_purchases = $purchases->where('status', 'executada')->count();
                $unexec_purchases = $purchases->where('status', 'não executada')->count();
                //Commissions
                $sellers = Seller::orderBy('name')->get();
                $commissions = Commission::where('status', 'pendente')->whereIn('subsidiary_id', $subsidiariesList->pluck('id'))->orderBy('due_date', 'desc')->get();
                //Inventory
                $stocks = [];
                // Schedule
                $guests = Guest::where('user_id', Auth::user()->id)->pluck('schedule_id');
                $schedules = Schedule::whereDate('start', '<=', date('Y-m-d'))
                    ->whereDate('end', '>=', date('Y-m-d'))
                    ->where('user_id', Auth::user()->id)
                    ->orWhereIn('id', $guests)
                    ->get();
                break;
            case 'Colaborador':
                /** Company */
                $collaborators = Auth::user()->collaborators->pluck('subsidiary_id');
                $subsidiariesList = ModelsSubsidiary::whereIn('id', $collaborators)->get();
                $states = array_unique($subsidiariesList->pluck('state')->toArray());
                sort($states);
                $statesSearch = implode(',', $states);
                $providers = Provider::where('coverage', 'like', '%' . $statesSearch . '%')->orWhere('coverage', null)->count();
                $clients = Client::select('alias_name', 'trade_status')->where('trade_status', '!=', 'Restrito')->whereIn('subsidiary_id', $collaborators)->orWhere('subsidiary_id', null)->get();
                /** Users */
                $programmers = 0;
                $administrators = 0;
                $managers = 0;
                $financiers = 0;
                $collaborators = 0;
                $stockists = 0;
                /** Clients */
                $clientsSubsidiary = $clients->groupBy('alias_name')->toArray();
                $clientsSubsidiaryChart = [];
                foreach ($clientsSubsidiary as $key => $value) {
                    if ($key == '') {
                        $key = 'Sem filial';
                    }
                    $clientsSubsidiaryChart['label'][] = $key;
                    $clientsSubsidiaryChart['data'][] = count($value);
                }
                $clientsStatus = $clients->groupBy('trade_status')->toArray();
                $clientsStatusChart = [];
                foreach ($clientsStatus as $key => $value) {
                    $clientsStatusChart['label'][] = $key;
                    $clientsStatusChart['data'][] = count($value);
                }
                /** Service Orders */
                $serviceOrders = ServiceOrder::select('status', 'priority', 'subsidiary')
                    ->where(function ($query) {
                        $query->where('user_id', Auth::user()->id)
                            ->orWhere('author', Auth::user()->id);
                    })->get();
                $serviceOrdersNotStarted = $serviceOrders->where('status', 'Não iniciado')->count();
                $serviceOrdersLate = $serviceOrders->where('status', 'Atrasado')->count();
                $serviceOrdersStarted = $serviceOrders->where('status', 'Iniciado')->count();
                $serviceOrdersConcluded = $serviceOrders->where('status', 'Concluído')->count();
                $serviceOrdersCanceled = $serviceOrders->where('status', 'Cancelado')->count();
                $serviceOrdersSubsidiary = $serviceOrders->groupBy('subsidiary')->toArray();
                $serviceOrdersPriority = $serviceOrders->where('status', 'Não iniciado')->groupBy('priority')->toArray();
                $serviceOrdersPriorityChart = [];
                foreach ($serviceOrdersPriority as $key => $value) {
                    $serviceOrdersPriorityChart['label'][] = $key;
                    $serviceOrdersPriorityChart['data'][] = count($value);
                }
                /** Finance */
                $invoices = null;
                $financeIncomesChart = [];
                $financeExpensesChart = [];
                $financeRefundsChart = [];
                $paid_incomes = 0;
                $unpaid_incomes = 0;
                $paid_expenses = 0;
                $unpaid_expenses = 0;
                $paid_refunds = 0;
                $unpaid_refunds = 0;
                $purchases = 0;
                $exec_purchases = 0;
                $unexec_purchases = 0;
                //Commissions
                $sellers = [];
                $commissions = [];
                //Inventory
                $stocks = [];
                // Schedule
                $guests = Guest::where('user_id', Auth::user()->id)->pluck('schedule_id');
                $schedules = Schedule::whereDate('start', '<=', date('Y-m-d'))
                    ->whereDate('end', '>=', date('Y-m-d'))
                    ->where('user_id', Auth::user()->id)
                    ->orWhereIn('id', $guests)
                    ->get();
                break;
            case 'Estoquista':
                /** Company */
                $subsidiariesList = null;
                $providers = 0;
                $clients = null;
                /** Users */
                $programmers = 0;
                $administrators = 0;
                $managers = 0;
                $financiers = 0;
                $collaborators = 0;
                $stockists = 0;
                /** Clients */
                $clientsSubsidiaryChart = [];
                $clientsStatusChart = [];
                /** Service Orders */
                $serviceOrders = null;
                $serviceOrdersNotStarted = 0;
                $serviceOrdersLate = 0;
                $serviceOrdersStarted = 0;
                $serviceOrdersConcluded = 0;
                $serviceOrdersCanceled = 0;
                $serviceOrdersSubsidiary = 0;
                $serviceOrdersPriorityChart = [];
                /** Finance */
                $invoices = null;
                $financeIncomesChart = [];
                $financeExpensesChart = [];
                $financeRefundsChart = [];
                $paid_incomes = 0;
                $unpaid_incomes = 0;
                $paid_expenses = 0;
                $unpaid_expenses = 0;
                $paid_refunds = 0;
                $unpaid_refunds = 0;
                $purchases = null;
                $exec_purchases = 0;
                $unexec_purchases = 0;
                //Inventory
                $products = Product::select('id', 'name')->orderBy('name')->get();
                $stocks = [];
                foreach ($products as $product) {
                    $items = [];
                    for ($i = 1; $i <= 12; $i++) {
                        $inventories = Inventory::select(DB::raw('sum(input - output) as total'))
                            ->where('product_id', $product->id)
                            ->whereMonth('day', $i)
                            ->whereYear('day', date('Y'))
                            ->first();

                        $items[$i] = $inventories->total ?? 0;
                    }
                    $stocks[] = [
                        'product' => $product->name,
                        'months' => $items
                    ];
                }
                // Schedule
                $guests = Guest::where('user_id', Auth::user()->id)->pluck('schedule_id');
                $schedules = Schedule::whereDate('start', '<=', date('Y-m-d'))
                    ->whereDate('end', '>=', date('Y-m-d'))
                    ->where('user_id', Auth::user()->id)
                    ->orWhereIn('id', $guests)
                    ->get();
                break;
            default:
                /** Company */
                $subsidiariesList = Subsidiary::all('alias_name');
                $providers = Provider::count();
                $clients = Client::all('alias_name', 'trade_status');
                /** Users */
                $users = ViewsUser::all('type');
                $programmers = $users->where('type', 'Programador')->count();
                $administrators = $users->where('type', 'Administrador')->count();
                $managers = $users->where('type', 'Gerente')->count();
                $financiers = $users->where('type', 'Financeiro')->count();
                $collaborators = $users->where('type', 'Colaborador')->count();
                $stockists = $users->where('type', 'Estoquista')->count();
                /** Clients */
                $clientsSubsidiary = $clients->groupBy('alias_name')->toArray();
                $clientsSubsidiaryChart = [];
                foreach ($clientsSubsidiary as $key => $value) {
                    if ($key == '') {
                        $key = 'Sem filial';
                    }
                    $clientsSubsidiaryChart['label'][] = $key;
                    $clientsSubsidiaryChart['data'][] = count($value);
                }
                $clientsStatus = $clients->groupBy('trade_status')->toArray();
                $clientsStatusChart = [];
                foreach ($clientsStatus as $key => $value) {
                    $clientsStatusChart['label'][] = $key;
                    $clientsStatusChart['data'][] = count($value);
                }
                /** Service Orders */
                $serviceOrders = ServiceOrder::all('status', 'priority', 'subsidiary');
                $serviceOrdersNotStarted = $serviceOrders->where('status', 'Não iniciado')->count();
                $serviceOrdersLate = $serviceOrders->where('status', 'Atrasado')->count();
                $serviceOrdersStarted = $serviceOrders->where('status', 'Iniciado')->count();
                $serviceOrdersConcluded = $serviceOrders->where('status', 'Concluído')->count();
                $serviceOrdersCanceled = $serviceOrders->where('status', 'Cancelado')->count();
                $serviceOrdersSubsidiary = $serviceOrders->groupBy('subsidiary')->toArray();
                $serviceOrdersPriority = $serviceOrders->where('status', 'Não iniciado')->groupBy('priority')->toArray();
                $serviceOrdersPriorityChart = [];
                foreach ($serviceOrdersPriority as $key => $value) {
                    $serviceOrdersPriorityChart['label'][] = $key;
                    $serviceOrdersPriorityChart['data'][] = count($value);
                }
                /** Finance */
                $invoices = Invoice::whereYear('due_date', date('Y'))->orderBy('due_date', 'desc')->get();
                $financeIncomesChart = [];
                $financeExpensesChart = [];
                $financeRefundsChart = [];
                for ($i = 1; $i <= 12; $i++) {
                    $incomesValue = 0;
                    $expensesValue = 0;
                    $refundsValue = 0;
                    foreach ($invoices as $val) {
                        $invoiceMonth = explode('/', $val->due_date);
                        $month = (int)$invoiceMonth[1];
                        $value = str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $val->value)));
                        if ($month == $i) {
                            if ($val->type == 'receita' && $val->status == 'pago') {
                                $incomesValue += $value;
                            }
                            if ($val->type == 'despesa' && $val->status == 'pendente') {
                                $expensesValue += $value;
                            }
                            if ($val->type == 'reembolso' && $val->status == 'pendente') {
                                $refundsValue += $value;
                            }
                        }
                    }
                    $financeIncomesChart[] = $incomesValue;
                    $financeExpensesChart[] = $expensesValue;
                    $financeRefundsChart[] = $refundsValue;
                }
                $paid_incomes = $invoices->where('status', 'pago')->where('type', 'receita')->count();
                $unpaid_incomes = $invoices->where('status', 'pendente')->where('type', 'receita')->count();
                $paid_expenses = $invoices->where('status', 'pago')->where('type', 'despesa')->count();
                $unpaid_expenses = $invoices->where('status', 'pendente')->where('type', 'despesa')->count();
                $paid_refunds = $invoices->where('status', 'pago')->where('type', 'reembolso')->count();
                $unpaid_refunds = $invoices->where('status', 'pendente')->where('type', 'reembolso')->count();
                $purchases = PurchaseOrder::whereYear('date', date('Y'))->orderBy('forecast', 'desc')->get();
                $exec_purchases = $purchases->where('status', 'executada')->count();
                $unexec_purchases = $purchases->where('status', 'não executada')->count();
                //Commissions
                $sellers = Seller::orderBy('name')->get();
                $commissions = Commission::where('status', 'pendente')->orderBy('due_date', 'desc')->get();
                //Inventory
                $products = Product::select('id', 'name')->orderBy('name')->get();
                $stocks = [];
                foreach ($products as $product) {
                    $items = [];
                    for ($i = 1; $i <= 12; $i++) {
                        $inventories = Inventory::select(DB::raw('sum(input - output) as total'))
                            ->where('product_id', $product->id)
                            ->whereMonth('day', $i)
                            ->whereYear('day', date('Y'))
                            ->first();

                        $items[$i] = $inventories->total ?? 0;
                    }
                    $stocks[] = [
                        'product' => $product->name,
                        'months' => $items
                    ];
                }
                // Schedule
                $schedules = Schedule::whereDate('start', '<=', date('Y-m-d'))
                    ->whereDate('end', '>=', date('Y-m-d'))
                    ->get();
                break;
        }

        /** Statistics */
        $statistics = $this->accessStatistics();
        $onlineUsers = $statistics['onlineUsers'];
        $percent = $statistics['percent'];
        $access = $statistics['access'];
        $chart = $statistics['chart'];

        return view('admin.home.index', compact(
            'programmers',
            'administrators',
            'managers',
            'collaborators',
            'financiers',
            'stockists',

            'subsidiariesList',
            'clients',
            'providers',
            'clientsSubsidiaryChart',
            'clientsStatusChart',

            'serviceOrders',
            'serviceOrdersNotStarted',
            'serviceOrdersLate',
            'serviceOrdersStarted',
            'serviceOrdersConcluded',
            'serviceOrdersCanceled',
            'serviceOrdersPriorityChart',

            'financeIncomesChart',
            'financeExpensesChart',
            'financeRefundsChart',

            'invoices',
            'paid_incomes',
            'unpaid_incomes',
            'paid_expenses',
            'unpaid_expenses',
            'paid_refunds',
            'unpaid_refunds',
            'purchases',
            'exec_purchases',
            'unexec_purchases',

            'sellers',
            'commissions',

            'stocks',

            'onlineUsers',
            'percent',
            'access',
            'chart',

            'schedules',
        ));
    }

    public function chart()
    {
        /** Statistics */
        $statistics = $this->accessStatistics();
        $onlineUsers = $statistics['onlineUsers'];
        $percent = $statistics['percent'];
        $access = $statistics['access'];
        $chart = $statistics['chart'];

        return response()->json([
            'onlineUsers' => $onlineUsers,
            'access' => $access,
            'percent' => $percent,
            'chart' => $chart
        ]);
    }

    private function accessStatistics()
    {
        $onlineUsers = User::online()->count();

        $access = Visit::where('created_at', '>=', date("Y-m-d"))
            ->where('url', '!=', route('admin.home.chart'))
            ->get();
        $accessYesterday = Visit::where('created_at', '>=', date("Y-m-d", strtotime('-1 day')))
            ->where('created_at', '<', date("Y-m-d"))
            ->where('url', '!=', route('admin.home.chart'))
            ->count();

        $totalDaily = $access->count();

        $percent = 0;
        if ($accessYesterday > 0) {
            $percent = number_format((($totalDaily - $accessYesterday) / $totalDaily * 100), 2, ",", ".");
        }

        /** Visitor Chart */
        $data = $access->groupBy(function ($reg) {
            return date('H', strtotime($reg->created_at));
        });

        $dataList = [];
        foreach ($data as $key => $value) {
            $dataList[$key . 'H'] = count($value);
        }

        $chart = new \stdClass();
        $chart->labels = (array_keys($dataList));
        $chart->dataset = (array_values($dataList));

        return array(
            'onlineUsers' => $onlineUsers,
            'access' => $totalDaily,
            'percent' => $percent,
            'chart' => $chart
        );
    }
}
