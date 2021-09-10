@extends('admin.layouts.app')

@section('panel')

    <div class="row">

        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th scope="col">@lang('Name')</th>
                                <th scope="col">@lang('Amount')</th>
                                <th scope="col">@lang('Coupon Code')</th>
                                <th scope="col">@lang('Minimum Order')</th>
                                <th scope="col">@lang('Total Limit')</th>
                                <th scope="col">@lang('Per User Limit')</th>
                                <th scope="col">@lang('Start Date')</th>
                                <th scope="col">@lang('End Date')</th>
                                <th scope="col">@lang('Status')</th>
                                <th scope="col">@lang('Expiry')</th>
                                <th scope="col">@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($coupons as $coupon)
                            <tr>
                                <td data-label="@lang('Name')">{{$coupon->name}}</td>
                                <td data-label="@lang('Amount')"><span class="text--small badge font-weight-normal badge--success">{{getAmount($coupon->coupon_amount)}}{{$coupon->amount_type== 1 ?'%':$general->cur_text}}</span></td>
                                <td data-label="@lang('Coupon Code')" class="font-weight-bold">{{$coupon->coupon_code}}</td>
                                <td data-label="@lang('Minimum Order')"><span class="badge badge-pill bg--primary">{{$general->cur_sym}} {{getAmount($coupon->min_order_amount)}} </span></td>
                                <td data-label="@lang('Total Limit')">{{$coupon->use_limit}}</td>
                                <td data-label="@lang('Per User Limit')">{{$coupon->usage_per_user}}</td>
                                <td data-label="@lang('Start Date')">{{$coupon->start_date}}</td>
                                <td data-label="@lang('End Date')">{{$coupon->end_date}}</td>
                                <td data-label="@lang('Status')">
                                    @if ($coupon->status == 1)
                                    <span class="text--small badge font-weight-normal badge--success">@lang('active')</span>
                                    @else
                                    <span class="text--small badge font-weight-normal badge--warning">@lang('inactive')</span>
                                    @endif
                               </td>
                                <td data-label="@lang('Expiry')">
                                    @if ($coupon->start_date < \Carbon\Carbon::now()->toDateString() && $coupon->end_date > \Carbon\Carbon::now()->toDateString())
                                      <span class="text--small badge font-weight-normal badge--success">@lang('running')</span>
                                    @elseif($coupon->start_date > \Carbon\Carbon::now()->toDateString())
                                      <span class="text--small badge font-weight-normal badge--primary">@lang('upcoming')</span>
                                    @elseif($coupon->end_date < \Carbon\Carbon::now()->toDateString())
                                      <span class="text--small badge font-weight-normal badge--warning">@lang('expired')</span>
                                    @endif
                               </td>
                                <td data-label="@lang('Action')">
                                    <a href="{{route('admin.coupon.edit',$coupon->id)}}" class="icon-btn" data-toggle="tooltip" title="@lang('edit')" data-original-title="">
                                        <i class="las la-edit text--shadow"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ __($empty_message) }}</td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                <div class="card-footer py-4">
                    {{paginateLinks($coupons)}}
                </div>
            </div><!-- card end -->
        </div>


    </div>
@endsection



@push('breadcrumb-plugins')

<a href="{{route('admin.coupon.add')}}" class="btn btn--primary">
<i class="las la-plus"></i>
 @lang('Add Coupon')
</a>


@endpush
