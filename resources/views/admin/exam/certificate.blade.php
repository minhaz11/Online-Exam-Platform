

@extends('admin.layouts.app')

@section('panel')

    <div class="row">

        <div class="col-md-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive table-responsive--sm">
                        <table class="table align-items-center table--light">
                            <thead>
                            <tr>
                                <th>@lang('Short Code')</th>
                                <th>@lang('Description')</th>
                            </tr>
                            </thead>
                            <tbody class="list">
                            @forelse($certificate->shortcodes as $shortcode => $key)
                                <tr>
                                    <th data-label="@lang('Short Code')">@php echo "{{". $shortcode ."}}"  @endphp</th>
                                    <td data-label="@lang('Description')">{{ __($key) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="100%" class="text-muted text-center">{{ __($empty_message) }}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>



        <div class="col-md-12">
            <div class="card mt-5">
                <div class="card-header bg--dark">
                    <h5 class="card-title text-white">{{ __($page_title) }}</h5>
                </div>
                <form action="{{ route('admin.exam.certificate.update') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label class="font-weight-bold">@lang('Message') <span class="text-danger">*</span></label>
                                <textarea name="body" rows="10" class="form-control nicEdit" placeholder="@lang('Your texts using shortcodes')">{{ $certificate->body }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-block btn--primary mr-2">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection



