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
                <h1 class="m-3">Products</h1>
                <div class="col-sm-6">
                    <input type="text" id="productSearch" placeholder="Search products..." class="border p-2 rounded w-full"
                        oninput="searchProducts()">


                    <select id="category" onchange="filterProducts()" class="w-full p-2 border rounded ms-2">
                        <option value="">All Categories</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div><!-- /.col -->

                <div class="col-sm-6">
                    @can('product.create')
                    <a class="btn btn-primary float-right" href="{{ route('admin.products.create') }}">
                        <i class="fa fa-plus-circle"></i>
                        {{ __('Add New') }}
                    </a>
                    @endcan
                </div>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Main row -->
            <div id="productResults" class="mt-4">
                @include('pages.products.table', ['products' => $products ?? []])
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

    function searchProducts() {
        let search = document.getElementById('productSearch').value;

        fetch(`/products/search?search=${search}`)
            .then(response => response.text())
            .then(html => {
                document.getElementById('productResults').innerHTML = html;
            })
            .catch(() => {
                document.getElementById('productResults').innerHTML =
                    '<p class="text-red-500">No products found</p>';
            });
    }

    function filterProducts() {
        const categoryId = document.getElementById('category').value;

        fetch(`/products/filter?category_id=${categoryId}`)
            .then(response => {
                if (!response.ok) throw new Error('Failed to fetch products');
                return response.text();
            })
            .then(html => {
                const table = document.getElementById('productResults');
                if (!table) throw new Error('Product table not found in DOM');
                table.innerHTML = html;
            })
            .catch(error => {
                console.error(error);
                document.getElementById('productResults').innerHTML =
                    '<p class="text-red-500">Failed to load products.</p>';
            });
    }

    $('input.status').on('change', function() {
        $.ajax({
            type: "get",
            url: "{{ route('admin.products.update_status') }}",
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
</script>
