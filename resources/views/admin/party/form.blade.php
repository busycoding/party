                @csrf
	            <div class="form-group row{{ $errors->has('title') ? ' has-error' : '' }}">
	                <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Title') }}</label>

	                <div class="col-md-6">
	                    <input id="title" type="text" class="form-control" name="title" value="{{ old('title', $company->title) }}" required autofocus>

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
	                    <input id="slug" type="text" class="form-control" name="slug" value="{{ old('slug', $company->slug) }}">

	                    @if ($errors->has('slug'))
	                        <span class="help-block" role="alert">
	                            <strong>{{ $errors->first('slug') }}</strong>
	                        </span>
	                    @endif
	                </div>
	            </div>
	            <div class="form-group row{{ $errors->has('description') ? ' has-error' : '' }}">
	                <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>

	                <div class="col-md-6">
	                    <textarea id="description" type="text" class="form-control" name="description">{{ old('description', $company->description) }}</textarea>

	                    @if ($errors->has('description'))
	                        <span class="help-block" role="alert">
	                            <strong>{{ $errors->first('description') }}</strong>
	                        </span>
	                    @endif
	                </div>
	            </div>
	            @if($categories->count())
				<div class="form-group row{{ $errors->has('category_id') ? ' has-error' : '' }}">
	                <label for="category_id" class="col-md-4 col-form-label text-md-right">{{ __('Category') }}</label>
<!-- todo: figure this out for editing -->
	                <div class="col-md-6">
	                    <select id="category_id" type="text" class="form-control" name="category_id">
	                    	<option value="">Choose Category</option>
	                    	@foreach ($categories as $category)
	                    		<option value="{{$category->id}}"{{ old('category_id') == $category->id || $category->id == $company->category_id ? " selected" : "" }}>{{$category->title}}</option>
	                    	@endforeach
	                    </select>

	                    @if ($errors->has('category_id'))
	                        <span class="help-block" role="alert">
	                            <strong>{{ $errors->first('category_id') }}</strong>
	                        </span>
	                    @endif
	                </div>
	            </div>
	            @endif
	            <div class="form-group row{{ $errors->has('image') ? ' has-error' : '' }}">
	                <label for="image" class="col-md-4 col-form-label text-md-right">{{ __('Image') }}</label>

	                <div class="col-md-6">
	                    
						<div class="fileinput fileinput-new" data-provides="fileinput">
						  <div class="fileinput-new img-thumbnail" style="width: 200px; height: 150px;">
						    <img src="{{ ($company->image_thumb_url) ? $company->image_thumb_url : 'http://placehold.it/200x150&text=No+Image'}}"  alt="...">
						  </div>
						  <div class="fileinput-preview fileinput-exists img-thumbnail" style="max-width: 200px; max-height: 150px;"></div>
						  <div>
						    <span class="btn btn-outline-secondary btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span><input id="image" type="file" class="form-control" name="image" value="{{ old('image') }}"></span>
						    <a href="#" class="btn btn-outline-secondary fileinput-exists" data-dismiss="fileinput">Remove</a>
						  </div>
						</div>

	                    @if ($errors->has('image'))
	                        <span class="help-block" role="alert">
	                            <strong>{{ $errors->first('image') }}</strong>
	                        </span>
	                    @endif
	                </div>
	            </div>
	            <div class="form-group row{{ $errors->has('tags') ? ' has-error' : '' }}">
	                <label for="tags" class="col-md-4 col-form-label text-md-right">{{ __('Tags') }}</label>

	                <div class="col-md-6">
	                	<div style="display:none;">@if (old('tags')) {{ old('tags', $tags) }} @else @foreach ($tags as $tag){{ $tag }},@endforeach @endif</div>
	                	<!-- loading tags from script -->
	                    <input id="tags" type="text" class="form-control" name="tags" value="">

	                    @if ($errors->has('tags'))
	                        <span class="help-block" role="alert">
	                            <strong>{{ $errors->first('tags') }}</strong>
	                        </span>
	                    @endif
	                </div>
	            </div>
                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Register') }}
                        </button>
                    </div>
                </div>