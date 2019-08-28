<table class="table table-bordered">
	<thead>
		<tr>
			<td>Action</td>
			<td>Title</td>
			<td>User</td>
			<td>Category</td>
			<td>Date</td>
		</tr>
	</thead>
	<tbody>
    <?php $request = request(); ?>
    @foreach($companies as $company)
      <tr>
          <td>
              <form action="{{ route('admin.party.restore', $company->id) }}" method="POST" style="display:inline-block;">
                @csrf
                {{ method_field('PUT') }}
                
                @if (check_user_permissions($request, "Party@restore", $company->id))
                    <button title="Restore" class="btn btn-xs btn-default">
                        <i class="fa fa-refresh"></i>
                    </button>
                @else
                    <button title="Restore" onclick="return false;" class="btn btn-xs btn-default disabled">
                        <i class="fa fa-refresh"></i>
                    </button>
                @endif
              </form>
              <form action="{{ route('admin.party.force_destroy', $company->id) }}" method="POST" style="display:inline-block;">
                @csrf
                {{ method_field('DELETE') }}
               
                @if (check_user_permissions($request, "Party@forceDestroy", $company->id))
                    <button title="Delete Permanent" onclick="return confirm('You are about to delete a post permanently. Are you sure?')" type="submit" class="btn btn-xs btn-danger">
                        <i class="fa fa-times"></i>
                    </button>
                @else
                    <button title="Delete Permanent" onclick="return false;" type="submit" class="btn btn-xs btn-danger disabled">
                        <i class="fa fa-times"></i>
                    </button>
                @endif
              </form>
          </td>
          <td>{{ $company->title }}</td>
          <td>{{ $company->user->name }}</td>
          <td>{{ $company->category->title }}</td>
          <td>
              <abbr title="{{ $company->dateFormatted(true) }}">{{ $company->dateFormatted() }}</abbr>
          </td>
      </tr>
    @endforeach
  </tbody>
</table>