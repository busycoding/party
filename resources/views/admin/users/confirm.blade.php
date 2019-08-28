@extends('layouts.admin.main')

@section('title', 'Delete Confirmation')

@section('content')

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Companies
        <small>Delete Confirmation</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url ('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('users.index') }}">User</a></li>
        <li class="active">Delete Confirm</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Title</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>


          </div>
        </div>
        <div class="box-body">
          <form method="POST" action="{{ route('users.destroy', $user->id) }}" enctype="multipart/form-data">
            {{ method_field('DELETE') }}
              <div class="col-xs-9">
                  <div class="box">
                      <div class="box-body ">
                          <p>
                              You have specified this user for deletion:
                          </p>
                          <p>
                              ID #{{ $user->id }}: {{ $user->name }}
                          </p>
                          <p>
                              What should be done with content own by this user?
                          </p>
                          <p>
                              <input type="radio" name="delete_option" value="delete" checked> Delete All Content
                          </p>

                          <p>
                              <input type="radio" name="delete_option" value="attribute"> Attribute content to:

                              <select id="selected_user" type="text" class="form-control" name="selected_user">
                                <option value="">Choose User</option>
                                @foreach ($users as $key => $value)
                                  <option value="{{$key}}">{{$value}}</option>
                                @endforeach
                              </select>


                          </p>

                      </div>
                      <div class="box-footer">
                          <button type="submit" class="btn btn-danger">Confirm Deletion</button>
                          <a href="{{ route('users.index') }}" class="btn btn-default">Cancel</a>
                      </div>
                  </div>
              </div>
          </form>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@endsection