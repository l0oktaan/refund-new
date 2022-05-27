<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Sarabun&display=swap" rel="stylesheet">
    <title>Document</title>
    <style type="text/css">
        *{
            margin: 0px;
            padding: 0px;
        }
        body{
            font-family: 'Sarabun',Arial,Helvetica,sans-serif!important;
            width: 100%;            
        }
        .container{
            width: 100%;
            display: flex;
            justify-content: center;
            align-items:flex-start;
            flex-direction: column;
        }
        .mail{
            width: 50%;
            border: 1px solid #aaa;
        }
    </style>
</head>
<body>
    <div style="font-family:Arial,Helvetica,sans-serif!important;font-size: 16px; border: 1px sold #aaa!important; border-radius:10px; padding-top:15px;">

        <p style="font-family:Arial,Helvetica,sans-serif!important">เรียน คุณ {{$content->user->name}}</p>
        <p style="margin-left: 30px;">กรมบัญชีกลางของส่งข้อมูลการเข้าใช้งานระบบถอนคืนเงินรายได้แผ่นดิน ประเภทค่าปรับ มีรายละเอียด ดังนี้</p>
        <div style="width: 100%; display: flex; justify-content: center;
            align-items: flex-start;">
            <div class="mail" style="width: 100%;">
                <table style="border :0px; width:100%">
                    <tr>
                        <td colspan="2" style="text-align:center;font-weight: bold;">ข้อมูลการเข้าใช้งานระบบถอนคืนเงินรายได้แผ่นดิน</td>
                    </tr>
                    <tr>
                        <td style="width: 100px; text-align:right;background-color: #8ee1e7;">ชื่อ-นามสกุล :</td>
                        <td style="width: 150px; text-align:left">{{$content->user->name}}</td>
                    </tr>
                    <tr>
                        <td style="width: 100px; text-align:right;background-color: #8ee1e7;">username :</td>
                        <td style="width: 150px; text-align:left">{{$content->user->username}}</td>
                    </tr>
                    <tr>
                        <td style="width: 100px; text-align:right;background-color: #8ee1e7;">password :</td>
                        <td style="width: 150px; text-align:left">{{$content->user->password}}</td>
                    </tr>
                    <tr>
                        <td style="width: 100px; text-align:right;background-color: #8ee1e7;">URL :</td>
                        <td style="width: 150px; text-align:left"><a href="{{url('/login')}}" target="_blank">{{url("/login")}}</a></td>
                    </tr>

                </table>
            
            </div>
        </div>
    </div>
</body>
</html>
