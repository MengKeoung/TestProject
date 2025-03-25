@extends('layouts.app')

@section('content')
<div class="container fluid">
    <div class="">
        <div class="">
            <div class="card m-5 p-5">
                <h1>Edit category</h1>
                <form action="{{ route('admin.categories.update', $category->id) }}" method="post">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $category->name }}" required>
                    </div>
                    <!-- Status -->
                    <div class="form-group col-md-6">
                        <label for="status">{{ __('Status') }}</label>
                        <select name="status" id="status" class="form-control">
                            <option value="1" {{ $category->status == '1' ? 'selected' : '' }}>
                                {{ __('Active') }}</option>
                            <option value="0" {{ $category->status == '0' ? 'selected' : '' }}>
                                {{ __('Inactive') }}</option>
                        </select>
                        @error('status')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3 d-flex justify-content-end">
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection