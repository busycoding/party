@extends('layouts.admin.main')

@section('title', 'Party List')

@section('content')

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Companies
        <small>Display All Companies</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url ('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('admin.party.index') }}">Companies</a></li>
        <li class="active">All Companies</li>
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
				<br><br><a href="{{ route('admin.party.create') }}" class="btn btn-success">Add New</a>
			</div>

      <div class="pull-right" style="padding:12px 0;">
          <?php $links = [] ?>
          @foreach($statusList as $key => $value)
              @if($value)
                  <?php $selected = Request::get('status') == $key ? 'selected-status' : '' ?>
                  <?php $links[] = "<a class=\"{$selected}\" href=\"?status={$key}\">" . ucwords($key) . "({$value})</a>" ?>
              @endif
          @endforeach
          {!! implode(' | ', $links) !!}
      </div>
        </div>
        <div class="box-body">
          @include('admin.partials.message')
          @if (!$companies->count())
  			    <div class="alert alert-danger">
  			        <strong>No record found</strong>
  			    </div>
          @else
            @if($onlyTrashed)
                @include('admin.party.table-trash')
            @else
                @include('admin.party.table')
            @endif
  		    @endif
        </div>
        <!-- /.box-body -->
        <div class="box-footer clearfix">
			<div class="pull-left">
        <!-- appends is needed, if you are in trash, click page 2, you will be put into company index -->
                {{ $companies->appends( Request::query() )->render() }}
            </div>
            <div class="pull-right">
                <?php //$companiesCount = $companies->count() ?>
                <small>{{ $companiesCount }} {{ str_plural('Item', $companiesCount) }}</small>
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