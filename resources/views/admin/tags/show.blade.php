@extends('layouts.admin.main')

@section('title', "| $tag->name Category List")

@section('content')

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        {{ $tag->name }} Tag
        <small>{{ $tag->companies()->count() }} Posts</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url ('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('admin.tags.index') }}">Tags</a></li>
        <li class="active">{{$tag->name}}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border clearfix">
          <h3 class="box-title">Title</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>


          </div>
			<div class="pull-left">
				<br><br><a href="{{ route('admin.tags.edit', $tag->id) }}" class="btn btn-success">Edit</a>


              <form action="{{ route('admin.tags.destroy', $tag->id) }}" enctype="multipart/form-data" method="POST">
                @csrf
                {{ method_field('DELETE') }}
                  <button onlick="return confirm('Are you sure?')" type="submit" class="btn btn-xs btn-danger">
                      Delete
                  </button>
              </form>
			</div>

      <div class="pull-right">

      </div>
        </div>
        <div class="box-body">
          @include('admin.partials.message')
          @if (!$tag->count())
  			    <div class="alert alert-danger">
  			        <strong>No record found</strong>
  			    </div>
          @else




      <table class="table table-bordered">
        <thead>
          <tr>
            <th>#</th>
            <th>Title</th>
            <th>Tags</th>
            <th></th>
          </tr>
        </thead>

        <tbody>
          <!-- had $tag->companies as $company -->
          @foreach ($companies as $company)
          <tr>
            <th>{{ $company->id }}</th>
            <td>{{ $company->title }}</td>
            <td>
              @foreach ($company->tags as $tag)
                <span class="label label-default">{{ $tag->name }}</span>
              @endforeach
              </td>
            <td><a href="{{ route('admin.party.edit', $company->id ) }}" class="btn btn-default btn-xs">View</a></td>
          </tr>
          @endforeach
        </tbody>
      </table>

  		    @endif
        </div>
        <!-- /.box-body -->
        <div class="box-footer clearfix">
          <div class="pull-left">

          </div>
          <div class="pull-right">

          </div>
        </div>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  


@endsection

@section('script')
    <script type="text/javascript">
        $('ul.pagination').addClass('no-margin pagination-sm');
    </script>
@endsection