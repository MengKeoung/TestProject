<div class="card">
    <div class="card-header">
        <h3 class="card-title">Currency</h3>
    </div>
    <div class="card-body">
        <div class="d-flex justify-content-end">
            <div class="col-sm-6">
                <a class="btn btn-primary float-right" href="{{ route('currency.create') }}">
                    <i class="fa fa-plus-circle"></i>
                    {{ __('Add New') }}
                </a>
            </div>     
        </div>
        <table class="table">
            <thead class="table-light">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Currency</th>
                    <th scope="col">Symbol</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($currencies as $currency) 
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $currency->name }}</td>
                    <td>{{ $currency->symbol }}</td>
                    <td>
                        <a href="{{ route('currency.edit', $currency->id) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-pencil-alt"></i>
                            {{ __('Edit') }}
                        </a>
                        <form action="{{ route('currency.delete', $currency->id) }}" method="POST" class="d-inline-block">
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
