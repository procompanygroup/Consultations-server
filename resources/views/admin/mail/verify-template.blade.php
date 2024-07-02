<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Email</title>
    <style>
    .thtitle{
        text-align: right;
    padding: 5px;
    }
    </style>
</head>
<body>
<div class="row"></div>
<div class="col-12">
<div style="height: 15px; background-color: #E72167;"></div>
    <p class="lead" style="text-align: center; font-size:20px;padding:10px">
        <img  src="{{$data['logo']}}" width="50px" height="50px" alt="logo"></p>
    <div class="lead" style="text-align: right; font-size:16px;padding:10px">
        <span>رمز التحقق:</span><strong style="padding-left:5px;padding-right:5px;">{{$data['code']}}</strong>
    </div>

    
  
    <div style="height: 15px; background-color: lightgray;margin-top:20px"></div>
  </div>
 
</body>
</html>