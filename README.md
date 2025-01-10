<img src="https://avatars.githubusercontent.com/u/153977186?s=400&u=7268ad55ed694cec25c1467486710abb82bc9ad8&v=4" style="width: 10%">
<h2 style="color: #2c2c2c;">Remote Technology</h2>
<br>
<h3>Используемые технологии:</h3>
<ul>
    <li>
        <a href="#" style="color: #57bafb;">PHP 8.3 (Laravel 10)</a>
    </li>
    <li>
        <a href="#" style="color: #57bafb;">PostgreSQL 13</a>
    </li>
    <li>
        <a href="#" style="color: #57bafb;">MongoDB 4</a>
    </li>
    <li>
        <a href="#" style="color: #57bafb;">JavaScript (Vue 3)</a>
    </li>
    <li>
        <a href="#" style="color: #57bafb;">RabbitMQ</a>
    </li>
</ul>
<hr>
<h3 style="color: #2c2c2c;">Настройка окружения <small><b style="color: #57bafb;text-decoration: underline;text-decoration-color: #57bafb;">STAGING</b></small></h3>
<ul>
    <li>
        <p>
            <span style="color: #2c2c2c;">Создать/настроить конфиг, как минимум надо настроить подключение к БД:</span><br>
            <b style="color: #2c2c2c;">(sudo) cp .example.env .env</b><br>
        </p>
    </li>
    <br />
    <li>
        <p>
            <span style="color: #2c2c2c;">Поднять docker:</span><br>
            <b style="color: #2c2c2c;">На локалке: (sudo)docker-compose --profile debug up --build -d</b><br>
            <b style="color: #2c2c2c;">
                <small>На проде: (sudo) docker-compose up --build -d</small>
            </b>
        </p>
    </li>
    <br />
    <li>
        <p>
            <span style="color: #2c2c2c;">Создать/настроить конфиг, для работы Laravel:</span><br>
            <b style="color: #2c2c2c;">cp sources/.env.example sources/.env</b><br>
            <small style="color: #57bafb;">Так же рекоммендуется создать коллекцию для журнала ошибок в монге. Удобно использовать <b style="color: #57bafb;">MongoDB Compass</b>.</small><br>
        </p>
    </li>
    <br />
    <li>
        <p>
            <span style="color: #2c2c2c;">Установить зависимости:</span><br>
            <b style="color: #2c2c2c;">(sudo) docker-compose run php-fpm composer --ignore-platform-req=ext-sockets install</b><br>
            <b style="color: #2c2c2c;">(sudo) docker-compose run node install</b><br>
        </p>
    </li>
    <br />
    <li>
        <span style="color: #2c2c2c;">Создать миграции: <small style="color: #57bafb;">(Нужно проверить есть ли база)</small></span><br>
        <b style="color: #2c2c2c;">(sudo) docker-compose run php-fpm php artisan migrate</b><br>
    </li>
    <br />
    <li>
        <span style="color: #2c2c2c;">Запустить сборку фронтенда:</span><br>
        <b style="color: #2c2c2c;">(sudo) docker-compose run node run build</b><br>
    </li>
    <br />
    <li>
        <span style="color: #2c2c2c;">Заполнить базу тестовыми данными <b><small style="color: #57bafb;">Опционально</small></b>:</span><br>
        <b style="color: #2c2c2c;">(sudo) docker-compose run php-fpm php artisan db:seed</b><br>
    </li>
    <br />
    <li>
        <span style="color: #2c2c2c;">Сгенерировать CSRF токен:</span><br>
        <b style="color: #2c2c2c;">(sudo) docker-compose run php-fpm php artisan key:generate</b><br>
    </li>
    <br />
    <li>
        <span style="color: #2c2c2c;">Установить права и группу на директорию с проектом:</span><br>
        <b style="color: #2c2c2c;">sudo chmod -R 777 $PWD</b><br>
        <b style="color: #2c2c2c;">sudo chown -R <MY GROUP>:<MY GROUP> $PWD</b><br>
    </li>
    <br />
    <li>
        <span style="color: #2c2c2c;">Создать коллекцию "logs" <small style="color: #57bafb;">(Желательно использовать MongoDB Compass)</small></span><br>
    </li>
    <br />
    <li>
        <span style="color: #2c2c2c;">Добавить почтовый сервер <small style="color: #57bafb;">(или хотя бы пароль, я использую smtp.yandex.ru)</small></span><br>
    </li>
    <br />
    <li>
        <span style="color: #2c2c2c;">Создать ссылку на storage:</span><br>
        <b style="color: #2c2c2c;">(sudo) docker-compose run php-fpm php artisan storage:link</b><br>
    </li>
</ul>
<hr />
<h3 style="color: #2c2c2c;">Настройка деплоя</h3>
<ul>
    <li>
        <p>
            <span style="color: #2c2c2c;">Сгенерировать rsa ключ:</span><br>
            <b style="color: #2c2c2c;">(sudo) ssh-keygen -t rsa -b 4096 -C "vuacheslav.mir@gmail.com" -f id_rsa</b><br>
            <small style="color: #2c2c2c;">Необходимо выполнить в папке /app/rsa</small><br>
            <span style="color: #2c2c2c;">Скопировать ключ на целевой сервер:</span><br>
            <b style="color: #2c2c2c;">(sudo) ssh-copy-id root@SERVER IP</b><br>
        </p>
    </li>
    <br />
</ul>
<hr />
<h3 style="color: #2c2c2c;">Дополнительно:</h3>
<div style="background-color: #f5f5f5;padding: 0.7em;border-radius: 0.4em;margin-bottom:10px;">
    <p style="color: #2c2c2c;">
        API описано по спецификации <b>JSON-RPC</b>. Саму спецификацию можно посмотреть тут:<br />
        <a href="https://www.jsonrpc.org/specification" style="color: #57bafb;">https://www.jsonrpc.org/specification</a><br />
        <small>В проекте используется версия <span style="color: red;">2.0</span></small>
    </p>
</div>
<div style="background-color: #f5f5f5;padding: 0.7em;border-radius: 0.4em;margin-bottom:10px;">
    <p style="color: #2c2c2c;">
        Ссылка на документацию по методам API:<br />
        <a href="https://www.postman.com/gold-satellite-925746/workspace/sportexperts/overview" style="color: #57bafb;">
            https://www.postman.com/gold-satellite-925746/workspace/sportexperts/overview
        </a><br />
    </p>
</div>
<div style="background-color: #f5f5f5;padding: 0.7em;border-radius: 0.4em;margin-bottom:10px;">
    <p style="color: #2c2c2c;">
        Файл schema.drawio можно открыть в приложении <b>draw.io</b> или на сайте:<br />
        <a href="https://app.diagrams.net/" style="color: #57bafb;">https://app.diagrams.net/</a><br />
    </p>
</div>