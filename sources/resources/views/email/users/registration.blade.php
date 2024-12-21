<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
</head>
<body style="background-color: #f8fafc;">
    <!-- HEADER -->
    <div style="
        display: block;
        height: 70px;
        padding: 6px;
    ">
        <img src="https://sun9-78.userapi.com/impg/5PWOED6aeUkUUIVrFQ4SV_f0kReS0W0N82tBLw/lrsuuOdmOlY.jpg?size=980x112&quality=95&sign=e909f7068aa27189391b02718a59ef3f&type=album" alt="SportExperts" style="
                    width: 100%;
                    display: block;
                    height: 55px;
                ">
    </div>
    <div style="color: #222; text-align: center;">
        <br>
        <h1>Здравствуйте!</h1>
        <p>Благодарим Вас за регистрацию на сайте!</p>
        <p>Для подтверждения регистрации перейдите по ссылке: <a href="http://sportexperts.su/login?activate={{ $key }}">http://sportexperts.su/login?activate={{ $key }}</a></p>
        <br>
    </div>
    <!-- FOOTER -->
    <div style="color: #222; text-align: center;">
        <hr>
        <p>
            <b>Хорошего дня!</b>
        </p>
        <p>С уважением, команда SportExperts.</p>
        <br>
    </div>
</body>
</html>

