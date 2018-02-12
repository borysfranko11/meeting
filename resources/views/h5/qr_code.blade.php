
<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
    <style>
        *{
            padding: 0;
            margin: 0;
        }
        html,body{
            font-size: 62.5%
        }
        body{
            background: url("/assets/h5/image/background.jpg") no-repeat center center /100%;
        }
        h1,h2,h3,p{
            text-align: center;
            color: #fff;
        }
        h1{
            font-size: 2rem;
            height: 2.8rem;
            line-height: 2.8rem;
            padding-top:3.2rem
        }
        h2{
            font-size: 1.5rem;
            height: 2.1rem ;
            line-height: 2.1rem;
            padding-top:1.6rem;
        }
        h3{
            font-size: 1.4rem;
            height: 1.4rem;
            line-height:1.4rem;
            padding-top:5.2rem ;
        }
        p{
            text-align: center;
            font-size: 1.3rem;
            height: 2.1rem;
            line-height:2.1rem;
            padding-top: 1.2rem;

        }
        .alert{
           opacity: 0.8;
            padding-top: 1.6rem;
        }
        div{
            text-align: center;
            padding-top: 1.2rem;
        }
    </style>
</head>
<body>
<h1>
    提交成功
</h1>
<h2>{{ $title[0]['meeting_name'] }}</h2>
<p class="alert">以下是您的参会二维码，请在会议当天持二维码签到</p>
<h3>
   签到码：&nbsp @if(empty($_GET['qr_code']))
        @foreach($code as $val)
            {{ $val['qrcode_code'] }}
        @endforeach
    @else
            {{ $_GET["qr_code"] }}
    @endif
</h3>
<div>
    @if(isset($file_name))
    <img src="{{ url('assets/qr_code/'.$file_name) }}">
        @else
        <p>该二维码供现场签到使用</p>
        @endif
</div>
<p>长按可保存为照片</p>
{{--<p>如需修改个人信息请联系主办方</p>--}}
</body>