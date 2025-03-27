<div class="container-fluid">
    <table class="table">
        <thead class="table-light">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Invoice No</th>
                <th scope="col">Customer Name</th>
                <th scope="col">Sale Discount</th>
                <th scope="col">Payment Method</th>
                <th scope="col">Payment Status</th>
                <th scope="col">SubTotal</th>
                <th scope="col">GrandTotal</th>
                <th scope="col">Date</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sales as $sale)
                <tr class="text-center">
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $sale->sale_code }}</td>
                    <td>{{ $sale->customer->name }}</td>
                    <td>{{ number_format($sale->sale_discount, 2) }} $</td>
                    <td>{{ $sale->sale_payment?->name ?? 'N/A' }}</td>
                    <td>
                        <span class="
                            d-inline-block 
                            px-2 py-1 rounded 
                            @if(optional($sale->sale_status)->name === 'Partially') bg-warning border border-warning text-white
                            @elseif(optional($sale->sale_status)->name === 'Paid') bg-success border border-success text-white
                            @elseif(optional($sale->sale_status)->name === 'Unpaid') bg-danger border border-danger text-white
                            @endif
                            w-80 h-50 d-flex align-items-center justify-content-center
                        ">
                            {{ optional($sale->sale_status)->name ?? 'N/A' }}
                        </span>
                    </td>
                    
                    <td>{{ number_format($sale->sub_total, 2) }} $</td>
                    <td>{{ number_format($sale->grand_total, 2) }} $</td>                    
                    <td>{{ $sale->sale_date }}</td>
                    <td>

                        <a href="" class="btn btn-info btn-sm btn-edit">
                            <i class="fas fa-pencil-alt"></i>
                            {{ __('Edit') }}
                        </a>


                        <form action="" method="POST" class="d-inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Are you sure you want to delete this Sale?');">
                                <i class="fa fa-trash-alt"></i>
                                {{ __('Delete') }}
                            </button>
                        </form>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{-- <div class="row">
        <div class="col-12 d-flex flex-row flex-wrap">
            <div class="row" style="width: -webkit-fill-available;">
                <div class="col-12 col-sm-6 text-center text-sm-left pl-3" style="margin-block: 20px">
                    {{ __('Showing') }} {{ $categories->firstItem() }} {{ __('to') }} {{ $categories->lastItem() }} {{ __('of') }} {{ $categories->total() }} {{ __('entries') }}
                </div>
                <div class="col-12 col-sm-6 pagination-nav pr-3">
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    </div> --}}
</div>
