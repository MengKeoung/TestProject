<div class="container-fluid">
    <table class="table">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>{{ __('Customer Name') }}</th>
                <th>{{ __('Full Price') }}</th>
                <th>{{ __('Discount Price') }}</th>
                <th>{{ __('Date') }}</th>
                <th>{{ __('Payment Status') }}</th>
                <th>{{ __('Transaction Status') }}</th>
                {{-- <th>{{ __('Created By') }}</th> --}}
                <th>{{ __('Action') }}</th>
            </tr>
        </thead>
        <tbody>
            @if ($transactions->count() > 0)
            @foreach($transactions as $index => $transaction)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    @php
                        $guestInfo = json_decode($transaction->guest_info, true);
                    @endphp
                    @if(!empty($guestInfo) && isset($guestInfo[0]['name']))
                        {{ $guestInfo[0]['name'] }} 
                    @else
                        N/A
                    @endif
                </td>
                <td>{{ number_format($transaction->sub_total,2) }}</td>
                <td>{{ number_format($transaction->final_total,2) }}</td>
                <td>{{ \Carbon\Carbon::parse($transaction->booking_date)->format('M d, Y') }}</td>
                <td>
                    <span class="badge badge-{{ $transaction->payment_status == 'paid' ? 'success' : 'danger' }}">
                        {{ ucfirst($transaction->payment_status) }}
                    </span>
                </td>
                <td>
                    <span class="badge badge-{{ $transaction->status == 'request' ? 'warning' : ($transaction->status == 'confirmed' ? 'primary' : 'secondary') }}">
                        {{ ucfirst($transaction->status) }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('admin.transactions.edit', $transaction->id) }}" class="btn btn-info btn-sm btn-edit">
                        <i class="fas fa-pencil-alt"></i>
                        {{ __('Edit') }}
                    </a>
                    <form action="{{ route('admin.transactions.delete', $transaction->id) }}" method="POST" class="d-inline-block form-delete-{{ $transaction->id }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" data-id="{{ $transaction->id }}" data-href="{{ route('admin.transactions.delete', $transaction->id) }}" class="btn btn-danger btn-sm btn-delete">
                            <i class="fa fa-trash-alt"></i>
                            {{ __('Delete') }}
                        </button>
                    </form>
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
            {{ __('Showing') }} {{ $transactions->firstItem() }} {{ __('to') }} {{ $transactions->lastItem() }}
            {{ __('of') }} {{ $transactions->total() }} {{ __('entries') }}
        </div>
        <div class="text-left">
            {{ $transactions->links() }} <!-- Pagination links -->
        </div>
    </div>
</div>
