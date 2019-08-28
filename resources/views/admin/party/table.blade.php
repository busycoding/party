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
              <form action="{{ route('admin.party.destroy', $company->id) }}" enctype="multipart/form-data" method="POST">
                @csrf
                @if (check_user_permissions($request, "Party@edit", $company->id))
                    <a href="{{ route('admin.party.edit', $company->id) }}" class="btn btn-xs btn-default">
                        <i class="fa fa-edit"></i>
                    </a>
                @else
                    <a href="#" class="btn btn-xs btn-default disabled">
                        <i class="fa fa-edit"></i>
                    </a>
                @endif

                @if (check_user_permissions($request, "Party@destroy", $company->id))
                    <button type="submit" class="btn btn-xs btn-danger">
                      <i class="fa fa-trash-o"></i>
                  </button>
                @else
                    <button type="button" onclick="return false;" class="btn btn-xs btn-danger disabled">
                        <i class="fa fa-trash-o"></i>
                    </button>
                @endif
                
                {{ method_field('DELETE') }}
                
              </form>
          </td>
          <td>{{ $company->title }}</td>
          <td>{{ $company->user->name }}</td>
          <td>{{ $company->category->title }}</td>
          <td>
              <abbr title="{{ $company->dateFormatted(true) }}">{{ $company->dateFormatted() }}</abbr> |
              {!! $company->approvedLabel() !!}
          </td>
      </tr>
    @endforeach
  </tbody>
</table>