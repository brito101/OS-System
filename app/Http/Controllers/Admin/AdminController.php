<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Collaborator;
use App\Models\Financier;
use App\Models\Manager;
use App\Models\PurchaseOrder;
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

class AdminController extends Controller
{
    public function index()
    {
        $administrators = ViewsUser::where('type', 'Administrador')->count();
        $managers = ViewsUser::where('type', 'Gerente')->count();

        $role = Auth::user()->roles->first()->name;

        $clients = 0;
        $collaborator = 0;
        $financiers = 0;
        $service_orders = 0;
        $paid_incomes = 0;
        $unpaid_incomes = 0;
        $paid_expenses = 0;
        $unpaid_expenses = 0;
        $paid_refunds = 0;
        $unpaid_refunds = 0;
        $exec_purchases = 0;
        $unexec_purchases = 0;

        switch ($role) {
            case 'Colaborador':
                $subsidiaries = Collaborator::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                $clients = Client::whereIn('subsidiary_id', $subsidiaries)->orWhere('subsidiary_id', null)->count();
                $financiers = Financier::whereIn('subsidiary_id', $subsidiaries)->count();
                $collaborators = Collaborator::whereIn('subsidiary_id', $subsidiaries)->count();
                $service_orders = ServiceOrder::where('author_id', Auth::user()->id)->orWhere('user_id', Auth::user()->id)->count();
                break;
            case 'Gerente':
                $subsidiaries = Manager::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                $clients = Client::whereIn('subsidiary_id', $subsidiaries)->orWhere('subsidiary_id', null)->count();
                $financiers = Financier::whereIn('subsidiary_id', $subsidiaries)->count();
                $collaborators = Collaborator::whereIn('subsidiary_id', $subsidiaries)->count();
                $serviceOrders = ServiceOrder::where('user_id', Auth::user()->id)
                    ->orWhere('author_id', Auth::user()->id)
                    ->orWhereIn('subsidiary_id', $subsidiaries)
                    ->get();
                $paid_incomes = FinanceIncome::whereIn('subsidiary_id', $subsidiaries)->where('status', 'pago')->count();
                $unpaid_incomes = FinanceIncome::whereIn('subsidiary_id', $subsidiaries)->where('status', 'pendente')->count();
                $paid_expenses = FinanceExpense::whereIn('subsidiary_id', $subsidiaries)->where('status', 'pago')->count();
                $unpaid_expenses = FinanceExpense::whereIn('subsidiary_id', $subsidiaries)->where('status', 'pendente')->count();
                $paid_refunds = FinanceRefund::whereIn('subsidiary_id', $subsidiaries)->where('status', 'pago')->count();
                $unpaid_refunds = FinanceRefund::whereIn('subsidiary_id', $subsidiaries)->where('status', 'pendente')->count();
                $exec_purchases = PurchaseOrder::whereIn('subsidiary_id', $subsidiaries)->where('status', 'executada')->count();
                $unexec_purchases = PurchaseOrder::whereIn('subsidiary_id', $subsidiaries)->where('status', 'não executada')->count();
                break;
            case 'Financeiro':
                $subsidiaries = Financier::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                $paid_incomes = FinanceIncome::whereIn('subsidiary_id', $subsidiaries)->where('status', 'pago')->count();
                $unpaid_incomes = FinanceIncome::whereIn('subsidiary_id', $subsidiaries)->where('status', 'pendente')->count();
                $paid_expenses = FinanceExpense::whereIn('subsidiary_id', $subsidiaries)->where('status', 'pago')->count();
                $unpaid_expenses = FinanceExpense::whereIn('subsidiary_id', $subsidiaries)->where('status', 'pendente')->count();
                $paid_refunds = FinanceRefund::whereIn('subsidiary_id', $subsidiaries)->where('status', 'pago')->count();
                $unpaid_refunds = FinanceRefund::whereIn('subsidiary_id', $subsidiaries)->where('status', 'pendente')->count();
                $exec_purchases = PurchaseOrder::whereIn('subsidiary_id', $subsidiaries)->where('status', 'executada')->count();
                $unexec_purchases = PurchaseOrder::whereIn('subsidiary_id', $subsidiaries)->where('status', 'não executada')->count();
                break;
            default:
                $clients = Client::count();
                $financiers = ViewsUser::where('type', 'Financeiro')->count();
                $collaborators = ViewsUser::where('type', 'Colaborador')->count();
                $service_orders = ServiceOrder::count();
                $paid_incomes = FinanceIncome::where('status', 'pago')->count();
                $unpaid_incomes = FinanceIncome::where('status', 'pendente')->count();
                $paid_expenses = FinanceExpense::where('status', 'pago')->count();
                $unpaid_expenses = FinanceExpense::where('status', 'pendente')->count();
                $paid_refunds = FinanceRefund::where('status', 'pago')->count();
                $unpaid_refunds = FinanceRefund::where('status', 'pendente')->count();
                $exec_purchases = PurchaseOrder::where('status', 'executada')->count();
                $unexec_purchases = PurchaseOrder::where('status', 'não executada')->count();
                break;
        }

        $providers = Provider::count();
        $subsidiariesList = Subsidiary::count();

        /** Statistics */
        $statistics = $this->accessStatistics();
        $onlineUsers = $statistics['onlineUsers'];
        $percent = $statistics['percent'];
        $access = $statistics['access'];
        $chart = $statistics['chart'];

        return view('admin.home.index', compact(
            'administrators',
            'subsidiariesList',
            'managers',
            'collaborators',
            'financiers',
            'clients',
            'providers',
            'service_orders',
            'paid_incomes',
            'unpaid_incomes',
            'paid_expenses',
            'unpaid_expenses',
            'paid_refunds',
            'unpaid_refunds',
            'exec_purchases',
            'unexec_purchases',
            'onlineUsers',
            'percent',
            'access',
            'chart',
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
