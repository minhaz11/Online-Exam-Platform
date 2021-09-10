@php
    
    $contents = getContent('feature.element',false);

@endphp


<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Feature
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="feature-section">
    <div class="container">
        <div class="feature-area">
            <div class="row">
                @foreach ($contents as $con)
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 p-0">
                    <div class="feature-item">
                        <h2 class="title text-white">@lang($con->data_values->heading)</h2>
                        <h3 class="sub-title text--base">@lang($con->data_values->sub_heading)</h3>
                        <p class="text-white">@lang($con->data_values->short_details)</p>
                        
                    </div>
                </div>
                @endforeach
                
            </div>
        </div>
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Feature
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->