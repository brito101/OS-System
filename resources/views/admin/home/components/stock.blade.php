{{-- Inventory --}}
<div class="row">
    <div class="card col-12">
        <div class="card-header">
            Estoque Consolidado {{ date('Y') }}
        </div>
        <div class="card-body" style="max-height: 300px; overflow-y: auto;">
            <div class="table-responsive-lg">
                <table class="table table-bordered table-hover table-striped">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">Produto</th>
                            <th scope="col">Jan</th>
                            <th scope="col">Fev</th>
                            <th scope="col">Mar</th>
                            <th scope="col">Abr</th>
                            <th scope="col">Mai</th>
                            <th scope="col">Jun</th>
                            <th scope="col">Jul</th>
                            <th scope="col">Ago</th>
                            <th scope="col">Set</th>
                            <th scope="col">Out</th>
                            <th scope="col">Nov</th>
                            <th scope="col">Dez</th>
                        </tr>

                    </thead>
                    <tbody>
                        @foreach ($stocks as $product)
                            <tr>
                                <th scope="row">{{ $product['product'] }}</th>
                                @foreach ($product['months'] as $month)
                                    <td>{{ $month }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
