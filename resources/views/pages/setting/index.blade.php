@extends('layouts.app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            {{-- @include('pages.setting.profile') --}}
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    @include('pages.setting.profile')
                </div>
                <div class="col-12">
                    @include('pages.setting.currency.index')
                </div>
                <div class="col-12">
                    @include('pages.setting.paymentType.index')
                </div>
                <div class="col-12">
                    @include('pages.setting.exchangerate.index')
                </div>
            </div>
        </div>
    </div>
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
