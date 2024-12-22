<div>
    <table class="table table-primarytable-striped table-hover table-bordered table-borderless">
        <thead class="table-dark">
        <tr>
            <th scope="col">Статус</th>
            <th scope="col">Заголовок</th>
            <th scope="col">Локация</th>
            <th scope="col">Даты</th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
        @foreach($content as $item)
            <tr>
                <td>{{ $item['status'] }}</td>
                <td>{{ $item['data']['name'] }}</td>
                <td>{{ $item['data']['location'] }}</td>
                <td>{{ $item['data']['start_date'] }} - {{ $item['data']['expiration_date'] }}</td>
                <td>
                    <a href="{{ route('admin') }}?view=demo&&key={{ $item['key'] }}" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgb(241 241 241);">
                            <path d="M19 4h-3V2h-2v2h-4V2H8v2H5c-1.103 0-2 .897-2 2v14c0 1.103.897 2 2 2h14c1.103 0 2-.897 2-2V6c0-1.103-.897-2-2-2zM5 20V7h14V6l.002 14H5z"></path>
                            <path d="M7 9h10v2H7zm0 4h5v2H7z"></path>
                        </svg>
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
