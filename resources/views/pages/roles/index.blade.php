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
                <div class="col-sm-6">
                    <h1 class="m-0">Roles</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <a class="btn btn-primary float-right" href="{{ route('pages.roles.create') }}">
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
            
            @include('pages.roles.table')
          
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
<div class="modal fade modal_form" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel"></div>
@endsection

@push('js')
<script>
    $('.btn_add').click(function (e) {
        var tbody = $('.tbody');
        var numRows = tbody.find("tr").length;
        $.ajax({
            type: "get",
            url: window.location.href,
            data: {
                "key" : numRows
            },
            dataType: "json",
            success: function (response) {
                $(tbody).append(response.tr);
            }
        });
    });

    $(document).on('click', '.btn-edit', function(){
        $("div.modal_form").load($(this).data('href'), function(){

            $(this).modal('show');

        });
    });

    $('.custom-file-input').change(function (e) {
        var reader = new FileReader();
        var preview = $(this).closest('.form-group').find('.preview img');
        console.log(preview);
        reader.onload = function(e) {
            preview.attr('src', e.target.result).show();
        }
        reader.readAsDataURL(this.files[0]);
    });

    $(document).on('click', '.btn-delete', function(e) {
    e.preventDefault();

    const customerId = $(this).data('id');
    const deleteUrl = $(this).data('href');
    const form = $(`.form-delete-${customerId}`);
    const data = form.serialize();

    const Confirmation = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    });

    Confirmation.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: deleteUrl,
                data: data,
                dataType: "json",
                success: function(response) {
                    console.log(response);
                    if (response.status === 1) {
                        // Update table without refreshing
                        $('.table-wrapper').html(response.view); 
                        toastr.success(response.msg);
                    } else {
                        toastr.error(response.msg);
                    }
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    toastr.error('Something went wrong!');
                }
            });
        }
    });
});

    $('input.status').on('change', function () {
        $.ajax({
            type: "get",
            url: "",
            data: { "id" : $(this).data('id') },
            dataType: "json",
            success: function (response) {
                if (response.status == 1) {
                    toastr.success(response.msg);
                } else {
                    toastr.error(response.msg);
                }
            }
        });
    });

</script>
@endpush