<div class="container-fluid">
    <table class="table">
        <thead class="table-light">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Product Name</th>
                <th scope="col">Category</th>
                <th scope="col">Quantity</th>
                <th scope="col">Price</th>
                <th scope="col">Description</th>
                {{-- <th scope="col">Status</th> --}}
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @if ($products->count() > 0)
                @foreach ($products as $product)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $product->product_name }}</td>
                        <td>{{ $product->category_id ? $product->category->name : 'No category' }}</td>
                        <td>{{ $product->qty }}</td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->description }}</td>
                        {{-- <td>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input switcher_input status" id="status_{{ $product->id }}" data-id="{{ $product->id }}" {{ $product->status == 1 ? 'checked' : '' }} name="status">
                                <label class="custom-control-label" for="status_{{ $product->id }}"></label>
                            </div>
                        </td> --}}
                        <td>
                            @can('product.edit')
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-pencil-alt"></i>
                                {{ __('Edit') }}
                            </a>
                            @endcan
                            @can('product.delete')
                            <form action="{{ route('admin.products.delete', $product->id) }}" method="POST"
                                class="d-inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure you want to delete this product?');">
                                    <i class="fa fa-trash-alt"></i>
                                    {{ __('Delete') }}
                                </button>
                            </form>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="8" class="text-center text-red-500">No data found</td>
                    <!-- Display message in table -->
                </tr>
            @endif
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="d-flex justify-content-between">
        <div>
            {{ __('Showing') }} {{ $products->firstItem() }} {{ __('to') }} {{ $products->lastItem() }}
            {{ __('of') }} {{ $products->total() }} {{ __('entries') }}
        </div>
        <div class="text-left">
            {{ $products->links() }} <!-- Pagination links -->
        </div>
    </div>
</div>
