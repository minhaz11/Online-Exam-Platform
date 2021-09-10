@extends($activeTemplate.'layouts.master')

@section('content')
<div class="reset-area mt-30">
    <div class="panel panel-default">
        <div class="panel-card-header bg--primary text-white">
           <div class="panel-card-title"><i class="las la-user"></i> @lang('Change Your Password')</div>
         </div>
        <div class="panel-form-area">
            <form class="panel-form" action="" method="POST">
                @csrf
                <div class="row justify-content-center">
                    <div class="col-lg-12 form-group">
                        <label>@lang('Current Password')</label>
                        <input type="password" name="current_password" class="form-control" placeholder="@lang('Current Password')" required>
                    </div>
                    <div class="col-lg-12 form-group">
                        <label>@lang('Password')</label>
                        <input type="password" name="password" class="form-control" placeholder="@lang('Password')" required>
                    </div>
                    <div class="col-lg-12 form-group">
                        <label>@lang('Confirm Password')</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="@lang('Confirm Password')" required>
                    </div>
                    <div class="col-lg-12 form-group">
                        <button type="submit" class="btn--primary border--rounded text-white btn-block p-2">@lang('Change Password')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
       
@endsection

