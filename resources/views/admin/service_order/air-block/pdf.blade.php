@extends('admin.components.pdf')

@section('title', 'FICHA TÉCNICA ORÇAMENTÁRIA DE BLOQUEADOR DE AR')

@section('content')
    <div>
        <table style="width: 100%; margin: 0; padding: 0;">
            <tr>
                <td colspan="10">Nº orçamento/ID: <span style="letter-spacing: .1rem;"
                        class="system">{{ $serviceOrder->number_series }}</span></td>
                <td colspan="2" style="text-align: right;">Data<span style="letter-spacing: .1rem;"> ____________</span>
                </td>
            </tr>
            <tr>
                <td colspan="12">Rep. Comercial: <span style="letter-spacing: .1rem;"
                        class="system">{{ $serviceOrder->user->name }}</span>
                </td>
            </tr>
            <tr>
                <td colspan="12"><span class="dot"></span>Bloqueador de Ar</td>
            </tr>
            <tr>
                <td colspan="12" class="td-title">
                    Informações sobre o Condomínio</td>
            </tr>
            <tr>
                <td colspan="10">Nome:<span style="letter-spacing: .1rem;" class="system">
                        {{ $serviceOrder->client->name }}</span></td>
                <td colspan="2" style="text-align: right;">Idade<span style="letter-spacing: .1rem;" class="system">
                        {{ $serviceOrder->client->age }}</span>
                </td>
            </tr>
            <tr>
                <td colspan="10">Endereço:<span style="letter-spacing: .1rem;" class="system">
                        {{ substr($serviceOrder->client->street, 0, 40) }}</span></td>
                <td colspan="2" style="text-align: right;">nº <span style="letter-spacing: .1rem;" class="system">
                        {{ $serviceOrder->client->number }}</span>
                </td>
            </tr>
            <tr>
                <td colspan="5">Bairro: <span style="letter-spacing: .1rem;"
                        class="system">{{ $serviceOrder->client->neighborhood }}</span></td>
                <td colspan="3">CEP: <span style="letter-spacing: .1rem;"
                        class="system">{{ $serviceOrder->client->zipcode }}</span></td>
                <td colspan="3">Cidade: <span style="letter-spacing: .1rem;"
                        class="system">{{ $serviceOrder->client->city }}</span></td>
                <td colspan="2" style="text-align: right;">Estado: <span style="letter-spacing: .1rem;"
                        class="system">{{ $serviceOrder->client->state }}</span></td>
            </tr>
            <tr>
                <td colspan="8">Nome do cliente:<span style="letter-spacing: .1rem;"
                        class="system">{{ substr($serviceOrder->client->contact, 0, 40) }}</span></td>
                <td colspan="4" style="text-align: right;">Função/Cargo:<span style="letter-spacing: .1rem;"
                        class="system">{{ substr($serviceOrder->client->contact_function, 0, 40) }}</span>
                </td>
            </tr>
            <tr>
                <td colspan="6">Contato Cel.:<span style="letter-spacing: .1rem;">
                        ______________________</span></td>
                <td colspan="6" style="text-align: right;">Contato Tel.:<span style="letter-spacing: .1rem;">
                        ______________________</span>
                </td>
            </tr>
            <tr>
                <td colspan="7">E-mail:<span style="letter-spacing: .1rem;">
                        __________________________________</span></td>
                <td colspan="5" style="text-align: right;">Data de Assembleia:<span style="letter-spacing: .1rem;">
                        _________________</span>
                </td>
            </tr>
            <tr>
                <td colspan="12" class="td-title">
                    Dados para Instalação do Bloqueador de Ar</td>
            </tr>
            <tr>
                <td colspan="4"> Nº Unidades:<span style="letter-spacing: .1rem;">
                        ______</span></td>
                <td colspan="8">Nº Blocos:<span style="letter-spacing: .1rem;">
                        ______</span>
                </td>
            </tr>
            <tr>
                <td colspan="7">Qual o tipo de tubulação:<span style="letter-spacing: .1rem;">
                        _________________</span></td>
                <td colspan="5" style="text-align: right;">Qual o diâmetro da tubulação?<span
                        style="letter-spacing: .1rem;">
                        ____________</span>
                </td>
            </tr>
            <tr>
                <td colspan="12">Tem espaço na tubulação para instalação próximo ao hidrômetro: _____ se não,
                    verificar a
                </td>
            </tr>
            <tr>
                <td colspan="12">tubulação até saída na boia do reservatório inferior para saber onde instalaria.</td>
            </tr>
            <tr>
                <td colspan="12">___________________________________________________________________________</td>
            </tr>
            <tr>
                <td colspan="21" style="padding-top:205px;">
                    Observações:________________________________________________________________</td>
            </tr>
            <tr>
                <td colspan="12">___________________________________________________________________________</td>
            </tr>
            <tr>
                <td colspan="12">___________________________________________________________________________</td>
            </tr>
            <tr>
                <td colspan="12">___________________________________________________________________________</td>
            </tr>
            <tr>
                <td colspan="12" style="text-align: center; padding-top:20px;">Tirar fotos do hidrômetro e anexar!</td>
            </tr>
        </table>
    </div>
@endsection
