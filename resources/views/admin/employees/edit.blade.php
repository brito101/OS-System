@extends('adminlte::page')
@section('plugins.select2', true)
@section('plugins.BsCustomFileInput', true)

@section('title', '- Edição de Funcionário')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-users-cog"></i> Editar Funcionário #{{ $employee->id }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.employees.index') }}">Funcionários</a></li>
                        <li class="breadcrumb-item active">Editar Funcionário</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    @include('components.alert')

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Dados Cadastrais do Funcionário</h3>
                        </div>

                        <form method="POST" action="{{ route('admin.employees.update', ['employee' => $employee->id]) }}"
                            enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <input type="hidden" name="id" value="{{ $employee->id }}">
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
                                        class="col-12 {{ $employee->photo != null ? 'col-md-10 pl-md-2' : '' }}  form-group px-0 d-flex flex-wrap justify-content-between">
                                        <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                            <label for="name">Nome *</label>
                                            <input type="text" class="form-control" id="name"
                                                placeholder="Nome de Registro" name="name"
                                                value="{{ old('name') ?? $employee->name }}" required>
                                        </div>
                                        <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                            <label for="alias_name">Nome Social</label>
                                            <input type="text" class="form-control" id="alias_name"
                                                placeholder="Nome Social caso exista" name="alias_name"
                                                value="{{ old('alias_name') ?? $employee->alias_name }}">
                                        </div>

                                        <div class="col-12 col-md-4 form-group px-0 pr-md-2 mb-0">
                                            <label for="genre">Gênero</label>
                                            <x-adminlte-select2 name="genre">
                                                <option
                                                    {{ old('genre') == '' ? 'selected' : ($employee->genre == '' ? 'selected' : '') }}
                                                    value="">Não
                                                    Informado</option>
                                                <option
                                                    {{ old('genre') == 'Cisgênero' ? 'selected' : ($employee->genre == 'Cisgênero' ? 'selected' : '') }}
                                                    value="Cisgênero">
                                                    Cisgênero</option>
                                                <option
                                                    {{ old('genre') == 'Feminino' ? 'selected' : ($employee->genre == 'Feminino' ? 'selected' : '') }}
                                                    value="Feminino">
                                                    Feminino</option>
                                                <option
                                                    {{ old('genre') == 'Masculino' ? 'selected' : ($employee->genre == 'Masculino' ? 'selected' : '') }}
                                                    value="Masculino">
                                                    Masculino</option>
                                                <option
                                                    {{ old('genre') == 'Não Binário' ? 'selected' : ($employee->genre == 'Não Binário' ? 'selected' : '') }}
                                                    value="Não Binário">
                                                    Não Binário</option>
                                                <option
                                                    {{ old('genre') == 'Outros' ? 'selected' : ($employee->genre == 'Outros' ? 'selected' : '') }}
                                                    value="Outros">
                                                    Outros</option>
                                                <option
                                                    {{ old('genre') == 'Transgênero' ? 'selected' : ($employee->genre == 'Transgênero' ? 'selected' : '') }}
                                                    value="Transgênero">
                                                    Transgênero</option>
                                            </x-adminlte-select2>
                                        </div>
                                        <div class="col-12 col-md-4 form-group px-0 px-md-2">
                                            <label for="birth_date">Data de Nascimento</label>
                                            <input type="date" class="form-control" id="birth_date" name="birth_date"
                                                value="{{ old('birth_date') ?? $employee->birth_date }}">
                                        </div>

                                        <div class="col-12 col-md-4 form-group px-0 pl-md-2 mb-0">
                                            <x-adminlte-input-file name="photo" label="Foto"
                                                placeholder="Selecione uma imagem..." legend="Selecionar" />
                                        </div>
                                    </div>
                                </div>

                                <h5 class="text-muted">Documentação</h5>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-3 form-group px-0 pr-md-2">
                                        <label for="document_primary">CPF</label>
                                        <input type="text" class="form-control" id="document_person"
                                            placeholder="Nº do CPF" name="document_primary"
                                            value="{{ old('document_primary') ?? $employee->document_primary }}">
                                    </div>
                                    <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                        <label for="document_secondary">RG</label>
                                        <input type="text" class="form-control" id="document_secondary"
                                            placeholder="Nº do RG" name="document_secondary"
                                            value="{{ old('document_secondary') ?? $employee->document_secondary }}">
                                    </div>
                                    <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                        <label for="driver_license">CNH</label>
                                        <input type="text" class="form-control" id="driver_license"
                                            placeholder="Nº da CNH" name="driver_license"
                                            value="{{ old('driver_license') ?? $employee->driver_license }}">
                                    </div>
                                    <div class="col-12 col-md-3 form-group px-0 pl-md-2">
                                        <label for="voter_registration">Título de Eleitor</label>
                                        <input type="text" class="form-control" id="voter_registration"
                                            placeholder="Nº da Título" name="voter_registration"
                                            value="{{ old('voter_registration') ?? $employee->voter_registration }}">
                                    </div>
                                </div>

                                <h5 class="text-muted">Dados de Contato</h5>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-4 form-group px-0 pr-md-2">
                                        <label for="email">E-mail</label>
                                        <input type="email" class="form-control" id="email" placeholder="E-mail"
                                            name="email" value="{{ old('email') ?? $employee->email }}">
                                    </div>
                                    <div class="col-12 col-md-4 form-group px-0 px-md-2">
                                        <label for="telephone">Telefone</label>
                                        <input type="text" class="form-control" id="telephone"
                                            placeholder="Nº do Telefone" name="telephone"
                                            value="{{ old('telephone') ?? $employee->telephone }}">
                                    </div>
                                    <div class="col-12 col-md-4 form-group px-0 pl-md-2">
                                        <label for="cell">Celular</label>
                                        <input type="text" class="form-control" id="cell"
                                            placeholder="Nº do Celular" name="cell"
                                            value="{{ old('cell') ?? $employee->cell }}">
                                    </div>
                                </div>

                                <h5 class="text-muted">Endereço</h5>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="zipcode">CEP</label>
                                        <input type="tel" class="form-control" id="zipcode" placeholder="CEP"
                                            name="zipcode" value="{{ old('zipcode') ?? $employee->zipcode }}">
                                    </div>
                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                        <label for="street">Rua</label>
                                        <input type="text" class="form-control" id="street" placeholder="Rua"
                                            name="street" value="{{ old('street') ?? $employee->street }}">
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="number">Número</label>
                                        <input type="text" class="form-control" id="number" placeholder="Número"
                                            name="number" value="{{ old('number') ?? $employee->number }}">
                                    </div>
                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                        <label for="complement">Complemento</label>
                                        <input type="text" class="form-control" id="complement"
                                            placeholder="Complemento" name="complement"
                                            value="{{ old('complement') ?? $employee->complement }}">
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="neighborhood">Bairro</label>
                                        <input type="text" class="form-control" id="neighborhood"
                                            placeholder="Bairro" name="neighborhood"
                                            value="{{ old('neighborhood') ?? $employee->neighborhood }}">
                                    </div>
                                    <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                        <label for="city">Cidade</label>
                                        <input type="text" class="form-control" id="city" placeholder="Cidade"
                                            name="city" value="{{ old('city') ?? $employee->city }}">
                                    </div>
                                    <div class="col-12 col-md-3 form-group px-0 pl-md-2">
                                        <label for="state">Estado</label>
                                        <input type="text" class="form-control" id="state" placeholder="UF"
                                            name="state" value="{{ old('state') ?? $employee->state }}">
                                    </div>
                                </div>

                                <h5 class="text-muted">Social</h5>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-4 form-group px-0 pr-md-2">
                                        <label for="marital_status">Estado Civil</label>
                                        <x-adminlte-select2 name="marital_status">
                                            <option
                                                {{ old('marital_status') == '' ? 'selected' : ($employee->marital_status == '' ? 'selected' : '') }}
                                                value="">Não
                                                Informado</option>
                                            <option
                                                {{ old('genre') == 'Casado' ? 'selected' : ($employee->marital_status == 'Casado' ? 'selected' : '') }}
                                                value="Casado">
                                                Casado</option>
                                            <option
                                                {{ old('genre') == 'Solteiro' ? 'selected' : ($employee->marital_status == 'Solteiro' ? 'selected' : '') }}
                                                value="Solteiro">
                                                Solteiro</option>
                                            <option
                                                {{ old('genre') == 'União Estável' ? 'selected' : ($employee->marital_status == 'União Estável' ? 'selected' : '') }}
                                                value="União Estável">
                                                União Estável</option>
                                            <option
                                                {{ old('genre') == 'Viúvo' ? 'selected' : ($employee->marital_status == 'Viúvo' ? 'selected' : '') }}
                                                value="Viúvo">
                                                Viúvo</option>
                                        </x-adminlte-select2>
                                    </div>
                                    <div class="col-12 col-md-4 form-group px-0 px-md-2">
                                        <label for="spouse">Cônjuge</label>
                                        <input type="text" class="form-control" id="spouse"
                                            placeholder="Nome do Cônjuge" name="spouse"
                                            value="{{ old('spouse') ?? $employee->spouse }}">
                                    </div>
                                    <div class="col-12 col-md-4 form-group px-0 pl-md-2">
                                        <label for="sons">Filhos</label>
                                        <input type="number" min="0" class="form-control" id="sons"
                                            placeholder="Nº de Filhos" name="sons"
                                            value="{{ old('sons') ?? $employee->sons }}">
                                    </div>
                                </div>

                                <h5 class="text-muted">Dados Bancários</h5>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-4 form-group px-0 pr-md-2">
                                        <label for="bank">Banco</label>
                                        <input type="bank" class="form-control" id="bank"
                                            placeholder="Nome do Banco" name="bank"
                                            value="{{ old('bank') ?? $employee->bank }}">
                                    </div>
                                    <div class="col-12 col-md-4 form-group px-0 px-md-2">
                                        <label for="agency">Agência</label>
                                        <input type="text" class="form-control" id="agency"
                                            placeholder="Nº da Agência" name="agency"
                                            value="{{ old('agency') ?? $employee->agency }}">
                                    </div>
                                    <div class="col-12 col-md-4 form-group px-0 pl-md-2">
                                        <label for="account">Conta</label>
                                        <input type="text" class="form-control" id="account"
                                            placeholder="Nº da Conta" name="account"
                                            value="{{ old('account') ?? $employee->account }}">
                                    </div>

                                    <div class="col-12 col-md-4 form-group px-0 pr-md-2">
                                        <label for="pix">Chave PIX</label>
                                        <input type="text" class="form-control" id="pix"
                                            placeholder="Chave PIX" name="pix"
                                            value="{{ old('pix') ?? $employee->pix }}">
                                    </div>
                                </div>

                                <h5 class="text-muted">Dados Empregatícios</h5>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2 mb-0">
                                        <label for="subsidiary_id">Filial</label>
                                        <x-adminlte-select2 name="subsidiary_id" id="subsidiary_id">
                                            <option
                                                {{ old('subsidiary_id') == '' ? 'selected' : ($employee->subsidiary_id == '' ? 'selected' : '') }}
                                                value="">Sem
                                                Filial</option>
                                            @foreach ($subsidiaries as $subsidiary)
                                                <option
                                                    {{ old('subsidiary_id') == $subsidiary->id ? 'selected' : ($employee->subsidiary_id == $subsidiary->id ? 'selected' : '') }}
                                                    value="{{ $subsidiary->id }}" data-state={{ $subsidiary->state }}>
                                                    {{ $subsidiary->alias_name }}
                                                </option>
                                            @endforeach
                                        </x-adminlte-select2>
                                    </div>
                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                        <label for="role">Cargo/Função</label>
                                        <input type="text" class="form-control" id="role"
                                            placeholder="Nome do Cargo/Função" name="role"
                                            value="{{ old('role') ?? $employee->role }}">
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-4 form-group px-0 pr-md-2">
                                        <label for="salary">Salário</label>
                                        <input type="text" class="form-control money_format_2" id="salary"
                                            placeholder="Valor em Reais" name="salary"
                                            value="{{ old('salary') ?? $employee->salary }}">
                                    </div>
                                    <div class="col-12 col-md-4 form-group px-0 px-md-2">
                                        <label for="admission_date">Data de Admissão</label>
                                        <input type="date" class="form-control" id="admission_date"
                                            placeholder="Data de Admissão" name="admission_date"
                                            value="{{ old('admission_date') ?? $employee->admission_date }}">
                                    </div>
                                    <div class="col-12 col-md-4 form-group px-0 pl-md-2">
                                        <label for="resignation_date">Data de Demissão</label>
                                        <input type="date" class="form-control" id="resignation_date"
                                            placeholder="Data de Demissão" name="resignation_date"
                                            value="{{ old('resignation_date') ?? $employee->resignation_date }}">
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 form-group px-0">
                                        <label for="reason_dismissal">Motivo da Demissão</label>
                                        <textarea name="reason_dismissal" class="form-control" placeholder="Motivo da Demissão">{{ old('reason_dismissal') ?? $employee->reason_dismissal }}</textarea>
                                    </div>
                                </div>


                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Enviar</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('custom_js')
    <script src="{{ asset('vendor/jquery/jquery.inputmask.bundle.min.js') }}"></script>
    <script src="{{ asset('js/phone.js') }}"></script>
    <script src="{{ asset('js/document-person.js') }}"></script>
    <script src="{{ asset('js/address.js') }}"></script>
    <script src="{{ asset('js/money.js') }}"></script>
@endsection
