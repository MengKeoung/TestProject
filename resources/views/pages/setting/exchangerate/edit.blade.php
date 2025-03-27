@extends('layouts.app')

@section('content')
    <div class="container fluid">
        <div class="card m-5 p-5">
            <h1>Update Exchange Rate</h1>
            <form action="{{ route('admin.exchangeRate.update', $exchangeRate->id) }}" method="post">
                @csrf
                @method('PUT') <!-- Make sure this is here for the PUT request -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $exchangeRate->name }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exchange_rate" class="form-label">Exchange Rate</label>
                            <input type="text" class="form-control" id="exchange_rate" name="exchange_rate" value="{{ number_format($exchangeRate->exchange_rate, 2) }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="required_lable" for="from_currency">{{ __('From Currency') }}</label>
                            <select name="from_currency" id="from_currency" class="form-control select2">
                                <option value="">{{ __('Select currency') }}</option>
                                @foreach ($currencies as $id => $name)
                                    <option value="{{ $id }}" {{ old('from_currency', $exchangeRate->from_currency) == $id ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="required_lable" for="to_currency">{{ __('To Currency') }}</label>
                            <select name="to_currency" id="to_currency" class="form-control select2">
                                <option value="">{{ __('Select currency') }}</option>
                                @foreach ($currencies as $id => $name)
                                    <option value="{{ $id }}" {{ old('to_currency', $exchangeRate->to_currency) == $id ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="note" class="form-label">Note</label>
                            <input type="text" class="form-control" id="note" name="note" value="{{ $exchangeRate->note }}">
                        </div>
                    </div>
                </div>
                <div class="mb-3 d-flex justify-content-end">
                    <a href="{{ route('admin.setting.index') }}" class="btn btn-secondary me-2">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>            
        </div>
    </div>
@endsection
