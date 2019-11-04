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
    <?php //$currentUser = auth()->role(); ?>
    @foreach($roles as $role)
      <tr>
          <td>
              <form action="{{ route('admin.roles.destroy', $role->id) }}" enctype="multipart/form-data" method="POST">
                @csrf
                <a href="{{ route('admin.roles.edit', $role->id) }}" class="btn btn-xs btn-default">
                    <i class="fa fa-edit"></i>
                </a>
                {{ method_field('DELETE') }}
                <button onlick="return confirm('Are you sure?')" type="submit" class="btn btn-xs btn-danger">
                  <i class="fa fa-times"></i>
                </button>
              </form>
          </td>
          <td>{{ $role->name }}</td>
          <td>{{ $role->display_name }}</td>
          <td>{{ $role->description }}</td>
      </tr>
    @endforeach
  </tbody>
</table>