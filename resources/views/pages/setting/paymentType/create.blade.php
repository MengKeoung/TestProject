@extends('layouts.app')

@section('content')
    <div class="container fluid">
        <div class="">
            <div class="card m-5 p-5">
                <h1>Create Payment Type</h1>
                <form action="{{ route('paymentType.store') }}" method="post">
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
                                <label class="required_lable" for="currency">{{ __('currency') }}</label>
                                <select name="currency" id="currency"
                                    class="form-control select2 @error('currency') is-invalid @enderror">
                                    <option value="">{{ __('Select currency') }}</option>
                                    @foreach ($currencies as $id => $name)
                                        <option value="{{ $id }}"
                                            {{ old('currency') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                    @endforeach
                                </select>
                                @error('currency')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="status">{{ __('Status') }}</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="1">{{ __('Active') }}</option>
                                    <option value="0">{{ __('Inactive') }}</option>
                                </select>
                                @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="my-5 d-flex justify-content-end">
                            <a href="{{ route('pages.setting.index') }}" class="btn btn-secondary me-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection
