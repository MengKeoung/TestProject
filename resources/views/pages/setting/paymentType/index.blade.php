<div class="card">
    <div class="card-header">
        <h3 class="card-title">Payment Types</h3>
    </div>
    <div class="card-body">
        <div class="d-flex justify-content-end">
            <div class="col-sm-6">
                <a class="btn btn-primary float-right" href="{{ route('admin.paymentType.create') }}">
                    <i class="fa fa-plus-circle"></i>
                    {{ __('Add New') }}
                </a>
            </div>
        </div>
        <table class="table">
            <thead class="table-light">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Payment Type</th>
                    <th scope="col">Currency</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($paymentTypes as $paymentType)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $paymentType->name }}</td>
                        <td>{{ $paymentType->currency_id ? $paymentType->currency->name : 'No Currency' }}</td>
                        <td>{{ $paymentType->status }}</td>
                        <td>
                            <a href="{{ route('admin.paymentType.edit', $paymentType->id) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-pencil-alt"></i>
                                {{ __('Edit') }}
                            </a>
                            <form action="{{ route('admin.paymentType.delete', $paymentType->id) }}" method="POST" class="d-inline-block">
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
