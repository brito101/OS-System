<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Collaborator;
use App\Models\Manager;
use App\Models\User;
use App\Models\Views\Client;
use App\Models\Views\Provider;
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
        $collaborators = ViewsUser::where('type', 'Colaborador')->count();

        $role = Auth::user()->roles->first()->name;

        switch ($role) {
            case 'Colaborador':
                $subsidiaries = Collaborator::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                $clients = Client::whereIn('subsidiary_id', $subsidiaries)->orWhere('subsidiary_id', null)->count();
                break;
            case 'Gerente':
                $subsidiaries = Manager::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                $clients = Client::whereIn('subsidiary_id', $subsidiaries)->orWhere('subsidiary_id', null)->count();
                break;
            default:
                $clients = Client::count();
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
            'clients',
            'providers',
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
