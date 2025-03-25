<div class="container-fluid">
    <table class="table">
        <thead class="table-light">
            <tr>
                <th scope="col">#</th>
                <th scope="col">{{__('Roles')}}</th>
                <th scope="col">{{__('Action')}}</th>
            </tr>
        </thead>
        <tbody>
            @if($roles)
                @foreach ($roles as $role)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $role->name }}</td>
                        <td>
                            {{-- Only show edit and delete buttons if the role is not 'admin' --}}
                            {{-- @if ($role->name != 'admin') --}}
                                {{-- Edit Button --}}
                                {{-- @if (auth()->user()->can('role.edit')) --}}
                                    <a href="{{ route('admin.roles.edit', $role->id) }}" class="btn btn-info btn-sm btn-edit">
                                        <i class="fas fa-pencil-alt"></i> {{ __('Edit') }}
                                    </a>
                                {{-- @endif --}}
        
                                {{-- Delete Button --}}
                                {{-- @if (auth()->user()->can('role.delete')) --}}
                                    <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" class="d-inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Are you sure you want to delete this Role?');">
                                            <i class="fa fa-trash-alt"></i> {{ __('Delete') }}
                                        </button>
                                    </form>
                                {{-- @endif --}}
                            {{-- @endif --}}
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>               
    </table>
    {{-- <div class="row">
        <div class="col-12 d-flex flex-row flex-wrap">
            <div class="row" style="width: -webkit-fill-available;">
                <div class="col-12 col-sm-6 text-center text-sm-left pl-3" style="margin-block: 20px">
                    {{ __('Showing') }} {{ $categories->firstItem() }} {{ __('to') }} {{ $categories->lastItem() }} {{ __('of') }} {{ $categories->total() }} {{ __('entries') }}
                </div>
                <div class="col-12 col-sm-6 pagination-nav pr-3">
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    </div> --}}
</div>
