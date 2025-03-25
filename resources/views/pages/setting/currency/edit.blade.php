@extends('layouts.app')

@section('content')
    <div class="container fluid">
        <div class="">
            <div class="card m-5 p-5">
                <h1>Edit Currency</h1>
                <form action="{{ route('admin.currency.update', $currency->id) }}" method="post">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $currency->name }}"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="symbol" class="form-label">Symbol</label>
                        <input type="text" class="form-control" id="symbol" name="symbol"
                            value="{{ $currency->symbol }}" required>
                    </div>

                    <div class="mb-3 d-flex justify-content-end">
                        <a href="{{ route('admin.setting.index') }}" class="btn btn-secondary me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
