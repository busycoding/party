
<div id="app">
                @csrf
                @if ($permission->exists)

                @else
                    <input type="radio" v-model="permissionType" name="permission_type" value="basic">Basic Permission
                    <input type="radio" v-model="permissionType" name="permission_type" value="crud">CRUD Permission
                @endif







              <div class="field" v-if="permissionType == 'basic'">




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
              </div>

          <div class="field" v-if="permissionType == 'crud'">
            <label for="resource" class="label">Resource</label>
            <p class="control">
              <input type="text" class="input" name="resource" id="resource" v-model="resource" placeholder="The name of the resource">
            </p>
          </div>


              <div class="columns" v-if="permissionType == 'crud'">
                <div class="column is-one-quarter">
                    <div class="field">
                      <input type="checkbox" v-model="crudSelected" value="create">Create
                    </div>
                    <div class="field">
                      <input type="checkbox" v-model="crudSelected" value="read">Read
                    </div>
                    <div class="field">
                      <input type="checkbox" v-model="crudSelected" value="update">Update
                    </div>
                    <div class="field">
                      <input type="checkbox" v-model="crudSelected" value="delete">Delete
                    </div>
                </div> <!-- end of .column -->

                <input type="hidden" name="crud_selected" :value="crudSelected">
@{{resource.length}}
@{{crudSelected.length}}
                <div class="column">
                  <table class="table" v-if="resource.length >= 3 && crudSelected.length > 0">
                    <thead>
                      <th>Display Name</th>
                      <th>Name</th>
                      <th>Description</th>
                    </thead>
                    <tbody>
                      <tr v-for="item in crudSelected">
                        <td v-text="crudName(item)"></td>
                        <td v-text="crudSlug(item)"></td>
                        <td v-text="crudDescription(item)"></td>
                      </tr>
                    </tbody>
                  </table>
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
</div>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
  <script type="text/javascript">
    var app = new Vue({
      el: '#app',
      data: {
        permissionType: 'basic',
        resource: '',
        crudSelected: ['create', 'read', 'update', 'delete']
      },
      methods: {
        crudName: function(item) {
          return item.substr(0,1).toUpperCase() + item.substr(1) + " " + app.resource.substr(0,1).toUpperCase() + app.resource.substr(1);
        },
        crudSlug: function(item) {
          return item.toLowerCase() + "-" + app.resource.toLowerCase();
        },
        crudDescription: function(item) {
          return "Allow a User to " + item.toUpperCase() + " a " + app.resource.substr(0,1).toUpperCase() + app.resource.substr(1);
        }
      }
    });
  </script>



  <script src="{{ asset('js/app.js') }}"></script>
