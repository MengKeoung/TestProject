@extends('layouts.app')

@section('content')
<div class="container fluid">
    <div class="">
        <div class="">
            <div class="card m-5 p-5">
                <h1>Create Customer</h1>
                <form action="{{ route('pages.customers.store') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" class="form-control" id="phone" name="phone" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3 d-flex justify-content-end">
                            <a href="{{ route('pages.customers.index') }}"
                                class="btn btn-secondary me-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection