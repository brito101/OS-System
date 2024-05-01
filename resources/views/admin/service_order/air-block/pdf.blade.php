@extends('admin.components.pdf')

@section('title', 'FICHA TÉCNICA ORÇAMENTÁRIA DE BLOQUEADOR DE AR')

@section('content')
    <div>
        <table style="width: 100%; margin: 0; padding: 0;">
            <tr>
                <td colspan="10">Nº orçamento/ID:<span style="letter-spacing: .1rem;"> _______________________</span></td>
                <td colspan="2" style="text-align: right;">Data<span style="letter-spacing: .1rem;"> ______________</span>
                </td>
            </tr>
            <tr>
                <td colspan="12">Rep. Comercial:<span style="letter-spacing: .1rem;">
                        ___________________________________________________________________</span>
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
                <td colspan="10">Nome:<span style="letter-spacing: .1rem;">
                        ____________________________________________________</span></td>
                <td colspan="2" style="text-align: right;">Idade<span style="letter-spacing: .1rem;">
                        _______________</span>
                </td>
            </tr>
            <tr>
                <td colspan="10">Endereço:<span style="letter-spacing: .1rem;">
                        _________________________________________________</span></td>
                <td colspan="2" style="text-align: right;">nº<span style="letter-spacing: .1rem;">
                        __________________</span>
                </td>
            </tr>
            <tr>
                <td colspan="5">Bairro: <span style="letter-spacing: .1rem;">______________________</span></td>
                <td colspan="3">CEP: <span style="letter-spacing: .1rem;">____________</span></td>
                <td colspan="3">Cidade: <span style="letter-spacing: .1rem;"> _______________</span></td>
                <td colspan="2" style="text-align: right;">Estado: <span style="letter-spacing: .1rem;">___</span></td>
            </tr>
        </table>
    </div>
@endsection
