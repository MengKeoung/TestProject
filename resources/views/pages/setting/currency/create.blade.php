@extends('layouts.app')

@section('content')
    <div class="container fluid">
        <div class="">
            <div class="card m-5 p-5">
                <h1>create Currency</h1>
                <form action="{{ route('currency.store') }}" method="post">
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
                                <label for="symbol" class="form-label">Symbol</label>
                                <input type="text" class="form-control" id="symbol" name="symbol" required>
                            </div>
                        </div>
                        <div class="mb-3 d-flex justify-content-end">
                            <a href="{{ route('pages.setting.index') }}" class="btn btn-secondary me-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection
