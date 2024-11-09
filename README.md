<style>
a, .inform{
    color: #57bafb;
}
h2, h3, li, li p span , li p b{
    color: #2c2c2c;
}
.card-item{
    background-color: #f5f5f5;
    padding: 0.7em;
    border-radius: 0.4em;
    margin-bottom:10px;
}
</style>
<img src="https://avatars.githubusercontent.com/u/153977186?s=400&u=7268ad55ed694cec25c1467486710abb82bc9ad8&v=4" style="width: 10%">
<h2>Remote Technology</h2>
<br>
<h3>Используемые технологии:</h3>
<ul>
    <li>
        <a href="#">PHP 8.3 (Laravel 10)</a>
    </li>
    <li>
        <a href="#">PostgreSQL 13</a>
    </li>
    <li>
        <a href="#">MongoDB 4</a>
    </li>
    <li>
        <a href="#">JavaScript (Vue 3)</a>
    </li>
    <li>
        <a href="#">RabbitMQ</a>
    </li>
</ul>
<hr>
<h3>Настройка окружения.</h3>
<ul>
    <li>
        <p>
            <span>Создать/настроить конфиг, как минимум надо настроить подключение к БД:</span><br>
            <b style="color: #222;">(sudo) cp .example.env .env</b><br>
        </p>
    </li>
    <br />
    <li>
        <p>
            <span>Поднять docker:</span><br>
            <b style="color: #222;">(sudo) docker-compose up --build -d</b>
        </p>
    </li>
    <br />
    <li>
        <p>
            <span>Создать/настроить конфиг, для работы Laravel:</span><br>
            <b style="color: #222;">cp sources/.env.example sources/.env</b><br>
            <small class="inform">Так же рекоммендуется создать коллекцию для журнала ошибок в монге. Удобно использовать <b class="inform">MongoDB Compass</b>.</small><br>
        </p>
    </li>
    <br />
    <li>
        <p>
            <span>Установить зависимости:</span><br>
            <b style="color: #222;">(sudo) docker-compose run php-fpm composer --ignore-platform-req=ext-sockets install</b><br>
            <b style="color: #222;">(sudo) docker-compose run node install</b><br>
        </p>
    </li>
    <br />
    <li>
        <span>Создать миграции: <small class="inform">(Нужно проверить есть ли база)</small></span><br>
        <b style="color: #222;">(sudo) docker-compose run php-fpm php artisan migrate</b><br>
    </li>
    <br />
    <li>
        <span>Запустить сборку фронтенда:</span><br>
        <b style="color: #222;">(sudo) docker-compose run node run build</b><br>
    </li>
    <br />
    <li>
        <span>Заполнить базу тестовыми данными <b><small class="inform">Опционально</small></b>:</span><br>
        <b style="color: #222;">(sudo) docker-compose run php-fpm php artisan db:seed</b><br>
    </li>
    <br />
    <li>
        <span>Сгенерировать CSRF токен:</span><br>
        <b style="color: #222;">(sudo) docker-compose run php-fpm php artisan key:generate</b><br>
    </li>
    <br />
    <li>
        <span>Установить права и группу на директорию с проектом:</span><br>
        <b style="color: #222;">sudo chmod -R 777 $PWD</b><br>
        <b style="color: #222;">sudo chown -R <MY GROUP>:<MY GROUP> $PWD</b><br>
    </li>
    <br />
    <li>
        <span>Создать коллекцию "logs" <small class="inform">(Желательно использовать MongoDB Compass)</small></span><br>
    </li>
    <br />
    <li>
        <span>Добавить почтовый сервер <small class="inform">(или хотя бы пароль, я использую smtp.yandex.ru)</small></span><br>
    </li>
    <br />
    <li>
        <span>Создать ссылку на storage:</span><br>
        <b style="color: #222;">(sudo) docker-compose run php-fpm php artisan storage:link</b><br>
    </li>
</ul>
<hr />
<h3>Дополнительно:</h3>
<div class="card-item">
    <p>
        API описано по спецификации <b>JSON-RPC</b>. Саму спецификацию можно посмотреть тут:<br />
        <a href="https://www.jsonrpc.org/specification">https://www.jsonrpc.org/specification</a><br />
        <small>В проекте используется версия <span style="color: red;">2.0</span></small>
    </p>
</div>
<div class="card-item">
    <p>
        Ссылка на документацию по методам API:<br />
        <a href="https://www.postman.com/gold-satellite-925746/workspace/sportexperts/overview">
            https://www.postman.com/gold-satellite-925746/workspace/sportexperts/overview
        </a><br />
    </p>
</div>
<div class="card-item">
    <p>
        Файл schema.drawio можно открыть в приложении <b>draw.io</b> или на сайте:<br />
        <a href="https://app.diagrams.net/">https://app.diagrams.net/</a><br />
    </p>
</div>