<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>رسالة تحقق</title>
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
        <div class="head-line" style=""></div>
        <p class="lead site-name">{{ $data['com_title'] }}</p>
        <div class="lead code-div">
            <span>رمز التحقق:</span><strong class="code-style">{{ $data['code'] }}</strong>
        </div>
        <div class="footer-line"></div>
    </div>
</body>
</html>
