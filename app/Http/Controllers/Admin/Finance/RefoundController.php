<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\InvoiceRequest;
use App\Models\Financier;
use App\Models\Invoice;
use App\Models\Manager;
use App\Models\Subsidiary;
use App\Models\Views\FinanceRefund;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DataTables;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RefoundController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('Listar Reembolsos')) {
            abort(403, 'Acesso não autorizado');
        }

        $role = Auth::user()->roles->first()->name;

        switch ($role) {
            case 'Financeiro':
                $subsidiaries = Financier::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                $incomes = FinanceRefund::whereIn('subsidiary_id', $subsidiaries)->get();
                break;
            case 'Gerente':
                $subsidiaries = Manager::where('user_id', Auth::user()->id)->pluck('subsidiary_id');
                $incomes = FinanceRefund::whereIn('subsidiary_id', $subsidiaries)->get();
                break;
            default:
                $incomes = FinanceRefund::all();
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
                        $payLink = '<a class="btn btn-xs btn-danger mx-1 shadow" title="Alterar para pago" href="finance-refunds/pay/' . $row->id . '"><i class="fa fa-lg fa-fw fa-thumbs-down"></i></a>';
                    }
                    if ($row->status == 'pago') {
                        $payLink = '<a class="btn btn-xs btn-success mx-1 shadow" title="Alterar para pendente" href="finance-refunds/receive/' . $row->id . '"><i class="fa fa-lg fa-fw fa-thumbs-up"></i></a>';
                    }
                    return $payLink;
                })
                ->addColumn('action', function ($row) {
                    $fileLink = '';
                    if ($row->file) {
                        $fileLink = '<a class="btn btn-xs btn-secondary mx-1 shadow" title="Anexo" download="anexo" href="' .  Storage::url($row->file)  . '"><i class="fa fa-lg fa-fw fa-download"></i></a>';
                    }
                    $btn = $fileLink . '<a class="btn btn-xs btn-success mx-1 shadow" title="Visualizar" href="finance-refunds/' . $row->id . '"><i class="fa fa-lg fa-fw fa-eye"></i></a>' . '<a class="btn btn-xs btn-primary mx-1 shadow" title="Editar" href="finance-refunds/' . $row->id . '/edit"><i class="fa fa-lg fa-fw fa-pen"></i></a>' . '<a class="btn btn-xs btn-danger mx-1 shadow" title="Excluir" href="finance-refunds/destroy/' . $row->id . '" onclick="return confirm(\'Confirma a exclusão deste lançamento?\')"><i class="fa fa-lg fa-fw fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['btnStatus', 'action'])
                ->make(true);
        }

        return view('admin.finance.refound.index', compact('pay', 'receive', 'balance'));
    }

    public function create()
    {
        if (!Auth::user()->hasPermissionTo('Criar Reembolsos')) {
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
        return view('admin.finance.refound.create', compact('subsidiaries'));
    }

    public function store(InvoiceRequest $request)
    {
        if (!Auth::user()->hasPermissionTo('Criar Reembolsos')) {
            abort(403, 'Acesso não autorizado');
        }

        $subsidiary = Subsidiary::where('id', $request->subsidiary_id)->first();
        if (!$subsidiary) {
            abort(403, 'Acesso não autorizado');
        }

        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        $data['type'] = 'reembolso';
        $data['quota'] = 1;

        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $path = $request->file('file')->store('finance/refound');
            $data['file'] = $path;
        }

        $invoice = Invoice::create($data);

        if ($invoice->save()) {
            return redirect()
                ->route('admin.finance-refunds.index')
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
        if (!Auth::user()->hasPermissionTo('Listar Reembolsos')) {
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

        $invoice = Invoice::where('id', $id)->where('type', 'reembolso')->where(function ($query) use ($subsidiaries) {
            $query->whereIn('subsidiary_id', $subsidiaries->pluck('id'))
                ->orWhere('subsidiary_id', null);
        })->first();

        if (!$invoice) {
            abort(403, 'Acesso não autorizado');
        }

        return view('admin.finance.refound.show', compact('invoice'));
    }

    public function edit($id)
    {
        if (!Auth::user()->hasPermissionTo('Editar Reembolsos')) {
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

        $invoice = Invoice::where('id', $id)->where('type', 'reembolso')->where(function ($query) use ($subsidiaries) {
            $query->whereIn('subsidiary_id', $subsidiaries->pluck('id'))
                ->orWhere('subsidiary_id', null);
        })->first();

        if (!$invoice) {
            abort(403, 'Acesso não autorizado');
        }

        return view('admin.finance.refound.edit', compact('subsidiaries', 'invoice'));
    }

    public function update(InvoiceRequest $request, $id)
    {
        if (!Auth::user()->hasPermissionTo('Editar Reembolsos')) {
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

        $invoice = Invoice::where('id', $id)->where('type', 'reembolso')->where(function ($query) use ($subsidiaries) {
            $query->whereIn('subsidiary_id', $subsidiaries->pluck('id'))
                ->orWhere('subsidiary_id', null);
        })->first();

        if (!$invoice) {
            abort(403, 'Acesso não autorizado');
        }

        $data = $request->all();

        if (!$request->quota) {
            $data['quota'] = 1;
        }

        if ($request->input('remove_file') == 'sim') {
            $data['file'] = null;
        }

        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $path = $request->file('file')->store('finance/refound');
            $data['file'] = $path;
        }

        if ($invoice->update($data)) {

            return redirect()
                ->route('admin.finance-refunds.index')
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
        if (!Auth::user()->hasPermissionTo('Excluir Reembolsos')) {
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

        $invoice = Invoice::where('id', $id)->where('type', 'reembolso')->where(function ($query) use ($subsidiaries) {
            $query->whereIn('subsidiary_id', $subsidiaries->pluck('id'))
                ->orWhere('subsidiary_id', null);
        })->first();

        if (!$invoice) {
            abort(403, 'Acesso não autorizado');
        }

        if ($invoice->delete()) {
            return redirect()
                ->route('admin.finance-refunds.index')
                ->with('success', 'Exclusão realizada!');
        } else {
            return redirect()
                ->back()
                ->with('error', 'Erro ao excluir!');
        }
    }

    public function pay($id)
    {
        if (!Auth::user()->hasPermissionTo('Editar Reembolsos')) {
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

        $invoice = Invoice::where('id', $id)->where('type', 'reembolso')->where(function ($query) use ($subsidiaries) {
            $query->whereIn('subsidiary_id', $subsidiaries->pluck('id'))
                ->orWhere('subsidiary_id', null);
        })->first();

        if (!$invoice) {
            abort(403, 'Acesso não autorizado');
        }

        $invoice->status = 'pago';

        if ($invoice->update()) {
            return redirect()
                ->route('admin.finance-refunds.index')
                ->with('success', 'Reembolso marcada como paga!');
        } else {
            return redirect()
                ->back()
                ->with('error', 'Erro ao atualizar!');
        }
    }

    public function receive($id)
    {
        if (!Auth::user()->hasPermissionTo('Editar Reembolsos')) {
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

        $invoice = Invoice::where('id', $id)->where('type', 'reembolso')->where(function ($query) use ($subsidiaries) {
            $query->whereIn('subsidiary_id', $subsidiaries->pluck('id'))
                ->orWhere('subsidiary_id', null);
        })->first();

        if (!$invoice) {
            abort(403, 'Acesso não autorizado');
        }

        $invoice->status = 'pendente';

        if ($invoice->update()) {
            return redirect()
                ->route('admin.finance-incomes.index')
                ->with('success', 'Reembolso marcado como pendente!');
        } else {
            return redirect()
                ->back()
                ->with('error', 'Erro ao atualizar!');
        }
    }

    public function pdf($id)
    {
        if (!Auth::user()->hasPermissionTo('Listar Reembolsos')) {
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

        $invoice = Invoice::where('id', $id)->where('type', 'reembolso')->where(function ($query) use ($subsidiaries) {
            $query->whereIn('subsidiary_id', $subsidiaries->pluck('id'))
                ->orWhere('subsidiary_id', null);
        })->first();

        if (!$invoice) {
            abort(403, 'Acesso não autorizado');
        }

        return view('admin.finance.refound.pdf', compact('invoice'));
    }

    public function changeStatus(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('Editar Reembolsos')) {
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
            $invoice = Invoice::where('id', $id)->where('type', 'reembolso')->where(function ($query) use ($subsidiaries) {
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
            ->route('admin.finance-refunds.index')
            ->with('success', 'Reembolsos atualizados!');
    }

    public function batchDelete(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('Excluir Reembolsos')) {
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
            $invoice = Invoice::where('id', $id)->where('type', 'reembolso')->where(function ($query) use ($subsidiaries) {
                $query->whereIn('subsidiary_id', $subsidiaries->pluck('id'))
                    ->orWhere('subsidiary_id', null);
            })->first();
            if (!$invoice) {
                abort(403, 'Acesso não autorizado');
            }
            $invoice->delete();
        }

        return redirect()
            ->route('admin.finance-refunds.index')
            ->with('success', 'Reembolsos excluídos!');
    }

    public function changeValue(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('Editar Reembolsos')) {
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
            $invoice = Invoice::where('id', $id)->where('type', 'reembolso')->where(function ($query) use ($subsidiaries) {
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
            ->route('admin.finance-refunds.index')
            ->with('success', 'Reembolsos atualizados!');
    }
}
