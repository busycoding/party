<table class="table table-bordered">
	<thead>
		<tr>
			<td>Action</td>
			<td>Category Name</td>
			<td>Post Count</td>
		</tr>
	</thead>
	<tbody>
    @foreach($categories as $category)
      <tr>
          <td>
              <form action="{{ route('admin.categories.destroy', $category->id) }}" enctype="multipart/form-data" method="POST">
                @csrf
                <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-xs btn-default">
                    <i class="fa fa-edit"></i>
                </a>
                {{ method_field('DELETE') }}
                @if($category->id == config('cms.default_category_id'))
                    <button onclick="return false" type="submit" class="btn btn-xs btn-danger disabled">
                        <i class="fa fa-times"></i>
                    </button>
                @else
                    <button onlick="return confirm('Are you sure?')" type="submit" class="btn btn-xs btn-danger">
                        <i class="fa fa-times"></i>
                    </button>
                @endif
              </form>
          </td>
          <td>{{ $category->title }}</td>
          <td>{{ $category->companies->count() }}</td>

      </tr>
    @endforeach
  </tbody>
</table>