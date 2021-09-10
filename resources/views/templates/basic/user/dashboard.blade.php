@extends($activeTemplate.'layouts.master')

@section('content')

    <div class="dashboard-area mt-30">
        <div class="panel-card-header bg--primary text-white">
            <div class="panel-card-title"><i class="las la-user"></i> @lang('User Activity')</div>
        </div>
        <div class="panel-card-body p-4">
            <div class="row justify-content-center mb-30-none">
                <div class="col-xl-3 col-md-6 col-sm-8 mb-30">
                    <div class="dashboard-item bg--danger">
                        <div class="dashboard-content">
                            <div class="dashboard-icon">
                                <i class="las la-wallet"></i>
                            </div>
                            <div class="num text-white" data-start="0" data-end="0" data-postfix=""
                                 data-duration="1500"
                                 data-delay="0">{{$general->cur_sym}} {{getAmount(auth()->user()->balance)}} {{$general->cur_text}}</div>
                            <h3 class="title text-white">@lang('Your Balance')</h3>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 col-sm-8 mb-30">
                    <div class="dashboard-item bg--success">
                        <div class="dashboard-content">
                            <div class="dashboard-icon">
                                <i class="las la-book"></i>
                            </div>
                            <div class="num text-white" data-start="0" data-end="0" data-postfix=""
                                 data-duration="1500"
                                 data-delay="0">{{auth()->user()->results->count()+auth()->user()->written->count()}}</div>
                            <h3 class="title text-white">@lang('Total Perticipated Exam')</h3>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 col-sm-8 mb-30">
                    <div class="dashboard-item bg--dark">
                        <div class="dashboard-content">
                            <div class="dashboard-icon">
                                <i class="las la-wallet"></i>
                            </div>
                            <div class="num text-white" data-start="0" data-end="0" data-postfix=""
                                 data-duration="1500"
                                 data-delay="0">{{$general->cur_sym}} {{getAmount($totalDeposit)}} {{$general->cur_text}}</div>
                            <h3 class="title text-white">@lang('Total Deposit')</h3>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 col-sm-8 mb-30">
                    <div class="dashboard-item bg--info">
                        <div class="dashboard-content">
                            <div class="dashboard-icon">
                                <i class="las la-exchange-alt"></i>
                            </div>
                            <div class="num text-white" data-start="0" data-end="0" data-postfix=""
                                 data-duration="1500" data-delay="0">{{$totalTrx}}</div>
                            <h3 class="title text-white">@lang('Total Transaction')</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="transaction-area mt-30">
        <div class="row justify-content-center mb-30-none">
            <div class="col-xl-12 col-md-12 col-sm-12 mb-30">
                <div class="panel-table-area">
                    <div class="panel-table border-0">
                        <div class="panel-card-body table-responsive">
                            <table class="custom-table">
                                <thead>
                                <tr class="bg--primary">
                                    <th>@lang('Title')</th>
                                    <th>@lang('Category')</th>
                                    <th>@lang('Subject')</th>
                                    <th>@lang('Type')</th>
                                    <th>@lang('Payment Type')</th>
                                    <th>@lang('Exam Fee')</th>
                                    <th>@lang('Details')</th>
                                    <th>@lang('Coupon')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse ($examList as $exam)
                                    @php
                                        $pendingExam = @auth()->user()->deposits->where('exam_id',$exam->id)->first();
                                        $perticipate = auth()->user()->perticipated($exam->id);
                                        $upcoming = $exam->upcomming($exam->id);
                                    @endphp
                                    <tr>
                                        <td data-label="@lang('Title')">{{$exam->title}}</td>
                                        <td data-label="@lang('Category')">{{$exam->subject->category->name}}</td>
                                        <td data-label="@lang('Subject')">{{$exam->subject->name}}</td>
                                        <td data-label="@lang('Type')">{{$exam->question_type == 1 ? trans('MCQ'):trans('Written')}}</td>
                                        <td data-label="@lang('Payment Type')">{{$exam->value == 1 ? trans('Paid'): trans('Unpaid')}}</td>
                                        <td data-label="@lang('Exam Fee')">{{$exam->value == 1 ? $exam->exam_fee.' '.$general->cur_text: trans('Free') }}</td>
                                        <td data-label="@lang('Details')">
                                            <button class="btn--dark border--rounded text-white details"
                                                    data-details="{{$exam}}"
                                                    data-tq="{{$exam->questions->count()}}">@lang('More info.')</button>
                                        </td>

                                        <td data-label="@lang('Coupon')" class="parent-coupon">
                                            @if (!$perticipate)
                                                @if (!$upcoming)
                                                    @if ($exam->value == 1 && !$pendingExam)
                                                        <div class="input-group coupon-div">
                                                            <input type="hidden" class="examid" name="examid"
                                                                   value="{{$exam->id}}">
                                                            <input class="form-control coupon" type="text" name="coupon"
                                                                   placeholder="@lang('Apply coupon')">

                                                            <div class="input-group-append">
                                                                <button
                                                                    class="input-group-text btn--base apply-coupon">@lang('apply')</button>
                                                            </div>
                                                        </div>
                                                        <p class="d-none text-muted newprice"></p>
                                                    @else
                                                        @lang('N/A')
                                                    @endif
                                                @else
                                                    @lang('N/A')
                                                @endif

                                            @else
                                                @lang('N/A')
                                            @endif
                                        </td>

                                        <td data-label="@lang('Action')">
                                            @if ($perticipate)
                                                <a href="javascript:void(0)"
                                                   class="btn--success border--rounded text-white p-1 d-block">@lang('Perticipated')</a>
                                            @else
                                                @if(!$upcoming)
                                                    @if ($exam->value == 1)
                                                        @if ($pendingExam && $pendingExam->status == 2)
                                                            <a href="javascript:void(0)"
                                                               class="btn--dark border--rounded text-white p-1">@lang('Pending')</a>
                                                        @elseif($pendingExam && $pendingExam->status == 1)
                                                            <a href="{{route('user.exam.perticipate',$exam->id)}}"
                                                               class="btn--primary border--rounded text-white p-1 d-block">@lang('Attend Exam')</a>
                                                        @else
                                                            <a href="javascript:void(0)"
                                                               data-balroute="{{route('user.take.exam',$exam->id)}}"
                                                               data-route="{{route('user.payment',$exam->id)}}"
                                                               data-price="{{getAmount($exam->exam_fee)}}"
                                                               class="btn--primary border--rounded text-white p-1 purchase d-block">@lang('Attend Exam')</a>
                                                        @endif
                                                    @else
                                                        <a href="{{route('user.exam.perticipate',$exam->id)}}"
                                                           class="btn--primary border--rounded text-white p-1 d-block">@lang('Attend Exam')</a>
                                                    @endif
                                                @else
                                                    <a href="javascript:void(0)"
                                                       class="d-block btn--dark border--rounded text-white p-1">@lang('Upcoming')</a>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="12">@lang('No exam available')</td>
                                    </tr>
                                @endforelse

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="moreinfoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel">@lang('More info.')</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="panel-card-body table-responsive">
                        <table class="table  table-striped table-bordered">

                            <tr>
                                <th>@lang('Total Question')</th>
                                <td class="tq"></td>
                            </tr>
                            <tr>
                                <th>@lang('Total Mark')</th>
                                <td class="tm"></td>
                            </tr>
                            <tr>
                                <th>@lang('Pass Mark')</th>
                                <td class="pm"></td>
                            </tr>
                            <tr>
                                <th>@lang('Pass Mark Percentage')</th>
                                <td class="pmp"></td>
                            </tr>
                            <tr>
                                <th>@lang('Negative Marking')</th>
                                <td class="nm"></td>
                            </tr>

                            <tr>
                                <th>@lang('Total Time')</th>
                                <td class="tt"></td>
                            </tr>
                        </table>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn--dark border--rounded text-white p-2"
                            data-dismiss="modal">@lang('Close')</button>
                </div>
            </div>
        </div>
    </div>


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

        $('.details').on('click', function () {
            var minutes = "{{trans('minutes')}}"
            var Yes = "{{trans('Yes')}}"
            var No = "{{trans('No')}}"
            var details = $(this).data('details')
            var tq = $(this).data('tq')
            var pm = (details.totalmark * details.pass_percentage) / 100;
            $('.tq').text(tq);
            $('.tm').text(details.totalmark);
            $('.pm').text(pm);
            $('.pmp').text(details.pass_percentage + '%');
            $('.nm').text(details.negative_marking == 1 ? Yes : No);
            $('.tt').text(details.duration + ' ' + minutes);
            $('#moreinfoModal').modal('show')
        });


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

        $('.apply-coupon').on('click', function () {
            var thisBtn = $(this)
            var coupon = $(this).parents('.coupon-div').find('.coupon').val();
            var examid = $(this).parents('.coupon-div').find('.examid').val();
            var route = "{{route('user.apply.coupon')}}"
            var data = {
                coupon: coupon,
                examid: examid
            }
            axios.post(route, data)
                .then(function (response) {
                    if (response.data.coupon) {
                        $.each(response.data.coupon, function (i, val) {
                            notify('error', val);
                        });

                    } else {
                        notify('success', response.data.yes);
                        thisBtn.parents('.parent-coupon').find('.newprice').removeClass('d-none').text('New exam fee is ' + response.data.newPrice)
                        thisBtn.parents('.coupon-div').remove()


                    }
                })
        })

        function btnDisable(btn) {

            $(btn).addClass('d-none');
        }

    </script>

@endpush
