                @csrf
	            <div class="form-group row{{ $errors->has('name') ? ' has-error' : '' }}">
	                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

	                <div class="col-md-6">
	                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name', $permission->name) }}" autofocus>

	                    @if ($errors->has('name'))
	                        <span class="help-block" role="alert">
	                            <strong>{{ $errors->first('name') }}</strong>
	                        </span>
	                    @endif
	                </div>
	            </div>
	            <div class="form-group row{{ $errors->has('display_name') ? ' has-error' : '' }}">
	                <label for="display_name" class="col-md-4 col-form-label text-md-right">{{ __('Display Name') }}</label>

	                <div class="col-md-6">
	                    <input id="display_name" type="text" class="form-control" name="display_name" value="{{ old('display_name', $permission->display_name) }}">

	                    @if ($errors->has('display_name'))
	                        <span class="help-block" role="alert">
	                            <strong>{{ $errors->first('display_name') }}</strong>
	                        </span>
	                    @endif
	                </div>
	            </div>
	            <div class="form-group row{{ $errors->has('description') ? ' has-error' : '' }}">
	                <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>

	                <div class="col-md-6">
	                    <input id="description" type="text" class="form-control" name="description" value="{{ old('description', $permission->description) }}">

	                    @if ($errors->has('description'))
	                        <span class="help-block" role="alert">
	                            <strong>{{ $errors->first('description') }}</strong>
	                        </span>
	                    @endif
	                </div>
	            </div>
                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ $permission->exists ? 'Update' : 'Save' }}
                        </button>
                        <a href="{{ route('admin.permissions.index')}}" class="btn btn-default">Cancel</a>
                    </div>
                </div>