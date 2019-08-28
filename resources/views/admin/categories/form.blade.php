                @csrf
	            <div class="form-group row{{ $errors->has('title') ? ' has-error' : '' }}">
	                <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Title') }}</label>

	                <div class="col-md-6">
	                    <input id="title" type="text" class="form-control" name="title" value="{{ old('title', $category->title) }}" required autofocus>

	                    @if ($errors->has('title'))
	                        <span class="help-block" role="alert">
	                            <strong>{{ $errors->first('title') }}</strong>
	                        </span>
	                    @endif
	                </div>
	            </div>
	            <div class="form-group row{{ $errors->has('slug') ? ' has-error' : '' }}">
	                <label for="slug" class="col-md-4 col-form-label text-md-right">{{ __('Slug') }}</label>

	                <div class="col-md-6">
	                    <input id="slug" type="text" class="form-control" name="slug" value="{{ old('slug', $category->slug) }}">

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
                            {{ $category->exists ? 'Update' : 'Save' }}
                        </button>
                        <a href="{{ route('admin.categories.index')}}" class="btn btn-default">Cancel</a>
                    </div>
                </div>