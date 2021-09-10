@extends($activeTemplate.'layouts.frontend')

@section('content')

    @include($activeTemplate.'partials.breadcrumb')

    <section class="exam-details-section exam-section ptb-80">
        <div class="container">
            <div class="row justify-content-center mb-30-none">
                <div class="col-xl-9 mb-30">
                    <div class="exam-item">
                        <div class="exam-thumb-detail">
                            <img src="{{getImage('assets/images/exam/'.$exam->image,'850x560')}}" alt="exam">
                        </div>
                        <div class="exam-content">
                            <h3 class="title">{{__($exam->title)}}</h3>
                            <div class="exam-list-area d-flex flex-wrap justify-content-between">
                                <ul class="exam-list">
                                    <li>@lang('Subject') : {{$exam->subject->name}}</li>
                                    <li>@lang('Type') : {{$exam->question_type == 1 ? 'MCQ':'Written'}}</li>
                                    <li>@lang('Total Mark') : {{$exam->totalmark}}</li>
                                    <li>@lang('Pass Mark Percentage'): {{$exam->pass_percentage}}%</li>
                                    <li>@lang('Exam Fee')
                                        : {{$exam->exam_fee != null ? getAmount($exam->exam_fee).' '.$general->cur_text:'Free'}}</li>
                                </ul>
                                <ul class="exam-list">
                                    <li>@lang('Category') : {{$exam->subject->category->name}}</li>
                                    <li>@lang('Total Question') : {{$exam->questions->count()}}</li>
                                    <li>@lang('Pass Mark') : {{($exam->totalmark*$exam->pass_percentage)/100}}</li>
                                    <li>@lang('Total Time') : {{$exam->duration}} @lang('Minutes')</li>
                                    @if($exam->upcomming($exam->id))
                                        <li>@lang('Start Date') : {{$exam->start_date}}</li>
                                    @endif
                                </ul>
                            </div>
                            <h3 class="sub-title">@lang('Instruction')</h3>
                            <p>@php
                                    echo $exam->instruction;
                                @endphp</p>
                            @if(!$exam->upcomming($exam->id))
                                @auth
                                    @if($exam->exam_fee == null)
                                        <div class="exam-btn mt-30">
                                            <a href="{{route('user.exam.perticipate',$exam->id)}}"
                                               class="btn--base">@lang('Attend Exam')</a>
                                        </div>
                                    @else
                                        <div class="exam-btn mt-30 d-flex flex-wrap align-items-center">
                                            @if (auth()->user()->deposits->where('exam_id',$exam->id)->where('status',2)->first())
                                                <a href="javascript:void(0)" class="btn--base">@lang('Pending')</a>
                                            @else
                                                <a href="javascript:void(0)"
                                                   data-balroute="{{route('user.take.exam',$exam->id)}}"
                                                   data-route="{{route('user.payment',$exam->id)}}"
                                                   data-price="{{getAmount($exam->exam_fee)}}"
                                                   class="btn--base purchase">@lang('Attend Exam')</a>
                                                <span class="ml-3">
                                       <div class="input-group coupon-div">
                                           <input type="hidden" name="examid" id="examid" value="{{$exam->id}}">
                                           <input class="form-control" type="text" id="coupon" name="coupon"
                                                  placeholder="@lang('Apply coupon')">

                                           <div class="input-group-append">
                                               <button class="input-group-text btn--base"
                                                       id="apply-coupon">@lang('apply')</button>
                                           </div>
                                       </div>
                                       <p class="d-none text-muted newprice"></p>
                                   </span>
                                            @endif
                                        </div>
                                    @endif
                                @endauth
                                @guest
                                    <a href="{{route('user.login')}}" class="btn--base">@lang('Attend Exam')</a>
                                @endguest
                            @else
                                <button class="btn--base">@lang('Upcoming')</button>
                            @endif

                        </div>
                    </div>
                </div>
                <div class="col-xl-3 mb-30">
                    <div class="sidebar">
                        <div class="widget-box mb-30">
                            <h5 class="widget-title">@lang('All Categories')</h5>
                            <ul class="category-content">
                                @foreach ($categories as $item)
                                    <li><a href="{{route('category.subjects',$item->slug)}}">{{$item->name}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="widget-box">
                            <h5 class="widget-title">@lang('All Subject')</h5>
                            <ul class="category-content">
                                @foreach ($subjects as $sub)
                                    <li><a href="{{route('subject.exams',$sub->slug)}}">{{$sub->name}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="purchaseModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close ml-auto m-3" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="modal-body text-center">

                    <h1><i class="fas fa-hand-holding-usd text-info mb-15"></i></h1>
                    <h3 class="text--secondary mb-15">@lang('Please choose your payment option!')</h3>
                    <small> <b
                            class="text--success examprice"></b> @lang('will be deducted, if you choose payment from your balance')
                    </small>
                </div>
                <div class="modal-footer justify-content-center">
                    <a href="" onclick="btnDisable(this)"
                       class="btn--warning border--rounded text-white p-2 planpurchase">@lang('From Balance')</a>
                    <a href="" class="btn--primary border--rounded text-white p-2 gateway">@lang('From Gateway')</a>
                </div>

            </div>
        </div>
    </div>

@endsection
@push('script-lib')
    <script src="{{asset($activeTemplateTrue.'js/axios.min.js')}}"></script>
@endpush


@push('script')

    <script>
        'use strict';
        $('.purchase').on('click', function () {
            @if(session('newPrice'))
            $(this).attr('data-price', '{{session('newPrice')}}')
                @endif
            var route = $(this).data('route')
            var balroute = $(this).data('balroute')
            var price = $(this).data('price')
            var curr = "{{$general->cur_text}}"

            var modal = $('#purchaseModal');
            $('.examprice').text(price + ' ' + curr)
            $('.gateway').attr('href', route)
            if ($('.planpurchase').hasClass('d-none')) {
                $('.planpurchase').removeClass('d-none')
            }
            $('.planpurchase').attr('href', balroute)
            modal.modal('show');
        })

        $('#apply-coupon').on('click', function () {

            var thisBtn = $(this)
            var coupon = $(this).parents('.coupon-div').find('#coupon').val();
            var examid = $(this).parents('.coupon-div').find('#examid').val();
            var route = "{{route('user.apply.coupon')}}"
            var data = {
                coupon: coupon,
                examid: examid
            }
            axios.post(route, data)
                .then(function (response) {
                    console.log(response);
                    if (response.data.coupon) {
                        $.each(response.data.coupon, function (i, val) {
                            notify('error', val);
                        });

                    } else {
                        notify('success', response.data.yes);
                        var txt = "{{trans('New exam fee is')}}"
                        thisBtn.parents('.coupon-div').remove()
                        $('.newprice').removeClass('d-none').text( txt + response.data.newPrice)

                    }
                })
        })

        function btnDisable(btn) {

            $(btn).addClass('d-none');
        }
    </script>

@endpush

