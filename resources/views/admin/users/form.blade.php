                @csrf
	            <div class="form-group row{{ $errors->has('name') ? ' has-error' : '' }}">
	                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

	                <div class="col-md-6">
	                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}" autofocus>

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
	                    <input id="slug" type="text" class="form-control" name="slug" value="{{ old('slug', $user->slug) }}">

	                    @if ($errors->has('slug'))
	                        <span class="help-block" role="alert">
	                            <strong>{{ $errors->first('slug') }}</strong>
	                        </span>
	                    @endif
	                </div>
	            </div>
	            <div class="form-group row{{ $errors->has('email') ? ' has-error' : '' }}">
	                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email') }}</label>

	                <div class="col-md-6">
	                    <input id="email" type="text" class="form-control" name="email" value="{{ old('email', $user->email) }}">

	                    @if ($errors->has('email'))
	                        <span class="help-block" role="alert">
	                            <strong>{{ $errors->first('email') }}</strong>
	                        </span>
	                    @endif
	                </div>
	            </div>
	            <div class="form-group row{{ $errors->has('password') ? ' has-error' : '' }}">
	                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

	                <div class="col-md-6">
	                	<!-- {{ old('password', $user->password) }} -->
	                    <input id="password" type="password" class="form-control" name="password">

	                    @if ($errors->has('password'))
	                        <span class="help-block" role="alert">
	                            <strong>{{ $errors->first('password') }}</strong>
	                        </span>
	                    @endif
	                </div>
	            </div>
	            <div class="form-group row{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
	                <label for="password_confirmation" class="col-md-4 col-form-label text-md-right">{{ __('Password Confirmation') }}</label>

	                <div class="col-md-6">
	                	<!-- {{ old('password_confirmation', $user->password_confirmation) }} -->
	                    <input id="password_confirmation" type="password" class="form-control" name="password_confirmation">

	                    @if ($errors->has('password_confirmation'))
	                        <span class="help-block" role="alert">
	                            <strong>{{ $errors->first('password_confirmation') }}</strong>
	                        </span>
	                    @endif
	                </div>
	            </div>
	            <div class="form-group row{{ $errors->has('role') ? ' has-error' : '' }}">
	                <label for="password_confirmation" class="col-md-4 col-form-label text-md-right">{{ __('Role') }}</label>

	                <div class="col-md-6">

	               		@if ($user->exists && ($user->id == config('cms.default_user_id') || isset($hideRoleDropdown)))
			                <input id="role" type="hidden" name="role" value="{{ $user->roles->first()->id }}">
			                <p class="form-control-static">{{ $user->roles->first()->display_name }}</p>
			            @else
			                <select id="role" type="text" class="form-control" name="role">
			                    <option value="">Choose Role</option>
			                    <!-- was $user->roles->first()->id $user->exists -->
			                    @foreach ($roles as $key => $value)
			                      <option value="{{$key}}"{{ old('role') == $key || $key == $user_role_id ? " selected" : "" }}>{{$value}}</option>
			                    @endforeach
			                </select>
			            @endif

                      	@if ($errors->has('role'))
	                        <span class="help-block" role="alert">
	                            <strong>{{ $errors->first('role') }}</strong>
	                        </span>
	                    @endif
	                </div>
	            </div>
	            <div class="form-group row">
	                <label for="bio" class="col-md-4 col-form-label text-md-right">{{ __('Bio') }}</label>

	                <div class="col-md-6">
	                    <textarea id="bio" type="text" class="form-control" name="bio">{{ old('bio', $user->bio) }}</textarea>
	                </div>
	            </div>
                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ $user->exists ? 'Update' : 'Save' }}
                        </button>
                        <a href="{{ route('users.index')}}" class="btn btn-default">Cancel</a>
                    </div>
                </div>