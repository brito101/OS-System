<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\InvoiceRequest;
use App\Models\Financier;
use App\Models\Invoice;
use App\Models\Manager;
use App\Models\Provider;
use App\Models\Subsidiary;
use App\Models\Views\FinanceExpense;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DataTables;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('Listar Despesas')) {
            abort(403, 'Acesso não autorizado');
        }

        $role = Auth::user()->roles->first()->name;
        $search = @$request->search['value'];
        if ($search != '') {
            $search = '';
        } else {
            $search = date('Y-m');
        }

        switch ($role) {
            case 'Financeiro':
                $subsidiaries = Financier::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                if ($search == '') {
                    $incomes = FinanceExpense::whereIn('subsidiary_id', $subsidiaries)->orWhere('subsidiary_id', null)->get();
                } else {
                    $incomes = FinanceExpense::where('due_date', 'like', "$search%")->whereIn('subsidiary_id', $subsidiaries)->orWhere('subsidiary_id', null)->get();
                }
                break;
            case 'Gerente':
                $subsidiaries = Manager::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                if ($search == '') {
                    $incomes = FinanceExpense::whereIn('subsidiary_id', $subsidiaries)->orWhere('subsidiary_id', null)->get();
                } else {
                    $incomes = FinanceExpense::where('due_date', 'like', "$search%")->whereIn('subsidiary_id', $subsidiaries)->orWhere('subsidiary_id', null)->get();
                }
                break;
            default:
                if ($search == '') {
                    $incomes = FinanceExpense::all(); #orderBy('id', 'desc')->limit(10)->get(); #all
                } else {
                    $incomes = FinanceExpense::where('due_date', 'like', "$search%")->get();
                } #orderBy('id', 'desc')->limit(10)->get(); #all}
                break;
        }

        $payValue = Invoice::where('status', 'pago')->whereIn('id', $incomes->pluck('id'))->sum('value');
        $pay = 'R$ ' . \number_format($payValue, 2, ',', '.');

        $receiveValue = Invoice::where('status', 'pendente')->whereIn('id', $incomes->pluck('id'))->sum('value');
        $receive = 'R$ ' . \number_format($receiveValue, 2, ',', '.');

        $balance = 'R$ ' . \number_format($payValue - $receiveValue, 2, ',', '.');

        if ($request->ajax()) {
            return Datatables::of($incomes)
                ->addIndexColumn()
                ->addColumn('btnStatus', function ($row) {
                    $payLink = '';
                    if ($row->status == 'pendente') {
                        $payLink = "<a id='status_$row->id' class=\"btn btn-xs btn-danger mx-1 shadow\" title=\"Alterar para pago\" onClick=\"pagarDespesas('pago',$row->id)\"><i class=\"fa fa-lg fa-fw fa-thumbs-down\"></i></a>";
                    }
                    if ($row->status == 'pago') {
                        $payLink = "<a id='status_$row->id' class=\"btn btn-xs btn-success mx-1 shadow\" title=\"Alterar para pendente\" onClick=\"pagarDespesas('naopago',$row->id)\"><i class=\"fa fa-lg fa-fw fa-thumbs-up\"></i></a>";
                    }
                    return $payLink;
                })
                ->addColumn('action', function ($row) {
                    $fileLink = '';
                    if ($row->file) {
                        $fileLink = '<a class="btn btn-xs btn-secondary mx-1 shadow" title="Anexo" download="anexo" href="' .  Storage::url($row->file)  . '"><i class="fa fa-lg fa-fw fa-download"></i></a>';
                    }
                    $btn = $fileLink . '<a class="btn btn-xs btn-success mx-1 shadow" title="Visualizar" href="finance-expenses/' . $row->id . '"><i class="fa fa-lg fa-fw fa-eye"></i></a>' . '<a class="btn btn-xs btn-primary mx-1 shadow" title="Editar" href="finance-expenses/' . $row->id . '/edit"><i class="fa fa-lg fa-fw fa-pen"></i></a>' . '<a class="btn btn-xs btn-danger mx-1 shadow" title="Excluir" href="finance-expenses/destroy/' . $row->id . '" onclick="return confirm(\'Confirma a exclusão deste lançamento?\')"><i class="fa fa-lg fa-fw fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['btnStatus', 'action'])
                ->make(true);
        }

        return view('admin.finance.expense.index', compact('pay', 'receive', 'balance'));
    }

    public function pending(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('Listar Despesas')) {
            abort(403, 'Acesso não autorizado');
        }

        $role = Auth::user()->roles->first()->name;
        $search = @$request->search['value'];
        if ($search != '') {
            $search = '';
        } else {
            $search = date('Y-m');
        }

        switch ($role) {
            case 'Financeiro':
                $subsidiaries = Financier::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                if ($search == '') {
                    $incomes = FinanceExpense::whereIn('subsidiary_id', $subsidiaries)->orWhere('subsidiary_id', null)->where('status', 'pendente')->get();
                } else {
                    $incomes = FinanceExpense::where('due_date', 'like', "$search%")->whereIn('subsidiary_id', $subsidiaries)->orWhere('subsidiary_id', null)->where('status', 'pendente')->get();
                }
                break;
            case 'Gerente':
                $subsidiaries = Manager::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                if ($search == '') {
                    $incomes = FinanceExpense::whereIn('subsidiary_id', $subsidiaries)->orWhere('subsidiary_id', null)->where('status', 'pendente')->get();
                } else {
                    $incomes = FinanceExpense::where('due_date', 'like', "$search%")->whereIn('subsidiary_id', $subsidiaries)->orWhere('subsidiary_id', null)->where('status', 'pendente')->get();
                }
                break;
            default:
                if ($search == '') {
                    $incomes = FinanceExpense::where('status', 'pendente')->get();
                } else {
                    $incomes = FinanceExpense::where('due_date', 'like', "$search%")->where('status', 'pendente')->get();
                }
                break;
        }

        $receiveValue = Invoice::where('status', 'pendente')->whereIn('id', $incomes->pluck('id'))->sum('value');
        $pending = 'R$ ' . \number_format($receiveValue, 2, ',', '.');

        if ($request->ajax()) {
            return Datatables::of($incomes)
                ->addIndexColumn()
                ->addColumn('btnStatus', function ($row) {
                    /*  $payLink = '<a class="btn btn-xs btn-danger mx-1 shadow" title="Alterar para pago" href="finance-expenses/pay/' . $row->id . '"><i class="fa fa-lg fa-fw fa-thumbs-down"></i></a>';
                    return $payLink; */
                    $payLink = '';
                    if ($row->status == 'pendente') {
                        $payLink = "<a id='status_$row->id' class=\"btn btn-xs btn-danger mx-1 shadow\" title=\"Alterar para pago\" onClick=\"pagarDespesas('pago',$row->id)\"><i class=\"fa fa-lg fa-fw fa-thumbs-down\"></i></a>";
                    }
                    if ($row->status == 'pago') {
                        $payLink = "<a id='status_$row->id' class=\"btn btn-xs btn-success mx-1 shadow\" title=\"Alterar para pendente\" onClick=\"pagarDespesas('naopago',$row->id)\"><i class=\"fa fa-lg fa-fw fa-thumbs-up\"></i></a>";
                    }
                    return $payLink;
                })
                ->addColumn('action', function ($row) {
                    $fileLink = '';
                    if ($row->file) {
                        $fileLink = '<a class="btn btn-xs btn-secondary mx-1 shadow" title="Anexo" download="anexo" href="' .  Storage::url($row->file)  . '"><i class="fa fa-lg fa-fw fa-download"></i></a>';
                    }
                    $btn = $fileLink . '<a class="btn btn-xs btn-success mx-1 shadow" title="Visualizar" href="finance-expenses/' . $row->id . '"><i class="fa fa-lg fa-fw fa-eye"></i></a>' . '<a class="btn btn-xs btn-primary mx-1 shadow" title="Editar" href="finance-expenses/' . $row->id . '/edit"><i class="fa fa-lg fa-fw fa-pen"></i></a>' . '<a class="btn btn-xs btn-danger mx-1 shadow" title="Excluir" href="finance-expenses/destroy/' . $row->id . '" onclick="return confirm(\'Confirma a exclusão deste lançamento?\')"><i class="fa fa-lg fa-fw fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['btnStatus', 'action'])
                ->make(true);
        }

        return view('admin.finance.expense.pending', compact('pending'));
    }

    public function create()
    {
        if (!Auth::user()->hasPermissionTo('Criar Despesas')) {
            abort(403, 'Acesso não autorizado');
        }

        $role = Auth::user()->roles->first()->name;

        switch ($role) {
            case 'Financeiro':
                $financiers = Financier::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                $subsidiaries = Subsidiary::whereIn('id', $financiers)->get();
                $states = array_unique($subsidiaries->pluck('state')->toArray());
                sort($states);
                $statesSearch = implode(',', $states);
                $providers = Provider::where('coverage', 'like', '%' . $statesSearch . '%')->orWhere('coverage', null)->get();
                break;
            case 'Gerente':
                $managers = Manager::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                $subsidiaries = Subsidiary::whereIn('id', $managers)->get();
                $states = array_unique($subsidiaries->pluck('state')->toArray());
                sort($states);
                $statesSearch = implode(',', $states);
                $providers = Provider::where('coverage', 'like', '%' . $statesSearch . '%')->orWhere('coverage', null)->get();
                break;
            default:
                $subsidiaries = Subsidiary::all();
                $providers = Provider::all();
                break;
        }

        return view('admin.finance.expense.create', compact('subsidiaries', 'providers'));
    }

    public function store(InvoiceRequest $request)
    {
        if (!Auth::user()->hasPermissionTo('Criar Despesas')) {
            abort(403, 'Acesso não autorizado');
        }

        $data = $request->all();
        if ($request->subsidiary_id != 'all') {
            $subsidiary = Subsidiary::where('id', $request->subsidiary_id)->first();
            if (!$subsidiary) {
                abort(403, 'Acesso não autorizado');
            } else {
                $data['subsidiary_id'] = $subsidiary->id;
            }
        } elseif ($request->subsidiary_id == 'all') {
            $data['subsidiary_id'] = null;
        } else {
            abort(403, 'Acesso não autorizado');
        }

        $data['user_id'] = Auth::user()->id;
        $data['type'] = 'despesa';
        if (!$request->quota) {
            $data['quota'] = 1;
        } else {
            $data['value'] = $data['entrance'];
            $data['description'] = $request->description . ' (1/' . $request->quota . ')';
        }

        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $path = $request->file('file')->store('finance/expense');
            $data['file'] = $path;
        }

        if ($data['provider_id']) {
            $provider = Provider::where('id', $request->provider_id)->first();
            if (!$provider) {
                abort(403, 'Acesso não autorizado');
            }
        }

        $invoice = Invoice::create($data);

        if ($invoice->save()) {
            if ($request->repetition == 'semanal' || $request->repetition == 'mensal' || $request->repetition == 'anual') {
                $time = 1;
                $unit = $request->repetition == 'semanal' ? 'week' : ('mensal' ? 'month' : 'year');
                for ($i = 1; $i < $invoice->quota; $i++) {
                    $part = $i + 1;
                    $newInvoice = $invoice->replicate();
                    $newInvoice->value = $request->value;
                    $newInvoice->invoice_id = $invoice->id;
                    $newInvoice->description = $request->description . ' (' . $part . '/' . $request->quota . ')';
                    $newInvoice->due_date = date('Y-m-d', strtotime("+{$time} {$unit}", strtotime($request->due_date)));
                    $newInvoice->created_at = Carbon::now();
                    $newInvoice->save();
                    $time++;
                }
            }

            return redirect()
                ->route('admin.finance-expenses.index')
                ->with('success', 'Cadastro realizado!');
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Erro ao cadastrar!');
        }
    }

    public function show($id)
    {
        if (!Auth::user()->hasPermissionTo('Listar Despesas')) {
            abort(403, 'Acesso não autorizado');
        }

        $role = Auth::user()->roles->first()->name;

        switch ($role) {
            case 'Financeiro':
                $financiers = Financier::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                $subsidiaries = Subsidiary::whereIn('id', $financiers)->get();
                break;
            case 'Gerente':
                $managers = Manager::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                $subsidiaries = Subsidiary::whereIn('id', $managers)->get();
                break;
            default:
                $subsidiaries = Subsidiary::all();
                break;
        }

        $invoice = Invoice::where('id', $id)->where('type', 'despesa')
            ->where(function ($query) use ($subsidiaries) {
                $query->whereIn('subsidiary_id', $subsidiaries->pluck('id'))
                    ->orWhere('subsidiary_id', null);
            })
            ->first();

        if (!$invoice) {
            abort(403, 'Acesso não autorizado');
        }

        return view('admin.finance.expense.show', compact('invoice'));
    }

    public function edit($id)
    {
        if (!Auth::user()->hasPermissionTo('Editar Despesas')) {
            abort(403, 'Acesso não autorizado');
        }

        $role = Auth::user()->roles->first()->name;

        switch ($role) {
            case 'Financeiro':
                $financiers = Financier::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                $subsidiaries = Subsidiary::whereIn('id', $financiers)->get();
                $states = array_unique($subsidiaries->pluck('state')->toArray());
                sort($states);
                $statesSearch = implode(',', $states);
                $providers = Provider::where('coverage', 'like', '%' . $statesSearch . '%')->orWhere('coverage', null)->get();
                break;
            case 'Gerente':
                $managers = Manager::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                $subsidiaries = Subsidiary::whereIn('id', $managers)->get();
                $states = array_unique($subsidiaries->pluck('state')->toArray());
                sort($states);
                $statesSearch = implode(',', $states);
                $providers = Provider::where('coverage', 'like', '%' . $statesSearch . '%')->orWhere('coverage', null)->get();
                break;
            default:
                $subsidiaries = Subsidiary::all();
                $providers = Provider::all();
                break;
        }

        $invoice = Invoice::where('id', $id)->where('type', 'despesa')
            ->where(function ($query) use ($subsidiaries) {
                $query->whereIn('subsidiary_id', $subsidiaries->pluck('id'))
                    ->orWhere('subsidiary_id', null);
            })
            ->first();

        if (!$invoice) {
            abort(403, 'Acesso não autorizado');
        }

        return view('admin.finance.expense.edit', compact('subsidiaries', 'invoice', 'providers'));
    }

    public function update(InvoiceRequest $request, $id)
    {
        if (!Auth::user()->hasPermissionTo('Editar Despesas')) {
            abort(403, 'Acesso não autorizado');
        }

        $role = Auth::user()->roles->first()->name;

        switch ($role) {
            case 'Financeiro':
                $financiers = Financier::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                $subsidiaries = Subsidiary::whereIn('id', $financiers)->get();
                break;
            case 'Gerente':
                $managers = Manager::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                $subsidiaries = Subsidiary::whereIn('id', $managers)->get();
                break;
            default:
                $subsidiaries = Subsidiary::all();
                break;
        }

        $invoice = Invoice::where('id', $id)->where('type', 'despesa')
            ->where(function ($query) use ($subsidiaries) {
                $query->whereIn('subsidiary_id', $subsidiaries->pluck('id'))
                    ->orWhere('subsidiary_id', null);
            })->first();

        if (!$invoice) {
            abort(403, 'Acesso não autorizado');
        }

        $data = $request->all();
        if ($request->subsidiary_id != 'all') {
            $subsidiary = Subsidiary::where('id', $request->subsidiary_id)->first();
            if (!$subsidiary) {
                abort(403, 'Acesso não autorizado');
            } else {
                $data['subsidiary_id'] = $subsidiary->id;
            }
        } elseif ($request->subsidiary_id == 'all') {
            $data['subsidiary_id'] = null;
        } else {
            abort(403, 'Acesso não autorizado');
        }

        if (!$request->quota) {
            $data['quota'] = 1;
        }

        if ($request->input('remove_file') == 'sim') {
            $data['file'] = null;
        }

        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $path = $request->file('file')->store('finance/expense');
            $data['file'] = $path;
        }

        if ($data['provider_id']) {
            $provider = Provider::where('id', $request->provider_id)->first();
            if (!$provider) {
                abort(403, 'Acesso não autorizado');
            }
        }

        if ($invoice->update($data)) {

            return redirect()
                ->route('admin.finance-expenses.index')
                ->with('success', 'Atualização realizada!');
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Erro ao cadastrar!');
        }
    }

    public function destroy($id)
    {
        if (!Auth::user()->hasPermissionTo('Excluir Despesas')) {
            abort(403, 'Acesso não autorizado');
        }

        $role = Auth::user()->roles->first()->name;

        switch ($role) {
            case 'Financeiro':
                $financiers = Financier::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                $subsidiaries = Subsidiary::whereIn('id', $financiers)->get();
                break;
            case 'Gerente':
                $managers = Manager::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                $subsidiaries = Subsidiary::whereIn('id', $managers)->get();
                break;
            default:
                $subsidiaries = Subsidiary::all();
                break;
        }

        $invoice = Invoice::where('id', $id)->where('type', 'despesa')
            ->where(function ($query) use ($subsidiaries) {
                $query->whereIn('subsidiary_id', $subsidiaries->pluck('id'))
                    ->orWhere('subsidiary_id', null);
            })->first();

        if (!$invoice) {
            abort(403, 'Acesso não autorizado');
        }

        if ($invoice->delete()) {
            Invoice::where('invoice_id', $id)->delete();
            return redirect()
                ->route('admin.finance-expenses.index')
                ->with('success', 'Exclusão realizada!');
        } else {
            return redirect()
                ->back()
                ->with('error', 'Erro ao excluir!');
        }
    }

    public function pay($id)
    {
        if (!Auth::user()->hasPermissionTo('Editar Despesas')) {
            abort(403, 'Acesso não autorizado');
        }

        $role = Auth::user()->roles->first()->name;

        switch ($role) {
            case 'Financeiro':
                $financiers = Financier::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                $subsidiaries = Subsidiary::whereIn('id', $financiers)->get();
                break;
            case 'Gerente':
                $managers = Manager::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                $subsidiaries = Subsidiary::whereIn('id', $managers)->get();
                break;
            default:
                $subsidiaries = Subsidiary::all();
                break;
        }

        $invoice = Invoice::where('id', $id)->where('type', 'despesa')
            ->where(function ($query) use ($subsidiaries) {
                $query->whereIn('subsidiary_id', $subsidiaries->pluck('id'))
                    ->orWhere('subsidiary_id', null);
            })->first();

        if (!$invoice) {
            abort(403, 'Acesso não autorizado');
        }

        $invoice->status = 'pago';

        if ($invoice->update()) {
            $mensagem[] = [
                "mensagem" => 'Despesa marcada como paga!',
                "status" => '200'

            ];
            return response()->json($mensagem, 200);
            /*  return redirect()
                ->back()
                ->with('success', 'Despesa marcada como paga!'); */
        } else {
            $mensagem[] = [
                "mensagem" => 'Erro ao atualizar!!',
                "status" => '404'

            ];
            return response()->json($mensagem, 200);
            /*  return redirect()
                ->back()
                ->with('error', 'Erro ao atualizar!'); */
        }
    }

    public function receive($id)
    {
        if (!Auth::user()->hasPermissionTo('Editar Despesas')) {
            abort(403, 'Acesso não autorizado');
        }

        $role = Auth::user()->roles->first()->name;

        switch ($role) {
            case 'Financeiro':
                $financiers = Financier::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                $subsidiaries = Subsidiary::whereIn('id', $financiers)->get();
                break;
            case 'Gerente':
                $managers = Manager::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                $subsidiaries = Subsidiary::whereIn('id', $managers)->get();
                break;
            default:
                $subsidiaries = Subsidiary::all();
                break;
        }

        $invoice = Invoice::where('id', $id)->where('type', 'despesa')
            ->where(function ($query) use ($subsidiaries) {
                $query->whereIn('subsidiary_id', $subsidiaries->pluck('id'))
                    ->orWhere('subsidiary_id', null);
            })->first();

        if (!$invoice) {
            abort(403, 'Acesso não autorizado');
        }

        $invoice->status = 'pendente';

        if ($invoice->update()) {
            $mensagem[] = [
                "mensagem" => 'Despesa marcada como paga!',
                "status" => '200'

            ];
            return response()->json($mensagem, 200);
            /*  return redirect()
                ->back()
                ->with('success', 'Despesa marcada como paga!'); */
        } else {
            $mensagem[] = [
                "mensagem" => 'Erro ao atualizar!!',
                "status" => '404'

            ];
            return response()->json($mensagem, 200);
            /*  return redirect()
                ->back()
                ->with('error', 'Erro ao atualizar!'); */
        }
    }

    public function pdf($id)
    {
        if (!Auth::user()->hasPermissionTo('Listar Despesas')) {
            abort(403, 'Acesso não autorizado');
        }

        $role = Auth::user()->roles->first()->name;

        switch ($role) {
            case 'Financeiro':
                $financiers = Financier::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                $subsidiaries = Subsidiary::whereIn('id', $financiers)->get();
                break;
            case 'Gerente':
                $managers = Manager::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                $subsidiaries = Subsidiary::whereIn('id', $managers)->get();
                break;
            default:
                $subsidiaries = Subsidiary::all();
                break;
        }

        $invoice = Invoice::where('id', $id)->where('type', 'despesa')
            ->where(function ($query) use ($subsidiaries) {
                $query->whereIn('subsidiary_id', $subsidiaries->pluck('id'))
                    ->orWhere('subsidiary_id', null);
            })->first();

        if (!$invoice) {
            abort(403, 'Acesso não autorizado');
        }

        return view('admin.finance.expense.pdf', compact('invoice'));
    }

    public function changeStatus(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('Editar Despesas')) {
            abort(403, 'Acesso não autorizado');
        }

        if (!$request->ids) {
            return redirect()
                ->back()
                ->with('error', 'Selecione ao menos uma linha!');
        }

        $ids = explode(",", $request->ids);

        $role = Auth::user()->roles->first()->name;
        switch ($role) {
            case 'Financeiro':
                $financiers = Financier::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                $subsidiaries = Subsidiary::whereIn('id', $financiers)->get();
                break;
            case 'Gerente':
                $managers = Manager::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                $subsidiaries = Subsidiary::whereIn('id', $managers)->get();
                break;
            default:
                $subsidiaries = Subsidiary::all();
                break;
        }

        foreach ($ids as $id) {
            $invoice = Invoice::where('id', $id)->where('type', 'despesa')
                ->where(function ($query) use ($subsidiaries) {
                    $query->whereIn('subsidiary_id', $subsidiaries->pluck('id'))
                        ->orWhere('subsidiary_id', null);
                })->first();
            if (!$invoice) {
                abort(403, 'Acesso não autorizado');
            }

            $invoice->status = $invoice->status == 'pago' ? 'pendente' : 'pago';
            $invoice->update();
        }

        return redirect()
            ->back()
            ->with('success', 'Despesas atualizadas!');
    }

    public function batchDelete(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('Excluir Despesas')) {
            abort(403, 'Acesso não autorizado');
        }

        if (!$request->ids) {
            return redirect()
                ->back()
                ->with('error', 'Selecione ao menos uma linha!');
        }

        $ids = explode(",", $request->ids);

        $role = Auth::user()->roles->first()->name;
        switch ($role) {
            case 'Financeiro':
                $financiers = Financier::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                $subsidiaries = Subsidiary::whereIn('id', $financiers)->get();
                break;
            case 'Gerente':
                $managers = Manager::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                $subsidiaries = Subsidiary::whereIn('id', $managers)->get();
                break;
            default:
                $subsidiaries = Subsidiary::all();
                break;
        }

        foreach ($ids as $id) {
            $invoice = Invoice::where('id', $id)->where('type', 'despesa')
                ->where(function ($query) use ($subsidiaries) {
                    $query->whereIn('subsidiary_id', $subsidiaries->pluck('id'))
                        ->orWhere('subsidiary_id', null);
                })->first();
            if (!$invoice) {
                abort(403, 'Acesso não autorizado');
            }
            $invoice->delete();
        }

        return redirect()
            ->back()
            ->with('success', 'Despesas excluídas!');
    }

    public function changeValue(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('Editar Despesas')) {
            abort(403, 'Acesso não autorizado');
        }

        if (!$request->ids) {
            return redirect()
                ->back()
                ->with('error', 'Selecione ao menos uma linha!');
        }

        $ids = explode(",", $request->ids);

        $role = Auth::user()->roles->first()->name;
        switch ($role) {
            case 'Financeiro':
                $financiers = Financier::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                $subsidiaries = Subsidiary::whereIn('id', $financiers)->get();
                break;
            case 'Gerente':
                $managers = Manager::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                $subsidiaries = Subsidiary::whereIn('id', $managers)->get();
                break;
            default:
                $subsidiaries = Subsidiary::all();
                break;
        }

        foreach ($ids as $id) {
            $invoice = Invoice::where('id', $id)->where('type', 'despesa')
                ->where(function ($query) use ($subsidiaries) {
                    $query->whereIn('subsidiary_id', $subsidiaries->pluck('id'))
                        ->orWhere('subsidiary_id', null);
                })->first();
            if (!$invoice) {
                abort(403, 'Acesso não autorizado');
            }

            $invoice->value = str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $request->value)));
            $invoice->update();
        }

        return redirect()
            ->back()
            ->with('success', 'Despesas atualizadas!');
    }
}
