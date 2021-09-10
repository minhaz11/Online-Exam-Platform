@extends($activeTemplate.'layouts.master')

@section('content')
<div class="user-profile-area mt-30">
    <div class="row justify-content-center mb-3">
        <div class="col-md-8">
            <div class="card b-radius--10">
                <div class="card-body d-flex justify-content-between">
                    <h4 class="">@lang('Exam Title '): <span class="text--info">{{__($exam->title)}}</span></h4> 
                    <h4 class="ml-3">@lang('Total Mark '): <span class="text--info">{{$exam->totalmark}}</span></h4>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        @foreach ($detailQuestions as $details)
        <div class="col-md-8 mb-4">
            <div id="accordianId" role="tablist" aria-multiselectable="true">
                <div class="card content">
                    <div class="card-header  d-flex justify-content-between align-items-center" role="tab"
                        id="section1HeaderId">

                        <a data-toggle="collapse" data-parent="#accordianId" href="#section1Content{{$loop->iteration}}"
                            aria-expanded="true" aria-controls="section1ContentId">
                            <h4>@lang($details->question) </h4>

                        </a>
                        <small class="text--danger">(@lang('Mark '):{{$details->writtenQuestion->marks}})</small>

                    </div>
                    <div id="section1Content{{$loop->iteration}}" class="collapse in" role="tabpanel"
                        aria-labelledby="section1HeaderId">
                        <div class="card-body">
                            <div class="form-group">
                                <label class="font-weight-bold d-flex justify-content-between mb-3">@lang('Answer '):
                                    @if ($details->correct_ans == 1)
                                        
                                    <button type="button" class="btn--dark border--rounded p-1 text-white view-ca"
                                        data-ans="{{$details->writtenQuestion->written_ans}}">@lang('View correct
                                        ans.')</button>
                                    @endif
                                </label>
                                <p>@lang($details->answer) </p>
                            </div>
                            <small class="given_mark font-weight-bold text-danger">@lang('Given Mark '):
                                {{$details->given_mark??''}}</small>
                        </div>
                       
                    </div>
                </div>

            </div>
        </div>
        @endforeach
    </div>

    <!--Correct ans Modal -->
    <div class="modal fade" id="correctAns" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel">@lang('Correct Answer')</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <p class="ca"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn--dark border--rounded text-white p-2" data-dismiss="modal">@lang('Close')</button>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- card end -->


@endsection


@push('script')

<script>
    'use strict';

    $('.view-ca').on('click',function () {

        var modal = $('#correctAns')
        modal.find('.ca').empty()
        console.log($(this).data('ans'));
        modal.find('.ca').append($.parseHTML($(this).data('ans')))
        modal.modal('show')
    })
</script>

@endpush

