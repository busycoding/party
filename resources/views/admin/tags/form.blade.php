                @csrf
	            <div class="form-group row{{ $errors->has('name') ? ' has-error' : '' }}">
	                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Title') }}</label>

	                <div class="col-md-6">
	                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name', $tag->name) }}" required autofocus>

	                    @if ($errors->has('name'))
	                        <span class="help-block" role="alert">
	                            <strong>{{ $errors->first('name') }}</strong>
	                        </span>
	                    @endif
	                </div>
	            </div>
	            <div class="form-group row{{ $errors->has('slug') ? ' has-error' : '' }}">
	                <label for="slug" class="col-md-4 col-form-label text-md-right">{{ __('Slug') }}</label>

	                <div class="col-md-6">
	                    <input id="slug" type="text" class="form-control" name="slug" value="{{ old('slug', $tag->slug) }}">

	                    @if ($errors->has('slug'))
	                        <span class="help-block" role="alert">
	                            <strong>{{ $errors->first('slug') }}</strong>
	                        </span>
	                    @endif
	                </div>
	            </div>
                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ $tag->exists ? 'Update' : 'Save' }}
                        </button>
                        <a href="{{ route('admin.categories.index')}}" class="btn btn-default">Cancel</a>
                    </div>
                </div>