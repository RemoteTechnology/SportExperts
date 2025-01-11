<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
</head>
<body style="background-color: #0f172a; padding: 5%;">
    <!-- HEADER -->
    <div style="
        display: block;
        height: 70px;
        padding: 6px;
    ">
        <img src="https://sportexperts.su/images/logo.png" alt="SportExperts" style="
                    width: 50%;
                    display: block;
                    height: 55px;
                ">
    </div>
    <div style="color: #fff; font-size: 1.2em;">
        <p>Уважаемый [Имя спортсмена]!</p>

        <p>Мы рады пригласить Вас принять участие в [название спортивного события], которое состоится [дата] в [место проведения]. Ваши достижения и профессионализм вдохновляют многих, и мы уверены, что Ваше участие станет важной частью нашего мероприятия.</p>
        <p>Программа события, а также дополнительные детали будут отправлены Вам в ближайшее время. Пожалуйста, подтвердите Ваше участие до [дата] по электронной почте или по телефону [контактные данные].</p>
        <p>Будем рады видеть Вас среди участников!</p>

        <p>С уважением</p>
        <p><b>SportExperts</b></p>
        <p>[Контактная информация]</p>
        <a style="
            padding: 8px;
            border-radius: 2px;
            background-color: #fff;
            color: #0f172a;
            display: block;
            text-align: center;
            text-decoration: none;
            font-weight: 900;
        " href="https://sportexperts.su/registration/?invite_user_id={{ $attributes['invited_user_id'] }}&&event_id={{ $attributes['event_id'] }}">Записаться</a>
        <br>
    </div>

</body>
</html>


