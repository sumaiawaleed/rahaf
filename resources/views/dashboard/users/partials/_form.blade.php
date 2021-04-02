@php
    $name = isset($form_data) ?  $form_data->name : old("name");
    $email = isset($form_data) ?  $form_data->email : old("email");

@endphp

<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
    <div class="form-group">
        <label for="name_input">@lang('site.name')</label>
        <input value="{{ $name }}" type="text" name="name"
               class="form-control" id="{{ 'name_input' }}"
               placeholder="@lang('site.name')">
        <span class="form_error" id="name_error"></span>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
    <div class="form-group">
        <label for="name_input">@lang('site.email')</label>
        <input value="{{ $email }}" type="email" name="email"
               class="form-control" id="{{ 'email_input' }}"
               placeholder="@lang('site.email')">
        <span class="form_error" id="email_error"></span>
    </div>
</div>

@if(!isset($form_data))
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="form-group">
            <label for="name_input">@lang('site.password')</label>
            <input type="password"
                   name="password"
                   class="form-control"
                   id="password_input" placeholder="@lang('site.password')">
            <span class="form_error" id="password_error"></span>
        </div>
    </div>


    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="form-group">
            <label for="name_input">@lang('site.password_confirmation')</label>
            <input type="password"
                   name="password_confirmation"
                   class="form-control"
                   id="password_confirmation_input" placeholder="@lang('site.password_confirmation')">
            <span class="form_error" id="password_confirmation_error"></span>
        </div>
    </div>
@endif

@php
    $models = ['categories','products','users','quantities',
     'customers','drivers','orders','brands','coupons','colors','dollar_cost',
     'reports','favorites','rates'];
  $maps = ['create', 'read', 'update', 'delete'];
@endphp
<div class="row">
    @foreach ($models as $index=>$model)
        <div class="col-md-4 container_check">
            <h4>
                <label><input type="checkbox" name="permissions_{{ $model }}"
                              onchange="check_permission(this, '{{ $model }}');"> {{ __('site.'.$model) }}
                </label>
            </h4>
            <div id="{{ $model }}" style="margin: 10px;">
                @foreach ($maps as $map)
                    <br>
                    <label class="form-group ichack-input">
                        <input  class="minimal container_check sub_permissions_{{ $model }}" type="checkbox" name="permissions[]"
                               @if(!empty($form_data)) {{ $form_data->hasPermission($model . '-' . $map) ? 'checked' : '' }} @endif value="{{ $model . '-' . $map }}"/>
                        <span>@lang('site.' . $map)</span>
                    </label>
                @endforeach

            </div>
            <hr>
        </div>
    @endforeach
</div>

<script>
    function check_permission(source, name) {
        if(source.checked){
            $('.sub_permissions_' + name).prop('checked', true);
        }else{
            $('.sub_permissions_' + name).prop('checked', false);
        }
    }

    function check_permission_all(source) {
        if (source.checked) {
            $('input').prop('checked', true);
        } else {
            $('input').prop('checked', false);
        }
    }
</script>
