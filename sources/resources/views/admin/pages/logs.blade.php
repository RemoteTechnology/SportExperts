<div class="container">
    <div class="mt-5 mb-5">
        <h3 class="text-center">Логи ошибок</h3>
    </div>
    <div class="mt-5"></div>
    @foreach($content as $item)
        <div class="card w-75 mx-auto mb-3">
            <div class="bg-dark text-light p-2">
                <h4>
                    <svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 24 24" style="fill: #fff;">
                        <path d="M7 10h10v4H7z"></path>
                        <path d="M12 2C6.486 2 2 6.486 2 12s4.486 10 10 10 10-4.486 10-10S17.514 2 12 2zm0 18c-4.411 0-8-3.589-8-8s3.589-8 8-8 8 3.589 8 8-3.589 8-8 8z"></path>
                    </svg> {{ $item['key'] }}
                </h4>
            </div>
            <section class="p-2">
                <p>Действие: <b>{{ $item['method'] }}</b></p>
                <p>Статус ответа: <b>{{ $item['status'] }}</b></p>
                <p>Уровень: <b>{{ $item['level'] }}</b></p>
                <p>Сообщение: <b>{{ $item['message'] }}</b></p>
                <code class="card bg-dark text-light p-2" type="json">
                    {{ $item['request_data'] }}
                </code>

            </section>
        </div>
        <hr>
    @endforeach
</div>
