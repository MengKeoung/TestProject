@extends('layouts.app')

@section('content')
    {{-- <body class="hold-transition sidebar-mini layout-fixed"> --}}


    <!-- Preloader -->
    {{-- <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="{{ asset('assets/dist/img/AdminLTELogo.png') }}" alt="AdminLTELogo" height="60" width="60">
      </div>
     --}}
    <!-- Navbar -->
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->


    <!-- Content Wrapper. Contains page content -->
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <h1 class="m-3">Transactions</h1>
                <div class="col-sm-6">
                    <input type="text" id="transactionSearch" placeholder="Search Transactions..."
                        class="border p-2 rounded w-full" oninput="searchTransactions()">

                    <select id="payment_status" onchange="filterTransactions()" class="w-full p-2 border rounded ms-2">
                        <option value="">All Payment Status</option>
                        @foreach ($paymentStatuses as $status)
                            <option value="{{ $status->payment_status }}">{{ $status->payment_status }}</option>
                        @endforeach
                    </select>

                </div><!-- /.col -->

                <div class="col-sm-6">
                    <a class="btn btn-primary float-right" href="{{ route('pages.transactions.create') }}">
                        <i class="fa fa-plus-circle"></i>
                        {{ __('Add New') }}
                    </a>
                </div>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Main row -->
            <div id="transactionResults" class="mt-4">
                @include('pages.transactions.table', ['transactions' => $transactions ?? []])
            </div>
            {{-- @include('pages.products.table') --}}

            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->

    <!-- /.control-sidebar -->
    <!-- ./wrapper -->
@endsection
<script>
    $('.custom-file-input').change(function(e) {
        var reader = new FileReader();
        var preview = $(this).closest('.form-group').find('.preview img');
        console.log(preview);
        reader.onload = function(e) {
            preview.attr('src', e.target.result).show();
        }
        reader.readAsDataURL(this.files[0]);
    });

    function searchTransactions() {
        let search = document.getElementById('transactionSearch').value;

        fetch(`/transaction/search?search=${search}`)
            .then(response => response.text())
            .then(html => {
                document.getElementById('transactionResults').innerHTML = html;
            })
            .catch(() => {
                document.getElementById('transactionResults').innerHTML =
                    '<p class="text-red-500">No transactions found</p>';
            });
    }

    function filterTransactions() {
        var paymentStatus = document.getElementById('payment_status').value;
        $.ajax({
            url: '{{ route('transactions.filter') }}', 
            type: 'GET',
            data: {
                payment_status: paymentStatus,
            },
            success: function(response) {
                $('#transactionResults').html(
                response);
            }
        });
    }
    $('input.status').on('change', function() {
        $.ajax({
            type: "get",
            url: "{{ route('pages.products.update_status') }}",
            data: {
                "id": $(this).data('id')
            },
            dataType: "json",
            success: function(response) {
                if (response.status == 1) {
                    toastr.success(response.msg);
                } else {
                    toastr.error(response.msg);
                }
            }
        });
    });
    $(document).ready(function() {
        const urlParams = new URLSearchParams(window.location.search);
        const msg = urlParams.get('msg');
        if (msg) {
            setTimeout(function() {
                toastr.success(msg);
            }, 2000);
            history.replaceState(null, '', window.location.pathname);
        }
    });
</script>
