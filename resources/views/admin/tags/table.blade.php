<table class="table table-bordered">
	<thead>
		<tr>
			<td>Action</td>
			<td>Name</td>
			<td>Company Count</td>
		</tr>
	</thead>
	<tbody>
    @foreach($tags as $tag)
      <tr>
          <td>
              <form action="{{ route('admin.tags.destroy', $tag->id) }}" enctype="multipart/form-data" method="POST">
                @csrf
                <a href="{{ route('admin.tags.edit', $tag->id) }}" class="btn btn-xs btn-default">
                    <i class="fa fa-edit"></i>
                </a>
                {{ method_field('DELETE') }}
                  <button onlick="return confirm('Are you sure?')" type="submit" class="btn btn-xs btn-danger">
                      <i class="fa fa-times"></i>
                  </button>
              </form>
          </td>
          <td><a href="{{ route('admin.tags.show', $tag->id)}}">{{ $tag->name }}</a></td>
          <td>{{ $tag->companies->count() }}</td>

      </tr>
    @endforeach
  </tbody>
</table>