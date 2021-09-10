@extends($activeTemplate.'layouts.master')
@section('content')

    @php
        $user =auth()->user();
    @endphp

    <div class="user-profile-area mt-30">
        <form action="{{route('user.profile-setting')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row justify-content-center mb-30-none">
                <div class="col-xl-5 col-md-12 col-sm-12 mb-30">
                    <div class="panel panel-default">
                        <div class="panel-heading d-flex flex-wrap align-items-center justify-content-between">
                            <div class="panel-title"><i class="las la-user"></i>@lang('Details')</div>

                        </div>
                        <div class="panel-body">
                            <div class="panel-body-inner">
                                <div class="profile-thumb-area text-center">
                                    <div class="profile-thumb">
                                        <div class="image-preview bg_img"
                                             data-background="{{ getImage(imagePath()['profile']['user']['path'].'/'. auth()->user()->image,imagePath()['profile']['user']['size']) }}">
                                        </div>
                                    </div>
                                    <div class="profile-edit">
                                        <input type="file" name="image" id="imageUpload" class="upload"
                                               accept=".png, .jpg, .jpeg">
                                        <div class="rank-label">
                                            <label for="imageUpload" class="imgUp bg--primary">
                                                @lang('Upload Image')
                                            </label>
                                        </div>
                                    </div>
                                    <div class="profile-content-area text-center mt-20">
                                        <h3 class="name">{{$user->fullName}}</h3>
                                        <h5 class="email">@lang('E-Mail') : {{$user->email}}</h5>
                                        <h5 class="phone">@lang('Phone') : {{$user->mobile}}</h5>
                                        <h5 class="adress">@lang('Address') : {{$user->address->address}}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-7 col-md-12 col-sm-12 mb-30">
                    <div class="panel panel-default">
                        <div class="panel-heading d-flex flex-wrap align-items-center justify-content-between">
                            <div class="panel-title"><i class="las la-user"></i>@lang('Edit')</div>

                        </div>
                        <div class="panel-form-area">
                            <div class="row justify-content-center">
                                <div class="form-group col-sm-6">
                                    <label for="InputFirstname" class="col-form-label">@lang('First Name'):</label>
                                    <input type="text" class="form-control" id="InputFirstname" name="firstname"
                                           placeholder="@lang('First Name')" value="{{$user->firstname}}" required>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="lastname" class="col-form-label">@lang('Last Name'):</label>
                                    <input type="text" class="form-control" id="lastname" name="lastname"
                                           placeholder="@lang('Last Name')" value="{{$user->lastname}}" required>
                                </div>

                                <div class="form-group col-sm-6">
                                    <label for="email" class="col-form-label">@lang('E-mail Address'):</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                           placeholder="@lang('E-mail Address')" value="{{$user->email}}" readonly>
                                </div>
                                <div class="form-group col-sm-6">
                                    <input type="hidden" id="track" name="country_code">
                                    <label for="phone" class="col-form-label">@lang('Mobile Number')</label>
                                    <input type="tel" class="form-control pranto-control" id="phone" name="mobile"
                                           value="{{$user->mobile}}" placeholder="@lang('Your Contact Number')"
                                           readonly>
                                </div>
                                <input type="hidden" name="country" id="country" class="form-control d-none"
                                       value="{{@$user->address->country}}">

                                <div class="form-group col-sm-6">
                                    <label for="address" class="col-form-label">@lang('Address'):</label>
                                    <input type="text" class="form-control" id="address" name="address"
                                           placeholder="@lang('Address')" value="{{@$user->address->address}}" required>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="state" class="col-form-label">@lang('State'):</label>
                                    <input type="text" class="form-control" id="state" name="state"
                                           placeholder="@lang('state')" value="{{@$user->address->state}}" required>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="zip" class="col-form-label">@lang('Zip Code'):</label>
                                    <input type="text" class="form-control" id="zip" name="zip"
                                           placeholder="@lang('Zip Code')" value="{{@$user->address->zip}}" required>
                                </div>

                                <div class="form-group col-sm-6">
                                    <label for="city" class="col-form-label">@lang('City'):</label>
                                    <input type="text" class="form-control" id="city" name="city"
                                           placeholder="@lang('City')" value="{{@$user->address->city}}" required>
                                </div>

                                <div class="form-group col-sm-12">
                                    <button type="submit"
                                            class="btn--primary border--rounded text-white btn-block p-2">@lang('Submit')</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection


