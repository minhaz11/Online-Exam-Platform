@if(\App\Extension::where('act', 'custom-captcha')->where('status', 1)->first())
    <div class="form-group col-md-12">
       
            @php echo  getCustomCaptcha(46,'100') @endphp
            <input type="text" name="captcha" placeholder="@lang('Enter Code')" class="form-control form--control mt-3">
       
    </div>
@endif
