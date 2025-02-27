<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>تطبيق روح </title>
    <link rel="icon" href="{{URL::asset('assets/site/img/logo-title.svg')}}" type="image/x-icon">
   
<!--- Style css -->
<link href="{{URL::asset('assets/site/css/style.css')}}" rel="stylesheet">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>

<body>

    <div class="container">
        <div class="row d-flex align-items-center" style="min-height: 80vh;">
            <div class="col text-center mx-4">
                <img class="img-size" src="{{URL::asset('assets/site/img/rouh-app-logo.png')}}"  alt="">
            </div>
        </div>
        <div class="row d-flex align-items-center">
            <div class="col text-center mx-4">
                <a href="{{ $linksarr['gplay_link'] }}" ><img class="btn-size" src="{{URL::asset('assets/site/img/google-play-btn.png')}}" alt=""></a>
            <a href="{{ $linksarr['appstor_link'] }}"><img class="btn-size" src="{{URL::asset('assets/site/img/app-store-btn.png')}}"  alt=""></a>
            </div>
        </div>
        <div class="row d-flex align-items-center">
            <div class="col text-center mx-4 page-cont">
                <a href="{{url('page/privacy')}}" class="page-a" >سياسة الخصوصية</a>
            <a href="{{url('page/user_guide')}}" class="page-a" >دليل المستخدم </a> 
            </div>
        </div>
    </div>

    <!-- JS link-->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
</body>

</html>
