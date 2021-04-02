<div class="card-body">
    <div class="row gutters">
        <div class="col-xl-6 col-lglg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="user-name">@lang('site.name')</span>
                    </div>
                    @php $name = isset($user) ? $user->name : old('name'); @endphp
                    <input name="name" type="text" class="form-control" placeholder="name" aria-label="Username"
                           aria-describedby="user-name" value="{{ $name }}">
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-lglg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="user-email">@lang('site.email')</span>
                    </div>
                    @php $email = isset($user) ? $name->email : old('email'); @endphp
                    <input name="email" type="text" class="form-control" placeholder="@lang('site.email')" aria-label="UserEmail"
                           aria-describedby="user-name" value="{{ $email }}">
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-lglg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="user-phone">@lang('site.phone')</span>
                    </div>
                    @php $phone = isset($user) ? $user->email : old('phone'); @endphp
                    <input name="phone" type="tel" class="form-control" placeholder="@lang('site.phone')" aria-label="UserPhone"
                           aria-describedby="user-phone" value="{{ $phone }}">
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-lglg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="user-address">@lang('site.address')</span>
                    </div>
                    @php $address = isset($user) ? $user->address : old('address'); @endphp
                    <input name="address" type="text" class="form-control" placeholder="@lang('site.address')" aria-label="UserAddress"
                           aria-describedby="user-address" value="{{ $address }}">
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-lglg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="user-password">@lang('site.password')</span>
                    </div>
                    @php $password = isset($user) ? $user->password : old('password'); @endphp
                    <input type="password" name="password" class="form-control" placeholder="email" aria-label="UserPassword"
                           aria-describedby="user-password">
                </div>
            </div>
        </div>

        @php
            $models = ['users', 'customers', 'categories', 'ads','packages','orders','user_request'];
            $maps = ['create', 'read', 'update', 'delete'];
        @endphp



       <div class="col-xl-12 col-lglg-12 col-md-12 col-sm-12 col-12">
           <div class="row">
               <div class="col-md-12">
                       <h2>@lang('site.privileges')</h2>
               </div>
           @foreach ($models as $index=>$model)

               <div class="col-md-4 container_check" >
                   <h4>
                       <label><input type="checkbox" name="permissions_{{ $model }}" onchange="check_permission(this, '{{ $model }}');"> {{ __('site.'.$model) }}
                       </label>
                   </h4>
                   <div id="{{ $model }}" style="margin: 10px;">
                       @foreach ($maps as $map)
                           <br>
                           <label>
                               <input checked  type="checkbox" name="permissions[]" @if(!empty($user)) {{ $user->hasPermission($map . '_' . $model) ? 'checked' : '' }} @endif value="{{ $map . '-' . $model }}"/>
                               <span>@lang('site.' . $map)</span>
                           </label>
                       @endforeach

                   </div>
                   <hr>
               </div>
           @endforeach
           </div>
       </div>

    </div>

</div>

