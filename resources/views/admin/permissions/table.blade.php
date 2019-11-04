<table class="table table-bordered">
	<thead>
		<tr>
			<td>Action</td>
			<td>Name</td>
      <td>Display Name</td>
      <td>Description</td>
		</tr>
	</thead>
	<tbody>
    <?php //$currentUser = auth()->permission(); ?>
    @foreach($permissions as $permission)
      <tr>
          <td>
              <form action="{{ route('admin.permissions.destroy', $permission->id) }}" enctype="multipart/form-data" method="POST">
                @csrf
                <a href="{{ route('admin.permissions.edit', $permission->id) }}" class="btn btn-xs btn-default">
                    <i class="fa fa-edit"></i>
                </a>
                {{ method_field('DELETE') }}
                <button onlick="return confirm('Are you sure?')" type="submit" class="btn btn-xs btn-danger">
                  <i class="fa fa-times"></i>
                </button>
              </form>
          </td>
          <td>{{ $permission->name }}</td>
          <td>{{ $permission->display_name }}</td>
          <td>{{ $permission->description }}</td>
      </tr>
    @endforeach
  </tbody>
</table>