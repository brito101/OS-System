@extends('admin.components.pdf')

@section('title', 'FICHA TÉCNICA ORÇAMENTÁRIA DE BLOQUEADOR DE AR')

@section('content')
    <div>
        <table style="width: 100%; margin: 0; padding: 0;">
            <tr>
                <td colspan="10">Nº orçamento/ID: <span style="letter-spacing: .1rem;"
                        class="system">{{ $serviceOrder->number_series }}</span></td>
                <td colspan="2" style="text-align: right;">Data<span style="letter-spacing: .1rem;"> ___________</span>
                </td>
            </tr>
            <tr>
                @if ($serviceOrder->user->name)
                    <td colspan="12">Rep. Comercial: <span style="letter-spacing: .1rem;"
                            class="system">{{ $serviceOrder->user->name }}</span>
                    </td>
                @else
                    <td colspan="12">Rep. Comercial:<span
                            style="letter-spacing: .1rem;">___________________________________________________________</span>
                    </td>
                @endif
            </tr>
            <tr>
                <td colspan="12"><span class="dot"></span>Bloqueador de Ar</td>
            </tr>
            <tr>
                <td colspan="12" class="td-title">
                    Informações sobre o Condomínio</td>
            </tr>
            <tr>
                @if ($serviceOrder->client->name)
                    <td colspan="10">Nome:<span style="letter-spacing: .1rem;" class="system">
                            {{ $serviceOrder->client->name }}</span></td>
                @else
                    <td colspan="10">Nome:<span
                            style="letter-spacing: .1rem;">_________________________________________________</span></td>
                @endif
                @if ($serviceOrder->client->age)
                    <td colspan="2" style="text-align: right;">Idade<span style="letter-spacing: .1rem;" class="system">
                            {{ $serviceOrder->client->age }}</span>
                    </td>
                @else
                    <td colspan="2" style="text-align: right;">Idade<span
                            style="letter-spacing: .1rem;">____________</span>
                    </td>
                @endif
            </tr>
            <tr>
                @if ($serviceOrder->client->street)
                    <td colspan="10">Endereço:<span style="letter-spacing: .1rem;" class="system">
                            {{ substr($serviceOrder->client->street, 0, 40) }}</span></td>
                @else
                    <td colspan="10">Endereço:<span
                            style="letter-spacing: .1rem;">___________________________________________</span></td>
                @endif
                @if ($serviceOrder->client->number)
                    <td colspan="2" style="text-align: right;">nº <span style="letter-spacing: .1rem;" class="system">
                            {{ $serviceOrder->client->number }}</span>
                    </td>
                @else
                    <td colspan="2" style="text-align: right;">nº <span
                            style="letter-spacing: .1rem;">____________</span>
                    </td>
                @endif
            </tr>
            <tr>
                @if ($serviceOrder->client->neighborhood)
                    <td colspan="5">Bairro: <span style="letter-spacing: .1rem;"
                            class="system">{{ $serviceOrder->client->neighborhood }}</span></td>
                @else
                    <td colspan="5">Bairro: <span style="letter-spacing: .1rem;">__________________</span></td>
                @endif
                @if ($serviceOrder->client->neighborhood)
                    <td colspan="3">CEP: <span style="letter-spacing: .1rem;"
                            class="system">{{ $serviceOrder->client->zipcode }}</span></td>
                @else
                    <td colspan="3">CEP: <span style="letter-spacing: .1rem;">__________</span></td>
                @endif
                @if ($serviceOrder->client->city)
                    <td colspan="3">Cidade: <span style="letter-spacing: .1rem;"
                            class="system">{{ $serviceOrder->client->city }}</span></td>
                @else
                    <td colspan="3">Cidade: <span style="letter-spacing: .1rem;">___________</span></td>
                @endif
                @if ($serviceOrder->client->state)
                    <td colspan="2">Estado: <span style="letter-spacing: .1rem;"
                            class="system">{{ $serviceOrder->client->state }}</span></td>
                @else
                    <td colspan="2" style="text-align: right;">Estado: <span style="letter-spacing: .1rem;">__</span>
                    </td>
                @endif
            </tr>
            <tr>
                @if ($serviceOrder->client->contact)
                    <td colspan="8">Nome do cliente: <span style="letter-spacing: .1rem;"
                            class="system">{{ substr($serviceOrder->client->contact, 0, 40) }}</span></td>
                @else
                    <td colspan="8">Nome do cliente:<span
                            style="letter-spacing: .1rem;">____________________________</span></td>
                @endif
                @if ($serviceOrder->client->contact_function)
                    <td colspan="4">Função/Cargo: <span style="letter-spacing: .1rem;"
                            class="system">{{ substr($serviceOrder->client->contact_function, 0, 40) }}</span>
                    </td>
                @else
                    <td colspan="4" style="text-align: right;">Função/Cargo:<span
                            style="letter-spacing: .1rem;">_________________</span>
                    </td>
                @endif
            </tr>
            <tr>
                @if ($serviceOrder->client->cell)
                    <td colspan="6">Contato Cel.: <span style="letter-spacing: .1rem;"
                            class="system">{{ $serviceOrder->client->cell }}</span></td>
                @else
                    <td colspan="6">Contato Cel.: <span style="letter-spacing: .1rem;">___________________</span></td>
                @endif
                @if ($serviceOrder->client->telephone)
                    <td colspan="6">Contato Tel.: <span style="letter-spacing: .1rem;"
                            class="system">{{ $serviceOrder->client->telephone }}</span>
                    </td>
                @else
                    <td colspan="6" style="text-align: right;">Contato Tel.: <span
                            style="letter-spacing: .1rem;">_____________________</span>
                    </td>
                @endif
            </tr>
            <tr>
                @if ($serviceOrder->client->email)
                    <td colspan="7">E-mail: <span style="letter-spacing: .1rem;"
                            class="system">{{ $serviceOrder->client->email }}</span></td>
                @else
                    <td colspan="7">E-mail:<span style="letter-spacing: .1rem;">________________________</span></td>
                @endif
                @if ($serviceOrder->client->meeting)
                    <td colspan="5">Data de Assembleia: <span style="letter-spacing: .1rem;"
                            class="system">{{ $serviceOrder->client->meeting ? date('d/m/Y', strtotime($serviceOrder->client->meeting)) : '' }}</span>
                    </td>
                @else
                    <td colspan="5" style="text-align: right;">Data de Assembleia:<span
                            style="letter-spacing: .1rem;">______________</span></td>
                @endif
            </tr>
            <tr>
                <td colspan="12" class="td-title">
                    Dados para Instalação do Bloqueador de Ar</td>
            </tr>
            <tr>
                @if ($serviceOrder->client->apartments)
                    <td colspan="4"> Nº Unidades: <span style="letter-spacing: .1rem;"
                            class="system">{{ $serviceOrder->client->apartments }}</span></td>
                @else
                    <td colspan="4"> Nº Unidades:<span style="letter-spacing: .1rem;">___________</span></td>
                @endif
                @if ($serviceOrder->client->blocks)
                    <td colspan="8">Nº Blocos: <span style="letter-spacing: .1rem;"
                            class="system">{{ $serviceOrder->client->blocks }}</span></td>
                    </td>
                @else
                    <td colspan="8">Nº Blocos:<span style="letter-spacing: .1rem;">___________</span></td>
                @endif
            </tr>
            <tr>
                <td colspan="7">Qual o tipo de tubulação: <span style="letter-spacing: .1rem;"
                        class="system">{{ substr($serviceOrder->client->type_piping, 0, 20) }}</span></td>
                <td colspan="5">Qual o diâmetro da tubulação?<span style="letter-spacing: .1rem;"
                        class="system">{{ substr($serviceOrder->client->pipe_diameter, 0, 10) }}</span>
                </td>
            </tr>
            @if ($serviceOrder->client->pipe_space == '1' || !$serviceOrder->client->pipe_space == 'true')
                <tr>

                    <td colspan="12">Tem espaço na tubulação para instalação próximo ao hidrômetro? <span
                            class="system">Sim</span></td>
                </tr>
            @else
                <tr>
                    <td colspan="12">Tem espaço na tubulação para instalação próximo ao hidrômetro? <span
                            class="system">Não</span></td>
                </tr>
                <tr>
                    <td colspan="12">Verificar a tubulação até saída na boia do reservatório inferior para saber onde
                        instalaria.</td>
                </tr>
                <tr>
                    <td colspan="12">___________________________________________________________________________</td>
                </tr>
            @endif

            <tr>
                <td colspan="21" style="padding-top:185px;">
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
