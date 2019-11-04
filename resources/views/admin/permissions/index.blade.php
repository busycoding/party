@extends('layouts.admin.main')

@section('title', 'Permission List')

@section('content')

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Permission
        <small>Display All Permission</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url ('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('admin.permissions.index') }}">Permission</a></li>
        <li class="active">All Permission</li>
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
				<br><br><a href="{{ route('admin.permissions.create') }}" class="btn btn-success">Add New</a>
			</div>

      <div class="pull-right">

      </div>
        </div>
        <div class="box-body">
          @include('admin.partials.message')
          @if (!$permissions->count())
  			    <div class="alert alert-danger">
  			        <strong>No record found</strong>
  			    </div>
          @else
              @include('admin.permissions.table')
  		    @endif
        </div>
        <!-- /.box-body -->
        <div class="box-footer clearfix">
			<div class="pull-left">
        <!-- appends is needed, if you are in trash, click page 2, you will be put into company index -->
                {{ $permissions->appends( Request::query() )->render() }}
            </div>
            <div class="pull-right">
                <?php //$permissionCount = $permission->count() ?>
                <small>{{ $permissionsCount }} {{ str_plural('Item', $permissionsCount) }}</small>
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