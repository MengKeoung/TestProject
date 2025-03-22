@extends('layouts.app')

@section('content')
    <div class="container fluid">
        <div class="">
            <div class="card m-5 p-5">
                <h1>Edit Payment Type</h1>
                <form action="{{ route('paymentType.update', $paymenttype->id) }}" method="post">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $paymenttype->name }}"
                            required>
                    </div>

                    <div class="form-group">
                        <label class="required_lable" for="currency">{{ __('Currency') }}</label>
                        <select name="currency_id" id="currency" class="form-control select2 @error('currency_id') is-invalid @enderror">
                            <option value="">{{ __('Select currency') }}</option>
                            @foreach ($currencies as $id => $name)
                                <option value="{{ $id }}" {{ $id == $paymenttype->currency_id ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                        @error('currency_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    

                    <div class="form-group">
                        <label for="status">{{ __('Status') }}</label>
                        <select name="status" id="status" class="form-control">
                            <option value="1" {{ $paymenttype->status == '1' ? 'selected' : '' }}>
                                {{ __('Active') }}</option>
                            <option value="0" {{ $paymenttype->status == '0' ? 'selected' : '' }}>
                                {{ __('Inactive') }}</option>
                        </select>
                        @error('status')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3 d-flex justify-content-end">
                        <a href="{{ route('pages.setting.index') }}" class="btn btn-secondary me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
