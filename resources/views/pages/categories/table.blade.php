<div class="container-fluid">
    <table class="table">
        <thead class="table-light">
          <tr>
            <th scope="col">#</th>
            <th scope="col">Category Name</th>
            {{-- <th scope="col">Status</th> --}}
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
        @foreach ($categories as $category)
          <tr>
            <th scope="row">{{ $loop->iteration }}</th>
            <td>{{ $category->name }}</td>
            {{-- <td>
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input switcher_input status" id="status_{{ $category->id }}" data-id="{{ $category->id }}" {{ $category->status == 1 ? 'checked' : '' }} name="status">
                    <label class="custom-control-label" for="status_{{ $category->id }}"></label>
                </div>
            </td> --}}
            <td>
                @can('category.edit')
                <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-info btn-sm">
                    <i class="fas fa-pencil-alt"></i>
                    {{ __('Edit') }}
                </a>
                @endcan
                @can('category.delete')
                <form action="{{ route('admin.categories.delete', $category->id) }}" method="POST" class="d-inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this category?');">
                        <i class="fa fa-trash-alt"></i>
                        {{ __('Delete') }}
                    </button>
                </form>
                @endcan
            </td>                            
          </tr>
        @endforeach
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