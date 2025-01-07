@php
    $titleList = [
        'orders' => ['Статус', 'Заголовок', 'Локация', 'Даты', ''],
        'users' => ['Имя', 'Фамилия', 'Контакты', 'События клиента', 'Спортсмены клиента'],
        'events' => ['Заголовок', 'Локация', 'Даты', 'Турнирная сетка', ''],
    ];

    $param = request('filter');

    $getTitle = function (array $attributes) {
        $html = '';
        foreach ($attributes as $item) {
            $html .= '<th scope="col">' . $item . '</th>';
        }
        return $html;
    };

    $getContent = function (mixed $attributes, string $tableEntity) use($param) {
        $html = '';
        foreach($attributes as $item) {
             if ($tableEntity === 'orders') {
                $data = '<tr>
                    <td>' . $item["status"] . '</td>
                    <td>' . $item["data"]["name"] . '</td>
                    <td>' . $item["data"]["location"] . '</td>
                    <td>' . $item["data"]["start_date"] . ' - ' . $item["data"]["expiration_date"] . '</td>
                    <td>
                        <a href="' . route("admin") . '?view=demo&&key=' . $item["key"] . '" class="btn bg-dark border-dark">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgb(241 241 241);">
                                <path d="M19 4h-3V2h-2v2h-4V2H8v2H5c-1.103 0-2 .897-2 2v14c0 1.103.897 2 2 2h14c1.103 0 2-.897 2-2V6c0-1.103-.897-2-2-2zM5 20V7h14V6l.002 14H5z"></path>
                                <path d="M7 9h10v2H7zm0 4h5v2H7z"></path>
                            </svg>
                        </a>
                    </td>
                </tr>';
                if (
                    (!empty((string)$param) &&  $param === 'Обработанные заявки' && $item["status"] === 'Обработан') ||
                    (!empty((string)$param) &&  $param === 'Необработанные заявки' && $item["status"] === 'Не обработан') ||
                    (empty((string)$param) || (!empty((string)$param) &&  $param === 'Все заявки'))
                )
                {
                    $html .= $data;
                }
            } else {
                $html .= '<tr>
                    <td>' . $item->first_name . '</td>
                    <td>' . $item->last_name . '</td>
                    <td>' . $item->email . '<hr />' . $item->phone . '</td>
                    <td>
                        <a href="#" class="d-block mx-auto btn bg-dark text-light border-dark">Показать события</a>
                    </td>
                    <td>
                        <a href="#" class="d-block mx-auto btn bg-dark text-light border-dark">Показать спортсменов</a>
                    </td>
                </tr>';
            }
        }
        return $html;
    }
@endphp

<div>
    @if(request('view') === 'order_event')
    <div class="row mb-2">
        <section>
            <a href="admin?view=order_event&&filter=Все заявки" class="btn btn-dark">Все заявки</a>
            <a href="admin?view=order_event&&filter=Обработанные заявки" class="btn btn-light">Обработанные заявки</a>
            <a href="admin?view=order_event&&filter=Необработанные заявки" class="btn btn-light">Необработанные заявки</a>
            <hr>
        </section>
    </div>
    @endif
    <table class="table table-primarytable-striped table-hover table-bordered table-borderless">
        <thead class="table-dark">
        <tr>
            @php echo $getTitle($titleList[$tableEntity]); @endphp
        </tr>
        </thead>
        <tbody>
            @php echo $getContent($content, $tableEntity); @endphp

        </tbody>
    </table>
</div>
