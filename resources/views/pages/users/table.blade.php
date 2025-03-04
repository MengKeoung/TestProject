<div class="container-fluid" id="userResults">
    <table class="table">
        <thead class="table-light">
            <tr>
                <th scope="col">#</th>
                <th scope="col">User Name</th>
                <th scope="col">Email</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @if ($users->count() > 0)
                @foreach ($users as $user)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <a href="{{ route('pages.users.edit', $user->id) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-pencil-alt"></i>
                                {{ __('Edit') }}
                            </a>
                            <form action="{{ route('pages.users.delete', $user->id) }}" method="POST"
                                class="d-inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure you want to delete this user?');">
                                    <i class="fa fa-trash-alt"></i>
                                    {{ __('Delete') }}
                                </button>
                            </form>
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
