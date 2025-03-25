@extends('layouts.app')
@push('css')

<style>
    /* The switch - the box around the slider */
    .switch {
      position: relative;
      display: inline-block;
      width: 40px;
      height: 22px;
    }

    /* Hide default HTML checkbox */
    .switch input {
      opacity: 0;
      width: 0;
      height: 0;
    }

    /* The slider */
    .slider {
      position: absolute;
      cursor: pointer;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: #ccc;
      -webkit-transition: .4s;
      transition: .4s;
    }

    .slider:before {
      position: absolute;
      content: "";
      height: 18px;
      width: 18px;
      left: 2px;
      bottom: 2px;
      background-color: white;
      -webkit-transition: .4s;
      transition: .4s;
    }

    input:checked+.slider {
      background-color: #2196F3;
    }

    input:focus+.slider {
      box-shadow: 0 0 1px #2196F3;
    }

    input:checked+.slider:before {
      -webkit-transform: translateX(18px);
      -ms-transform: translateX(18px);
      transform: translateX(18px);
    }

    /* Rounded sliders */
    .slider.round {
      border-radius: 22px;
    }

    .slider.round:before {
      border-radius: 50%;
    }
    .checkIP{
      width: 20px;
    }
  </style>
  @endpush
  @section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{__('Create Role')}}</h1>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form class="form-material form-horizontal" action="{{ route('admin.roles.update', $role->id) }}"
                            method="POST">
                            @csrf
                            @method('PUT')

                        <div class="row">
                            <div class="col-md-12">

                                <div class="form-group">
                                    <label for="name">{{ __('Name Position') }}</label>
                                    <div class="input-group mb-3">
                                        <input type="text" value="{{ $role->name }}" name="name"
                                                class="form-control @error('name') is-invalid @enderror"
                                                placeholder="@lang('Type name permission')">
                                            @error('name')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                    </div>
                                </div>

                            </div>
                        </div>

                        <label style="font-size: 16px;" for="">{{ __('Select Permission') }}</label>
                        @error('permissions')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        <hr>
                        <br>
                        @foreach ($permissions as $permission => $permissionList)
                        <div>
                            <div class="d-flex">
                                <label for="" class="mr-2 mb-3">{{ ucwords($permission) }}</label>
                            </div>

                            <div class="row">
                                @foreach ($permissionList as $perm)
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="input-group mb-3">
                                            <div class="d-flex align-items-center">
                                                <label class="switch">
                                                    <input type="checkbox" id="view_user"
                                                        name="permissions[]"
                                                        @if (in_array($perm->name, $rolePermissions)) checked @endif
                                                        value="{{ $perm->name }}"
                                                        data-toggle="toggle">
                                                    <span class="slider round"></span>
                                                </label>
                                            <label class="ml-2" for="view_user">{{ $perm->display }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <hr>
                        </div>
                        @endforeach
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 col-form-label"></label>
                                    <div class="col-md-8">
                                        <input type="submit" value="{{ __('Submit') }}" class="btn btn-outline btn-primary btn-lg"/>
                                        <a href="{{ route('admin.roles.index') }}" class="btn btn-outline btn-danger btn-lg"><i class="fa fa-ban mr-2"></i>{{ __('Cancel') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

  @endsection
