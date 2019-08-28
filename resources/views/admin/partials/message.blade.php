@if(session('message'))
    <div class="alert alert-info">
        {{ session('message') }}
    </div>
@elseif(session('error-message'))
    <div class="alert alert-danger">
        {{ session('error-message') }}
    </div>
@elseif(session('trash-message'))
    <?php list($message, $companyId) = session('trash-message') ?>

	<form action="{{ route('admin.party.restore', $companyId) }}" method="POST">
	    @csrf
	    {{ method_field('PUT') }}
        <div class="alert alert-info">
            {{ $message }}
            <button type="submit" class="btn btn-sm btn-warning"><i class="fa fa-undo"></i> Undo</button>
        </div>
    </form>
@endif
