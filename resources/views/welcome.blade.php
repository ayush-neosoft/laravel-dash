<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <style>
        html,
        body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links>a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
</head>

<body>
    <div class="flex-center position-ref full-height">
        @php
        $str = "merchant_id=12656282&merchant_key=5qwd9c1brxoyc&return_url=http%3A%2F%2F0ac63408.ngrok.io%2Freturn&cancel_url=http%3A%2F%2F0ac63408.ngrok.io&notify=http%3A%2F%2F0ac63408.ngrok.io%2Fnotify&name_first=Bob&name_last=Smith&email_address=sbtu01%40payfast.co.za&m_payment_id=TRN123456789&amount=200.00&item_name=Widget+Model+123&item_description=Widget+Model+123";
        $md5 = md5($str);
        @endphp
        <form action="https://sandbox.payfast.co.za/eng/process" method="post" name="frmPay" id="frmPay">
            <!-- Receiver Details -->
            <input type="text" name="merchant_id" value="12656282">
            <input type="text" name="merchant_key" value="5qwd9c1brxoyc">
            <input type="text" name="return_url" value="http://0ac63408.ngrok.io/return">
            <input type="text" name="cancel_url" value="http://0ac63408.ngrok.io/">
            <input type="text" name="notify_url" value="http://0ac63408.ngrok.io/notify">
            <!-- Payer Details -->
            <input type="text" name="name_first" value="Bob">
            <input type="text" name="name_last" value="Smith">
            <input type="text" name="email_address" value="sbtu01@payfast.co.za">
            <!-- Transaction Details -->
            <input type="text" name="m_payment_id" value="TRN123456789">
            <input type="text" name="amount" value="200.00">
            <input type="text" name="item_name" value="Widget Model 123">
            <input type="text" name="item_description" value="Widget Model 123">
            <!-- Transaction Options -->
            <input type="text" name="email_confirmation" value="">
            <!-- Security -->
            <input type="text" name="signature" value="<?php echo $md5; ?>">
            <input type="submit" name="submit" value="submit">
        </form>
    </div>
</body>

</html>