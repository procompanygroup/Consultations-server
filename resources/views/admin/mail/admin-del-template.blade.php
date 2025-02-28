<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>طلب حذف حساب</title>
    <style>
        .head-line {
            height: 15px;
            background-color: #E72167;
        }

        .footer-line {
            height: 15px;
            background-color: lightgray;
            margin-top: 20px;
        }

        .site-name {
            text-align: center;
            font-size: 30px;
            color: #E72167;
            padding: 10px;
        }

        .code-style {
            padding-left: 5px;
            padding-right: 5px;
			   padding-top: 5px;
			   padding-bottom: 5px;
        }
 .info {
            padding-left: 5px;
            padding-right: 5px;
			   padding-top: 5px;
			   padding-bottom: 5px;
        }
        .code-div {
            text-align: right;
            font-size: 16px;
            padding: 10px;
        }
    </style>
</head>

<body>
    <div class="row"></div>
    <div class="col-12">
        <div class="head-line"></div>
        <p class="lead site-name">{{ $data['com_title'] }}</p>
        <div class="lead code-div">
           
            <p>تم ارسال طلب حذف حساب العميل: <span><strong >{{ $data['client_name'] }}</strong></span></p>
            <div>
			 <span> :معلومات الطلب</span><br/>
              <div class="info" style="direction: rtl">  <span> الايميل:</span><strong class="code-style">{{ $data['client_email'] }}</strong><br/> </div>
              <div class="info">   <span> الموبايل:</span><strong class="code-style">{{ $data['client_mobile'] }}</strong><br/>    </div>
               <div class="info">  <span> السبب:</span><strong class="code-style">{{ $data['reason'] }}</strong><br/>    </div>
            </div>
			   <div class="info"> <span>   لمتابعة الطلب انقر على الرابط :<a href="{{url('admin/client/del-orders/show',$data['order_id'])}}">مراجعة الطلب</a></span></div>
        </div>
        <div class="footer-line"></div>
    </div>
</body>

</html>
