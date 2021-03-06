<table class="table table-bordered">
	<thead>
		<tr>
			<td>Action</td>
			<td>Name</td>
      <td>Email</td>
      <td>Created</td>
      <td>Role</td>
		</tr>
	</thead>
	<tbody>
    <?php $currentUser = auth()->user(); ?>
    @foreach($users as $user)
      <tr>
          <td>
              <form action="{{ route('admin.users.destroy', $user->id) }}" enctype="multipart/form-data" method="POST">
              </form>
                @csrf
                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-xs btn-default">
                    <i class="fa fa-edit"></i>
                </a>
                {{ method_field('DELETE') }}
                <!-- is default user or can't delete herself -->
                @if($user->id == config('cms.default_user_id') || $user->id == $currentUser->id)
                    <button onclick="return false" type="submit" class="btn btn-xs btn-danger disabled">
                        <i class="fa fa-times"></i>
                    </button>
                @else
                    <a href="{{ route('admin.users.confirm', $user->id)}}" class="btn btn-xs btn-danger">
                        <i class="fa fa-times"></i>
                    </a>
                @endif
              
          </td>
          <td>{{ $user->name }}</td>
          <td>{{ $user->email }}</td>
          <td>{{ $user->created_at->toFormattedDateString() }}</td>
          <td>{{ $user->roles->first() ? $user->roles->first()->display_name : '' }}</td>
      </tr>
    @endforeach
  </tbody>
</table>