@extends('layouts.app')

@section('content')

<div class="">
    <div class="card m-5 p-5">
        <h1>Create User</h1>
        <form action="{{ route('pages.users.store') }}" method="post">
            @csrf
            <div class="">
                    <div class="form-group">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <input type="text" class="form-control" id="password" name="password" required>
                    </div>
                </div>
                <div class="mb-3 d-flex justify-content-end">
                    <a href="{{ route('pages.users.index') }}"
                        class="btn btn-secondary me-2">Cancel</a>
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection