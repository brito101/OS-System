@extends('adminlte::page')

@section('adminlte_css')
    <style>
        textarea {
            overflow: auto;
        }
    </style>
@endsection

@section('title', '- Funcionário ' . $employee->name)

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-users-cog"></i> Funcionário #{{ $employee->id }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.employees.index') }}">Funcionários</a></li>
                        <li class="breadcrumb-item active">Funcionário</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Dados Cadastrais do Funcionário</h3>
                        </div>
                        <div class="card-body">

                            <div class="d-flex flex-wrap justify-content-between">
                                @if ($employee->photo != null)
                                    <div
                                        class='col-12 col-md-2 align-self-center d-flex justify-content-center justify-content-md-start mb-2 px-0 pr-md-2'>
                                        <img src="{{ url('storage/employees/' . $employee->photo) }}"
                                            alt="{{ $employee->name }}" style="max-width: 100%;"
                                            class="img-thumbnail d-block">
                                    </div>
                                @endif

                                <div
                                    class="col-12 {{ $employee->photo != null ? 'col-md-10 pl-md-2' : '' }}  form-group px-0 d-flex flex-wrap justify-content-start">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="name">Nome</label>
                                        <input type="text" class="form-control bg-white" id="name" name="name"
                                            value="{{ $employee->name }}" disabled>
                                    </div>
                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                        <label for="alias_name">Nome Social</label>
                                        <input type="text" class="form-control bg-white" id="alias_name"
                                            name="alias_name" value="{{ $employee->alias_name }}" disabled>
                                    </div>

                                    <div class="col-12 col-md-4 form-group px-0 pr-md-2">
                                        <label for="genre">Gênero</label>
                                        <input type="text" class="form-control bg-white" id="genre" name="genre"
                                            value="{{ $employee->genre }}" disabled>
                                    </div>
                                    <div class="col-12 col-md-4 form-group px-0 px-md-2">
                                        <label for="birth_date">Data de Nascimento</label>
                                        <input type="date" class="form-control bg-white" id="birth_date"
                                            name="birth_date" value="{{ $employee->birth_date }}" disabled required>
                                    </div>
                                </div>
                            </div>

                            <h5 class="text-muted">Documentação</h5>

                            <div class="d-flex flex-wrap justify-content-between">
                                <div class="col-12 col-md-3 form-group px-0 pr-md-2">
                                    <label for="document_primary">CPF</label>
                                    <input type="text" class="form-control bg-white" id="document_primary"
                                        name="document_primary" value="{{ $employee->document_primary }}" disabled>
                                </div>
                                <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                    <label for="document_secondary">RG</label>
                                    <input type="text" class="form-control bg-white" id="document_secondary"
                                        name="document_secondary" value="{{ $employee->document_secondary }}" disabled>
                                </div>
                                <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                    <label for="driver_license">CNH</label>
                                    <input type="text" class="form-control bg-white" id="driver_license"
                                        name="driver_license" value="{{ $employee->driver_license }}" disabled>
                                </div>
                                <div class="col-12 col-md-3 form-group px-0 pl-md-2">
                                    <label for="voter_registration">Título de Eleitor</label>
                                    <input type="text" class="form-control bg-white" id="voter_registration"
                                        name="voter_registration" value="{{ $employee->voter_registration }}" disabled>
                                </div>
                            </div>

                            <h5 class="text-muted">Dados de Contato</h5>

                            <div class="d-flex flex-wrap justify-content-between">
                                <div class="col-12 col-md-4 form-group px-0 pr-md-2">
                                    <label for="email">E-mail</label>
                                    <input type="text" class="form-control bg-white" id="email" name="email"
                                        value="{{ $employee->email }}" disabled>
                                </div>
                                <div class="col-12 col-md-4 form-group px-0 px-md-2">
                                    <label for="telephone">Telefone</label>
                                    <input type="text" class="form-control bg-white" id="telephone" name="telephone"
                                        value="{{ $employee->telephone }}" disabled>
                                </div>
                                <div class="col-12 col-md-4 form-group px-0 pl-md-2">
                                    <label for="cell">Celular</label>
                                    <input type="text" class="form-control bg-white" id="cell" name="cell"
                                        value="{{ $employee->cell }}" disabled>
                                </div>
                            </div>

                            <h5 class="text-muted">Endereço</h5>

                            <div class="d-flex flex-wrap justify-content-between">
                                <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                    <label for="zipcode">CEP</label>
                                    <input type="text" class="form-control bg-white" id="zipcode" name="zipcode"
                                        value="{{ $employee->zipcode }}" disabled>
                                </div>
                                <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                    <label for="street">Rua</label>
                                    <input type="text" class="form-control bg-white" id="street" name="street"
                                        value="{{ $employee->street }}" disabled>
                                </div>
                            </div>

                            <div class="d-flex flex-wrap justify-content-between">
                                <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                    <label for="number">Número</label>
                                    <input type="text" class="form-control bg-white" id="number" name="number"
                                        value="{{ $employee->number }}" disabled>
                                </div>
                                <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                    <label for="complement">Complemento</label>
                                    <input type="text" class="form-control bg-white" id="complement"
                                        name="complement" value="{{ $employee->complement }}" disabled>
                                </div>
                            </div>

                            <div class="d-flex flex-wrap justify-content-between">
                                <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                    <label for="neighborhood">Bairro</label>
                                    <input type="text" class="form-control bg-white" id="neighborhood"
                                        name="neighborhood" value="{{ $employee->neighborhood }}" disabled>
                                </div>
                                <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                    <label for="city">Cidade</label>
                                    <input type="text" class="form-control bg-white" id="city" name="city"
                                        value="{{ $employee->city }}" disabled>
                                </div>
                                <div class="col-12 col-md-3 form-group px-0 pl-md-2">
                                    <label for="state">Estado</label>
                                    <input type="text" class="form-control bg-white" id="state" name="state"
                                        value="{{ $employee->state }}" disabled>
                                </div>
                            </div>

                            <h5 class="text-muted">Social</h5>

                            <div class="d-flex flex-wrap justify-content-between">
                                <div class="col-12 col-md-4 form-group px-0 pr-md-2">
                                    <label for="marital_status">Estado Civil</label>
                                    <input type="text" class="form-control bg-white" id="marital_status"
                                        name="marital_status" value="{{ $employee->marital_status }}" disabled>
                                </div>
                                <div class="col-12 col-md-4 form-group px-0 px-md-2">
                                    <label for="spouse">Cônjuge</label>
                                    <input type="text" class="form-control bg-white" id="spouse" name="spouse"
                                        value="{{ $employee->spouse }}" disabled>
                                </div>
                                <div class="col-12 col-md-4 form-group px-0 pl-md-2">
                                    <label for="sons">Filhos</label>
                                    <input type="text" class="form-control bg-white" id="sons" name="sons"
                                        value="{{ $employee->sons }}" disabled>
                                </div>
                            </div>

                            <h5 class="text-muted">Dados Bancários</h5>

                            <div class="d-flex flex-wrap justify-content-between">
                                <div class="col-12 col-md-4 form-group px-0 pr-md-2">
                                    <label for="bank">Banco</label>
                                    <input type="text" class="form-control bg-white" id="bank" name="bank"
                                        value="{{ $employee->bank }}" disabled>
                                </div>
                                <div class="col-12 col-md-4 form-group px-0 px-md-2">
                                    <label for="agency">Agência</label>
                                    <input type="text" class="form-control bg-white" id="agency" name="agency"
                                        value="{{ $employee->agency }}" disabled>
                                </div>
                                <div class="col-12 col-md-4 form-group px-0 pl-md-2">
                                    <label for="account">Conta</label>
                                    <input type="text" class="form-control bg-white" id="account" name="account"
                                        value="{{ $employee->account }}" disabled>
                                </div>
                            </div>

                            <h5 class="text-muted">Dados Empregatícios</h5>

                            <div class="d-flex flex-wrap justify-content-between">
                                <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                    <label for="subsidiary_id">Filial</label>
                                    <input type="text" class="form-control bg-white" id="subsidiary_id"
                                        name="subsidiary_id" value="{{ $employee->subsidiary->alias_name }}" disabled>
                                </div>
                                <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                    <label for="role">Cargo/Função</label>
                                    <input type="text" class="form-control bg-white" id="role" name="role"
                                        value="{{ $employee->role }}" disabled>
                                </div>
                            </div>

                            <div class="d-flex flex-wrap justify-content-start">
                                <div class="col-12 col-md-4 form-group px-0 pr-md-2">
                                    <label for="salary">Salário</label>
                                    <input type="text" class="form-control bg-white money_format_2" id="salary"
                                        name="salary" value="{{ $employee->salary }}" disabled>
                                </div>
                                <div class="col-12 col-md-4 form-group px-0 px-md-2">
                                    <label for="admission_date">Data de Admissão</label>
                                    <input type="date" class="form-control bg-white" id="admission_date"
                                        name="admission_date" value="{{ $employee->admission_date }}" disabled required>
                                </div>

                                @if ($employee->resignation_date)
                                    <div class="col-12 col-md-4 form-group px-0 pl-md-2">
                                        <label for="resignation_date">Data de Demissão</label>
                                        <input type="date" class="form-control bg-white" id="resignation_date"
                                            name="resignation_date" value="{{ $employee->resignation_date }}" disabled
                                            required>
                                    </div>
                                @endif
                            </div>

                            @if ($employee->reason_dismissal)
                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 form-group px-0">
                                        <label for="reason_dismissal">Motivo da Demissão</label>
                                        <textarea name="reason_dismissal" class="form-control bg-white" disabled>{{ $employee->reason_dismissal }}</textarea>
                                    </div>
                                </div>
                            @endif

                        </div>

                        <div class="card-footer">
                            <a href="{{ route('admin.employees.pdf', ['id' => $employee->id]) }}" target="_blank"
                                class="btn btn-primary"><i class="fa fa-print"></i> Imprimir</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('custom_js')
    <script src="{{ asset('vendor/jquery/jquery.inputmask.bundle.min.js') }}"></script>
    <script src="{{ asset('js/money.js') }}"></script>
@endsection
