<div class="container-fluid" id="userResults">
    <table class="table">
        <thead class="table-light">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Email</th>
                <th scope="col">User Name</th>
                <th scope="col">First Name</th>
                <th scope="col">Last Name</th>
                {{-- <th scope="col">Role</th> --}}
                <th scope="col">Phone</th>
                <th scope="col">Telegram</th>
                <th scope="col">Image</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @if ($users->count() > 0)
                @foreach ($users as $user)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->first_name }}</td>
                        <td>{{ $user->last_name }}</td>
                        {{-- <td>
                            @if($user->roles->isNotEmpty())  
                                @foreach($user->roles as $role)
                                    <span>{{ $role->name }}</span>
                                @endforeach
                            @else
                                <span>No Roles</span>  
                            @endif
                        </td> --}}
                        <td>{{ $user->phone }}</td>
                        <td>{{ $user->telegram }}</td>
                        <td>
                            <img src="{{ asset('uploads/users/' . $user->image) }}" alt="User Image" width="50">
                        </td>
                        
                        <td>
                            @can('user.edit')
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-pencil-alt"></i>
                                {{ __('Edit') }}
                            </a>
                            @endcan
                            @can('user.delete')
                            <form action="{{ route('admin.users.delete', $user->id) }}" method="POST"
                                class="d-inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure you want to delete this user?');">
                                    <i class="fa fa-trash-alt"></i>
                                    {{ __('Delete') }}
                                </button>
                            </form>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="8" class="text-center text-red-500">No data found</td>
                    <!-- Display message in table -->
                </tr>
            @endif
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="d-flex justify-content-between">
        <div>
            {{ __('Showing') }} {{ $users->firstItem() }} {{ __('to') }} {{ $users->lastItem() }}
            {{ __('of') }} {{ $users->total() }} {{ __('entries') }}
        </div>
        <div class="text-left">
            {{ $users->links() }} <!-- Pagination links -->
        </div>
    </div>
</div>
