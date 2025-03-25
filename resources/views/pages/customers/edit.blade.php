@extends('layouts.app')

@section('content')
<div class="container fluid">
    <div class="">
        <div class="">
            <div class="card m-5 p-5">
                <h1>Edit Customer</h1>
                <form action="{{ route('admin.customers.update', $customer->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $customer->name) }}" required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $customer->phone) }}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" class="form-control" id="email" name="email" value="{{ old('email', $customer->email) }}" required>
                        </div>
                        <div class="mb-3 d-flex justify-content-end">
                            <a href="{{ route('admin.customers.index') }}"
                                class="btn btn-secondary me-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection