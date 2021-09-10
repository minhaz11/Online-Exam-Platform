@extends($activeTemplate.'layouts.master')

@section('content')
<div class="transaction-area">
    <div class="row flex-row-reverse justify-content-center mb-30-none mt-30">
        <div class="col-xl-3 col-md-6 col-sm-6 mb-30">
            <div class="quiz-instruction-area">
                <div class="quiz-instruction-content">
                    <h3 class="title">@lang('Exam Instruction')</h3>
                    <p>@php
                        echo $exam->instruction
                    @endphp</p>
                </div>
            </div>
        </div>
        <div class="col-xl-5 col-md-6 col-sm-6 mb-30">
            <div class="quiz-area">
                <div class="panel-body multi_step_form">
                    <div class="time-tracker">
                        <p>@lang('Time Remaining') : <span id="demo"></span></p>
                    </div>
                    <form id="msform" action="{{route('user.exam.submission.script')}}" method="POST">
                        @csrf
                        <input type="hidden" name="examId" value="{{$exam->id}}">
                        @if ($exam->question_type == 1)
                           
                        @foreach ($questions as $qtn)
                            @php
                             $i = rand(1,2000);
                             if($exam->option_suffle == 1){
                                 $options = $qtn->options->shuffle();
                                } else {
                                 $options = $qtn->options;
                             }
                            @endphp
                        <fieldset>
                            <p class="title h3">@lang($qtn->question)</p>
                            <div class="form-row">
                                <div class="form-group col-lg-12">
                                    <div class="radio-wrapper">
                                        @foreach ($options as $opt)
                                            <div class="radio-item">
                                                <input type="radio" id="test{{ ++$i }}" name="ans[{{$qtn->id}}]" value="{{$opt->id}}">
                                                <label for="test{{$i}}">{{$opt->option}}</label>
                                            </div>
                                        @endforeach
                                       
                                    </div>
                                </div>
                            </div>
                                @if ($loop->iteration != 1)
                                   <button type="button" class="previous action-button previous_button">@lang('Back')</button>
                                @endif
                                @if ($loop->last)
                                  <button type="submit" class="next action-button">@lang('Finish')</button>
                                @else
                                   <button type="button" class="next action-button">@lang('NEXT')</button>
                                @endif
                        </fieldset>
                           
                        @endforeach
                        @else
                            @foreach ($questions as $key => $qtn)
                            <fieldset>
                                <h3 class="title">@lang($qtn->question)</h3>
                                <div class="form-row">
                                    <div class="form-group col-lg-12">
                                        <textarea rows="8" class="nicEdit" name="written[{{$qtn->id}}]" placeholder="@lang('Write Here')"></textarea>
                                    </div>
                                </div>

                                @if ($loop->iteration != 1)
                                <button type="button" class="previous action-button previous_button">@lang('Back')</button>
                                @endif
                                @if ($loop->last)
                                <button type="submit" class="next action-button">@lang('Finish')</button>
                                @else
                                <button type="button" class="next action-button">@lang('NEXT')</button>
                                @endif

                            </fieldset>
                            @endforeach
                        @endif
                     
                    </form>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6 col-sm-6 mb-30">
           
            <div class="panel-table-area">
                <div class="panel-table border--base">
                    <div class="panel-card-body table-responsive">
                        <table class="table  table-striped table-bordered">
                            <tr>
                                <th>@lang('Exam Name')</th>
                                <td>{{__($exam->title)}}</td>
                            </tr>
                            <tr>
                                <th>@lang('Exam Category')</th>
                                <td>{{$exam->subject->category->name}}</td>
                            </tr>
                            <tr>
                                <th>@lang('Exam Subject')</th>
                                <td>{{$exam->subject->name}}</td>
                            </tr>
                            <tr>
                                <th>@lang('Total Question')</th>
                                <td>{{$exam->questions->count()}}</td>
                            </tr>
                            <tr>
                                <th>@lang('Total Mark')</th>
                                <td>{{$exam->totalmark}}</td>
                            </tr>
                            <tr>
                                <th>@lang('Pass Mark')</th>
                                <td>{{($exam->totalmark*$exam->pass_percentage)/100}}</td>
                            </tr>
                            <tr>
                                <th>@lang('Pass Mark Percentage')</th>
                                <td>{{$exam->pass_percentage}}%</td>
                            </tr>
                            <tr>
                                <th>@lang('Negative Marking')</th>
                                <td>{{$exam->negative_marking == 1 ? trans('Yes'): trans('Yes')}}</td>
                            </tr>
                            @if ($exam->negative_marking == 1 )
                            <tr>
                                <th>@lang('Neg. Ans. Reduce Mark')</th>
                                <td>{{$exam->reduce_mark}}</td>
                            </tr>
                            @endif
                            <tr>
                                <th>@lang('Total Time')</th>
                                <td>{{$exam->duration}} @lang('Minutes')</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
    
<script>
    (function ($) {
        "use strict";

        //* Form js
        function verificationForm() {
            //jQuery time
            var current_fs, next_fs, previous_fs; 
            var left, opacity, scale; 
            var animating; 

            $(".next").on('click',function () {
                if (animating) return false;
                animating = true;

                current_fs = $(this).parent();
                next_fs = $(this).parent().next();
                $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active done");
                
                next_fs.show();
                current_fs.animate({
                    opacity: 0
                }, {
                    step: function (now, mx) {
                        
                        scale = 1 - (1 - now) * 0.2;
                        left = (now * 50) + "%";
                        opacity = 1 - now;
                        current_fs.css({
                            'transform': 'scale(' + scale + ')',
                            'position': 'absolute'
                        });
                        next_fs.css({
                            'left': left,
                            'opacity': opacity
                        });
                    },
                    duration: 800,
                    complete: function () {
                        current_fs.hide();
                        animating = false;
                    },
                    easing: 'easeInOutBack'
                });
            });

            $(".previous").on('click',function () {
                if (animating) return false;
                animating = true;

                current_fs = $(this).parent();
                previous_fs = $(this).parent().prev();

                $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active done");
             
                previous_fs.show();
                current_fs.animate({
                    opacity: 0
                }, {
                    step: function (now, mx) {
                       
                        scale = 0.8 + (1 - now) * 0.2;
                        left = ((1 - now) * 50) + "%";
                        opacity = 1 - now;
                        current_fs.css({
                            'left': left
                        });
                        previous_fs.css({
                            'transform': 'scale(' + scale + ')',
                            'opacity': opacity
                        });
                    },
                    duration: 800,
                    complete: function () {
                        current_fs.hide();
                        animating = false;
                    },
                    //this comes from the custom easing plugin
                    easing: 'easeInOutBack'
                });
                calculateStepTracker();
            });

            $(".submit").on('click',function () {
                return false;
            })
        };
        /*Function Calls*/
        verificationForm();

        if (window.performance.getEntriesByType("navigation")){
          var p=window.performance.getEntriesByType("navigation")[0].type;

       if (p=='navigate'){return false}
       if (p=='reload'){$('#msform').submit();}
       if (p=='back_forward'){return false}
       if (p=='prerender'){return false} 
    }


    var count = 0; 
    window.onload = function () { 
        if (typeof history.pushState === "function") { 
            history.pushState("back", null, null);          
            window.onpopstate = function () { 
                history.pushState('back', null, null);              
                if(count == 0){
                    $('#msform').submit();
                 }
             }; 
            }
        }  
    setTimeout(function(){count = 0;},200);

    })(jQuery);

    var duration = '{{$exam->duration}}'
    var countDownDate = new Date();
        countDownDate.setMinutes(countDownDate.getMinutes() + parseInt(duration));
    var x = setInterval(function () {  
        var now = new Date().getTime();  
        var distance = countDownDate - now; 
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000); 
        document.getElementById("demo").innerHTML =minutes + "m " + seconds + "s "; 
       
        if (distance < 0) {
            clearInterval(x);
            document.getElementById("demo").innerHTML = "EXPIRED";
            $('#msform').submit();
        }
    }, 1000);
   

    document.addEventListener('visibilitychange', function () {
        if (document.visibilityState === 'hidden') {
            $('#msform').submit();
        }
       
    });

    $(document).on("contextmenu",function(){
        return false;
    });





   
</script>

@endpush

@push('style')
<style>
    
    .nicEdit-main{
        width: 580px !important;
        min-height: 200px !important;
    }    
</style>    

@endpush