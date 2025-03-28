<div class="card">
    <div class="card-header">
        <h3 class="card-title">Exchange Rate</h3>
    </div>
    <div class="card-body">
        <div class="d-flex justify-content-end">
            <div class="col-sm-6">
                <a class="btn btn-primary float-right" href="{{ route('admin.exchangeRate.create') }}">
                    <i class="fa fa-plus-circle"></i>
                    {{ __('Add New') }}
                </a>
            </div>     
        </div>
        <table class="table">
            <thead class="table-light">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">name</th>
                    <th scope="col">From Currency</th>
                    <th scope="col">To Currency</th>
                    <th scope="col">Exchange Rate</th>
                    {{-- <th scope="col">Note</th> --}}
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($exchangeRates as $exchangeRate) 
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $exchangeRate->name }}</td>
                    <td>{{ optional($exchangeRate->fromCurrency)->name ?? 'N/A' }}</td>
                    <td>{{ optional($exchangeRate->toCurrency)->name ?? 'N/A' }}</td>
                    <td>{{ number_format($exchangeRate->exchange_rate, 2) }}</td>
                    {{-- <td>{{ $exchangeRate->note }}</td> --}}
                    <td>
                        <a href="{{ route('admin.exchangeRate.edit', $exchangeRate->id) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-pencil-alt"></i>
                            {{ __('Edit') }}
                        </a>
                        <form action="{{ route('admin.exchangeRate.delete', $exchangeRate->id) }}" method="POST" class="d-inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Are you sure you want to delete this product?');">
                                <i class="fa fa-trash-alt"></i>
                                {{ __('Delete') }}
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
