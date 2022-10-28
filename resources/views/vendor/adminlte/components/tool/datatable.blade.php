{{-- Table --}}

<div class="table-responsive">

    <table id="{{ $id }}" style="width:100%" {{ $attributes->merge(['class' => $makeTableClass()]) }}>

        {{-- Table head --}}
        <thead @isset($headTheme) class="thead-{{ $headTheme }}" @endisset>
            <tr>
                @foreach ($heads as $th)
                    <th @isset($th['width']) style="width:{{ $th['width'] }}%" @endisset
                        @isset($th['no-export']) dt-no-export @endisset>
                        {{ is_array($th) ? $th['label'] ?? '' : $th }}
                    </th>
                @endforeach
            </tr>
        </thead>

        {{-- Table body --}}
        <tbody>{{ $slot }}</tbody>

        {{-- Table footer --}}
        @isset($withFooter)
            <tfoot @isset($footerTheme) class="thead-{{ $footerTheme }}" @endisset>
                <tr>
                    @foreach ($heads as $th)
                        <th>{{ is_array($th) ? $th['label'] ?? '' : $th }}</th>
                    @endforeach
                </tr>
            </tfoot>
        @endisset

    </table>

</div>

{{-- Add plugin initialization and configuration code --}}

@push('js')
    @if (isset($withFooter) && $withFooter == 'invoice')
        <script>
            $(() => {
                let {{ $id }} = $('#{{ $id }}').DataTable(
                        {!! substr(json_encode($config), 0, -1) !!},
                        "footerCallback": function(tfoot, data, start, end, display) {
                            var api = this.api();
                            let balance = 0;
                            let payed = 0;
                            let unpayed = 0;
                            data.forEach(el => {
                                if (el['status'] == 'pago') {
                                    payed += el['amount'];
                                } else if (el['status'] == 'pendente') {
                                    unpayed += el['amount'];
                                }
                            });

                            balance = payed - unpayed;

                            payed = payed.toLocaleString('pt-br', {
                                style: 'currency',
                                currency: 'BRL'
                            });

                            unpayed = unpayed.toLocaleString('pt-br', {
                                style: 'currency',
                                currency: 'BRL'
                            });

                            balance = balance.toLocaleString('pt-br', {
                                style: 'currency',
                                currency: 'BRL'
                            });

                            $(api.column(0).footer()).html('');
                            $(api.column(1).footer()).html('');
                            $(api.column(2).footer()).html('');
                            $(api.column(3).footer()).html('');
                            $(api.column(4).footer()).html(`Pago: ${payed}`);
                            $(api.column(5).footer()).html(`Pendente: ${unpayed}`);
                            $(api.column(6).footer()).html(`Balanço: ${balance}`);

                            $(tfoot).html(
                                `<th colspan="10" class="text-left">
                            Pago: ${payed} | Pendente: ${unpayed} | Balanço: ${balance}</th>`
                            );
                        }
                    },
            );
            })
        </script>
    @elseif (isset($withFooter) && $withFooter == 'purchase')
        <script>
            $(() => {
                let {{ $id }} = $('#{{ $id }}').DataTable(
                        {!! substr(json_encode($config), 0, -1) !!},
                        "footerCallback": function(tfoot, data, start, end, display) {
                            var api = this.api();
                            let balance = 0;
                            let exec = 0;
                            let unexec = 0;
                            data.forEach(el => {
                                if (el['status'] == 'executada') {
                                    exec += el['amount'];
                                } else if (el['status'] == 'não executada') {
                                    unexec += el['amount'];
                                }
                            });

                            balance = exec - unexec;

                            exec = exec.toLocaleString('pt-br', {
                                style: 'currency',
                                currency: 'BRL'
                            });

                            unexec = unexec.toLocaleString('pt-br', {
                                style: 'currency',
                                currency: 'BRL'
                            });

                            balance = balance.toLocaleString('pt-br', {
                                style: 'currency',
                                currency: 'BRL'
                            });

                            $(api.column(0).footer()).html('');
                            $(api.column(1).footer()).html('');
                            $(api.column(2).footer()).html('');
                            $(api.column(3).footer()).html('');
                            $(api.column(4).footer()).html(`Pago: ${exec}`);
                            $(api.column(5).footer()).html(`Pendente: ${unexec}`);
                            $(api.column(6).footer()).html(`Balanço: ${balance}`);

                            $(tfoot).html(
                                `<th colspan="10" class="text-left">
                        Exec: ${exec} | Não Exec: ${unexec} | Balanço: ${balance}</th>`
                            );
                        }
                    },
            );
            })
        </script>
    @else
        <script>
            $(() => {
                $('#{{ $id }}').DataTable(@json($config));
            })
        </script>
    @endif
@endpush

{{-- Add CSS styling --}}

@isset($beautify)
    @push('css')
        <style type="text/css">
            #{{ $id }} tr td,
            #{{ $id }} tr th {
                vertical-align: middle;
                text-align: center;
            }
        </style>
    @endpush
@endisset
