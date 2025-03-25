@extends('layouts.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <h1 class="m-3">Users</h1>
                <div class="col-sm-6">
                    <input type="text" id="userSearch" placeholder="Search Users..."
                        class="border p-2 rounded w-full" oninput="searchUsers()">
                </div><!-- /.col -->

                <div class="col-sm-6">
                    @can('user.create')
                    <a class="btn btn-primary float-right" href="{{ route('admin.users.create') }}">
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
            <div id="userResults" class="mt-4">
                @include('pages.users.table', ['users' => $users ?? []])
            </div>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
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

    function searchUsers() {
        let search = document.getElementById('userSearch').value;

        fetch(`/user/search?search=${search}`)
            .then(response => response.text())
            .then(html => {
                document.getElementById('userResults').innerHTML = html;
            })
            .catch(() => {
                document.getElementById('userResults').innerHTML =
                    '<p class="text-red-500">No users found</p>';
            });
    }
</script>
