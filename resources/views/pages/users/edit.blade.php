@extends('layouts.app')

@section('content')

<div class="">
    <div class="card m-5 p-5">
        <h1>Create User</h1>
        <form action="{{ route('admin.users.update', $user->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name"
                        value="{{ old('first_name', $user->first_name) }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" 
                        value="{{ old('last_name', $user->last_name) }}"required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name" class="form-label">User Name</label>
                        <input type="text" class="form-control" id="name" name="name" 
                        value="{{ old('name', $user->name) }}"required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="user_id" class="form-label">User ID</label>
                        <input type="text" class="form-control" id="user_id" name="user_id" 
                        value="{{ old('user_id', $user->user_id) }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control" id="email" name="email" 
                        value="{{ old('email', $user->email) }}"required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="required_lable">{{__('Password')}}</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" value=""
                            name="password" placeholder="{{__('Enter Password')}}" >
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" 
                        value="{{ old('phone', $user->phone) }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="telegram" class="form-label">Telegram</label>
                        <input type="text" class="form-control" id="telegram" name="telegram" 
                        value="{{ old('telegram', $user->telegram) }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="exampleInputFile">{{__('Image')}}</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="exampleInputFile" name="image">
                                <label class="custom-file-label" for="exampleInputFile">{{ $user->image ?? __('Choose file') }}</label>
                            </div>
                        </div>
                        <div class="preview text-center border rounded mt-2" style="height: 150px">
                            <img src="
                            @if ($user->image && file_exists(public_path('uploads/users/' . $user->image)))
                                {{ asset('uploads/users/'. $user->image) }}
                            @else
                                {{ asset('uploads/default-profile.png') }}
                            @endif
                            " alt="" height="100%">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="required_lable" for="role">{{__('Role')}}</label>
                        <select name="role" id="role" class="form-control select2 @error('role') is-invalid @enderror">
                            <option value="">{{ __('Please select role') }}</option>
                            @foreach ($roles as $id => $name)
                                <option value="{{ $id }}" 
                                    {{ $user->roles && $user->roles->isNotEmpty() && $user->roles->first()->id == $id ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                
                        @error('role')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>                
            </div>
            <div class="mb-3 d-flex justify-content-end">
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary me-2">Cancel</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>

@endsection
@push('js')
    <script>
        $('.custom-file-input').change(function (e) {
            var reader = new FileReader();
            var preview = $(this).closest('.form-group').find('.preview img');
            reader.onload = function(e) {
                preview.attr('src', e.target.result).show();
            }
            reader.readAsDataURL(this.files[0]);
        });
    </script>
@endpush