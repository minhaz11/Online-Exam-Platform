
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{ getImage(imagePath()['logoIcon']['path'] .'/favicon.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/bootstrap.min.css')}}">
    <title>{{$general->sitename}} - Certificate</title>
   <style>
       .btn--base {
          position: relative;
          color: white;
          padding: 10px 25px;
          text-transform: capitalize;
          font-family: "Josefin Sans", sans-serif;
          font-size: 14px;
          border-radius: 3px;
          background-color: #7367f0;
          border: none;
          outline: none;
          cursor: pointer;
          font-weight: 600;
          z-index: 2;
          overflow: hidden;
          -webkit-transition: all ease 0.5s;
          -moz-transition: all ease 0.5s;
          transition: all ease 0.5s;
        }
        body{
            padding-top: 50px
        }
   </style>
</head>
<body>

    <div class="block1">
        @php
            echo $cert
        @endphp
    </div>
    <div class="row justify-content-center mt-5">
        <button class="btn-download btn--base" type="button" id="demo">@lang('Download')</button>
    </div>



<!-- bootstrap js -->
<!-- bootstrap js -->
<script src="{{asset($activeTemplateTrue.'js/jquery-3.6.0.min.js')}}"></script>

<script src="{{asset($activeTemplateTrue.'js/html2pdf.bundle.min.js')}}"></script>

<script>
    "use strict";
    const options = {
    margin: 0.3,
    filename: '{{$cert_name}}',
    image: {
        type: 'jpeg',
        quality: 1.00
    },
    html2canvas: {
        scale: 4
    },
    jsPDF: {
        unit: 'in',
        format: 'letter',
        orientation: 'landscape'
    }
    }
    var objstr = document.getElementById('block1').innerHTML;
    var strr = objstr;
    $(document).on('click','.btn-download',function(e){
        e.preventDefault();
        var element = document.getElementById('demo');
        html2pdf().from(strr).set(options).save();
    });
</script>


</body>

</html>



