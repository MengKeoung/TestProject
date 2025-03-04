@extends('layouts.app')

@section('content')
    <div class="container fluid">
        <div class="">
            <div class="">
                <div class="card m-5 p-5">
                    <h1>Edit Product</h1>
                    <form action="{{ route('pages.products.update', $product->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col">
                                <!-- Product Name -->
                                <div class="form-group">
                                    <label for="product_name" class="form-label">Product Name</label>
                                    <input type="text" class="form-control" id="product_name" name="product_name" value="{{ old('product_name', $product->product_name) }}" required>
                                </div>
                                <!-- Quantity -->
                                <div class="form-group">
                                    <label for="qty" class="form-label">Quantity</label>
                                    <input type="text" class="form-control" id="qty" name="qty" value="{{ old('qty', $product->qty) }}">
                                </div>
                                <!-- Discount Type -->
                                <div class="form-group">
                                    <label for="discount_type">{{ __('Discount Type') }}</label>
                                    <select name="discount_type" id="discount_type" class="form-control">
                                        <option value="Percent"
                                            {{ $product->discount_type == 'Percent' ? 'selected' : '' }}>
                                            {{ __('Percent') }}</option>
                                        <option value="Amount"
                                            {{ $product->discount_type == 'Amount' ? 'selected' : '' }}>
                                            {{ __('Amount') }}</option>
                                    </select>
                                    @error('discount_type')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <!-- Status -->
                                <div class="form-group">
                                    <label for="status">{{ __('Status') }}</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="1" {{ $product->status == '1' ? 'selected' : '' }}>
                                            {{ __('Active') }}</option>
                                        <option value="0" {{ $product->status == '0' ? 'selected' : '' }}>
                                            {{ __('Inactive') }}</option>
                                    </select>
                                    @error('status')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <!-- Image -->
                            <div class="form-group">
                                <label for="exampleInputFile">{{__('Image')}}</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="exampleInputFile" name="image">
                                        <label class="custom-file-label" for="exampleInputFile">{{ __('Choose file') }}</label>
                                    </div>
                                </div>
                                <div class="preview text-center border rounded mt-2" style="height: 150px">
                                    <img src="{{ asset('uploads/products/default_image.png') }}" alt="" height="100%">
                                </div>
                            </div>
                            </div>
                            <div class="col">
                                <!-- Category -->
                                <div class="form-group">
                                    <label class="required_lable" for="category">{{ __('Category') }}</label>
                                    <select name="category" id="category"
                                        class="form-control select2 @error('category') is-invalid @enderror">
                                        <option value="">{{ __('Select category') }}</option>
                                        @foreach ($categories as $id => $name)
                                            <option value="{{ $id }}"
                                                {{ $id == $product->category_id ? 'selected' : '' }}>
                                                {{ $name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="price" class="form-label">Price</label>
                                    <input type="text" class="form-control" id="price" name="price" value="{{ old('price', $product->price) }}" required>
                                </div>
                                <!-- Discount -->
                                <div class="form-group">
                                    <label for="discount">{{ __('Discount') }}</label>
                                    <input type="text" name="discount" id="discount" class="form-control"
                                        value="{{ $product->discount }}">
                                    @error('discount')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <!-- Description -->
                                <div class="form-group">
                                    <label for="description">{{ __('Description') }}</label>
                                    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                                        rows="3">{{ old('description', $product->description) }}</textarea>
                                    @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 d-flex justify-content-end">
                                <a href="{{ route('pages.products.index') }}" class="btn btn-secondary me-2">Cancel</a>
                                <button type="submit" class="btn btn-primary">Create</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function () {            
            $('.custom-file-input').change(function (e) {
                console.log('change');
                var reader = new FileReader();
                var preview = $(this).closest('.form-group').find('.preview img');
                reader.onload = function(e) {
                    preview.attr('src', e.target.result).show();
                }
                reader.readAsDataURL(this.files[0]);
            });
        });

        $(document).on('click', '.nav-tabs .nav-link', function (e) {
            if ($(this).data('lang') != 'en') {
                $('.no_translate_wrapper').addClass('d-none');
            } else {
                $('.no_translate_wrapper').removeClass('d-none');
            }
        });
    </script>
@endpush