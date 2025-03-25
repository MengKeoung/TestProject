@extends('layouts.app')

@section('content')
    <div class="container fluid">
        <div class="">
            <div class="card m-5 p-5">
                <h1>Create Exchange Rate</h1>
                <form action="{{ route('admin.exchangeRate.store') }}" method="post">
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
                                <label class="required_lable" for="from_currency">{{ __('From Currency') }}</label>
                                <select name="from_currency" id="from_currency"
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
                                <label class="required_lable" for="to_currency">{{ __('To Currency') }}</label>
                                <select name="to_currency" id="to_currency"
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
                                <label for="note" class="form-label">Note</label>
                                <input type="text" class="form-control" id="note" name="note" required>
                            </div>
                        </div>
                        <div class="mb-3 d-flex justify-content-end">
                            <a href="{{ route('admin.setting.index') }}" class="btn btn-secondary me-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection
