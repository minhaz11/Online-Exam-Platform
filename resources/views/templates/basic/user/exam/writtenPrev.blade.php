@extends($activeTemplate.'layouts.master')

@section('content')
   <div class="row justify-content-center">
       <div class="col-md-10 text-center">
        <div class="panel-table-area mt-30">
            <div class="panel-table border--base">
                <div class="panel-card-body">
                    <i class="fas fa-check-circle display-4 text--success"></i>
                    <p class="h3">@lang('Your answer script has been submitted for preview.') <br> @lang('You will be notified shortly while the result will publish.')</p>
                </div>
            </div>
        </div>
       </div>
   </div>
@stop

@push('script')
    
    <script>
        'use strict'
      
        var count = 0; 
            window.onload = function () { 
                if (typeof history.pushState === "function") { 
                    history.pushState("back", null, null);          
                    window.onpopstate = function () { 
                        history.pushState('back', null, null);              
                        if(count == 0){
                            window.location = "{{route('user.exam.list')}}";
                        }
                    }; 
                }
            }  
            setTimeout(function(){count = 0;},200);
  
    </script>

@endpush