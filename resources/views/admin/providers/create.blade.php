@extends('adminlte::page')
@section('plugins.Summernote', true)
@section('plugins.BootstrapSelect', true)

@section('title', '- Cadastro de Fornecedor')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-truck"></i> Novo Fornecedor</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.providers.index') }}">Fornecedores</a></li>
                        <li class="breadcrumb-item active">Novo Fornecedor</li>
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
                            <h3 class="card-title">Dados Cadastrais do Fornecedor</h3>
                        </div>

                        <form method="POST" action="{{ route('admin.providers.store') }}">
                            @csrf
                            <div class="card-body">

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="social_name">Nome Social</label>
                                        <input type="text" class="form-control" id="social_name"
                                            placeholder="Nome social do fornecedor" name="social_name"
                                            value="{{ old('social_name') }}" required>
                                    </div>
                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                        <label for="alias_name">Nome Fantasia</label>
                                        <input type="text" class="form-control" id="alias_name"
                                            placeholder="Nome fantasia do fornecedor" name="alias_name"
                                            value="{{ old('alias_name') }}" required>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-4 form-group px-0 pr-md-2">
                                        <label for="document_company">CNPJ</label>
                                        <input type="text" class="form-control" id="document_company"
                                            placeholder="CNPJ do fornecedor" name="document_company"
                                            value="{{ old('document_company') }}">
                                    </div>

                                    <div class="col-12 col-md-4 form-group px-0 px-md-2">
                                        <label for="document_company_secondary">Inscrição Estadual</label>
                                        <input type="text" class="form-control" id="document_company_secondary"
                                            placeholder="Inscrição estadual do fornecedor" name="document_company_secondary"
                                            value="{{ old('document_company_secondary') }}">
                                    </div>

                                    <div class="col-12 col-md-4 form-group px-0 pl-md-2">
                                        <label for="activity">Ramo de Atividade</label>
                                        <input type="text" class="form-control" id="activity"
                                            placeholder="Atividade do fornecedor" name="activity"
                                            value="{{ old('activity') }}">
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="contact">Pessoa de Contato</label>
                                        <input type="text" class="form-control" id="contact"
                                            placeholder="Nome do contato do fornecedor" name="contact"
                                            value="{{ old('contact') }}">
                                    </div>

                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                        <label for="function">Função</label>
                                        <input type="text" class="form-control" id="function"
                                            placeholder="Função/Cargo do contato" name="function"
                                            value="{{ old('function') }}">
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-4 form-group px-0 pr-md-2">
                                        <label for="email">E-mail</label>
                                        <input type="email" class="form-control" id="email" placeholder="E-mail"
                                            name="email" value="{{ old('email') }}">
                                    </div>

                                    <div class="col-12 col-md-4 form-group px-0 px-md-2">
                                        <label for="telephone">Telefone</label>
                                        <input type="tel" class="form-control" id="telephone" placeholder="Telefone"
                                            name="telephone" value="{{ old('telephone') }}">
                                    </div>
                                    <div class="col-12 col-md-4 form-group px-0 pl-md-2">
                                        <label for="cell">Celular</label>
                                        <input type="tel" class="form-control" id="cell" placeholder="Celular"
                                            name="cell" value="{{ old('cell') }}">
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 form-group px-0">
                                        <label for="payment_conditions">Condições de Pagamento</label>
                                        <input type="text" class="form-control" id="payment_conditions"
                                            placeholder="Parcelado, na entrega, 5% de adiantamento..."
                                            name="payment_conditions" value="{{ old('payment_conditions') }}">
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="average_delivery_time">Tempo Médio de Entrega</label>
                                        <input type="text" class="form-control" id="average_delivery_time"
                                            placeholder="horas, dias, semandas ..." name="average_delivery_time"
                                            value="{{ old('average_delivery_time') }}">
                                    </div>

                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                        <label for="discounts">Condições de Desconto</label>
                                        <input type="text" class="form-control" id="discounts"
                                            placeholder="Fidelidade, a partir de valor x..." name="discounts"
                                            value="{{ old('discounts') }}">
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="products_offered">Produtos/Serviços</label>
                                        <input type="text" class="form-control" id="products_offered"
                                            placeholder="O que é oferecido pelo fornecedor" name="products_offered"
                                            value="{{ old('products_offered') }}">
                                    </div>

                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                        <label for="promotion_funds">Recursos Promocionais</label>
                                        <input type="text" class="form-control" id="promotion_funds"
                                            placeholder="Fundos para promoção" name="promotion_funds"
                                            value="{{ old('promotion_funds') }}">
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="technical_assistance">Assistência Técnica</label>
                                        <input type="text" class="form-control" id="technical_assistance"
                                            placeholder="características da assistêmcia" name="technical_assistance"
                                            value="{{ old('technical_assistance') }}">
                                    </div>

                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                        <label for="total_purchases_previous_year">Total adquirido no ano anterior</label>
                                        <input type="text" class="form-control" id="total_purchases_previous_year"
                                            placeholder="Total de produtos, volume, peso, valores... "
                                            name="total_purchases_previous_year"
                                            value="{{ old('total_purchases_previous_year') }}">
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="zipcode">CEP</label>
                                        <input type="tel" class="form-control" id="zipcode" placeholder="CEP"
                                            name="zipcode" value="{{ old('zipcode') }}">
                                    </div>
                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                        <label for="street">Rua</label>
                                        <input type="text" class="form-control" id="street" placeholder="Rua"
                                            name="street" value="{{ old('street') }}">
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="number">Número</label>
                                        <input type="text" class="form-control" id="number" placeholder="Número"
                                            name="number" value="{{ old('number') }}">
                                    </div>
                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                        <label for="complement">Complemento</label>
                                        <input type="text" class="form-control" id="complement"
                                            placeholder="Complemento" name="complement" value="{{ old('complement') }}">
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="neighborhood">Bairro</label>
                                        <input type="text" class="form-control" id="neighborhood"
                                            placeholder="Bairro" name="neighborhood" value="{{ old('neighborhood') }}">
                                    </div>
                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                        <label for="city">Cidade</label>
                                        <input type="text" class="form-control" id="city" placeholder="Cidade"
                                            name="city" value="{{ old('city') }}">
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="state">Estado</label>
                                        <input type="text" class="form-control" id="state" placeholder="UF"
                                            name="state" value="{{ old('state') }}">
                                    </div>

                                    @php
                                        $config = [
                                            'title' => 'Selecione múltiplos...',
                                            'liveSearch' => true,
                                            'liveSearchPlaceholder' => 'Pesquisar...',
                                            'showTick' => true,
                                            'actionsBox' => true,
                                        ];
                                    @endphp

                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                        <x-adminlte-select-bs id="coverage" name="coverage[]" label="Área de cobertura"
                                            label-class="text-dark bg-white" igroup-size="md" :config="$config" multiple
                                            class="border">
                                            <option value="AC">AC</option>
                                            <option value="AL">AL</option>
                                            <option value="AP">AP</option>
                                            <option value="AM">AM</option>
                                            <option value="BA">BA</option>
                                            <option value="CE">CE</option>
                                            <option value="DF">DF</option>
                                            <option value="ES">ES</option>
                                            <option value="GO">GO</option>
                                            <option value="MA">MA</option>
                                            <option value="MT">MT</option>
                                            <option value="MS">MS</option>
                                            <option value="MG">MG</option>
                                            <option value="PA">PA</option>
                                            <option value="PB">PB</option>
                                            <option value="PR">PR</option>
                                            <option value="PE">PE</option>
                                            <option value="PI">PI</option>
                                            <option value="RJ">RJ</option>
                                            <option value="RN">RN</option>
                                            <option value="RO">RO</option>
                                            <option value="RR">RR</option>
                                            <option value="RS">RS</option>
                                            <option value="SC">SC</option>
                                            <option value="SP">SP</option>
                                            <option value="SE">SE</option>
                                            <option value="TO">TO</option>
                                        </x-adminlte-select-bs>
                                    </div>
                                </div>

                                @php
                                    $config = [
                                        'height' => '100',
                                        'toolbar' => [
                                            // [groupName, [list of button]]
                                            ['style', ['bold', 'italic', 'underline', 'clear']],
                                            ['font', ['strikethrough', 'superscript', 'subscript']],
                                            ['fontsize', ['fontsize']],
                                            ['color', ['color']],
                                            ['para', ['ul', 'ol', 'paragraph']],
                                            ['height', ['height']],
                                            ['table', ['table']],
                                            ['insert', ['link', 'picture', 'video']],
                                            ['view', ['fullscreen', 'codeview', 'help']],
                                        ],
                                    ];
                                @endphp
                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 form-group px-0">
                                        <x-adminlte-text-editor name="observations" label="Observações"
                                            label-class="text-black" igroup-size="md" placeholder="Observações..."
                                            :config="$config" />
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
    <script src="{{ asset('js/address.js') }}"></script>
    <script src="{{ asset('js/phone.js') }}"></script>
    <script src="{{ asset('js/company.js') }}"></script>
@endsection
