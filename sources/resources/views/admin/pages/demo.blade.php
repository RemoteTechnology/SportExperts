<section class="container mt-5 mb-3">
    <div class="card p-4 rounded-3 border bg-warning-subtle border-warning-subtle mb-4 position-fixed" style="
        z-index: 9999999;
        width: 68% !important;
    ">
        <div class="row">
            <div class="col-9">
                <h3>Опубликовать событие?</h3>
            </div>
            <div class="col-3">
                @include('admin.components.forms.button_form', [
                    'buttonFormEntity'  => 'button_form.order.store',
                    'key'               => $content['event']['key']
                ])
            </div>
        </div>
    </div>
    <section class="row">
        <div class="col-12" style="margin-top: 10em;"></div>
        <div class="col-6">
            <img class="img-fluid" src="{{ asset('/storage/uploads/' . $content['banner']->name) }}" alt="{{ $content['event']['data']['name'] }}">
            <div class="mt-4">
                <h4 class="mb-5">Информация:</h4>
                {!! $content['event']['data']['description'] !!}
            </div>
        </div>
        <div class="col-6">
            <div class="card p-4 mb-5" style="
                background: #ffffff;
                color: #334155;
                box-shadow: 0 1px 3px #0000001a, 0 1px 2px -1px #0000001a;
                border-radius: 6px;
                border-color: aliceblue;
            ">
                <h4 class="text-center">
                    <b>{{ $content['event']['data']['name']  }}</b>
                </h4>
                <p><i class="pi pi-map-marker" style="color: rgb(34, 34, 34);"></i> <b>{{ $content['event']['data']['location'] }}</b></p>
                <p><i class="pi pi-calendar-clock" style="color: rgb(34, 34, 34);"></i> <b>{{ \Carbon\Carbon::parse($content['event']['data']['start_date'])->format('d.m.Y') }}</b></p>
                <p><i class="pi pi-users" style="color: rgb(34, 34, 34);"></i> <b>0 участников</b></p>
            </div>
            @if(count($content['options']) > 0)
                <div class="card p-4 mb-5" style="
                    background: #ffffff;
                    color: #334155;
                    box-shadow: 0 1px 3px #0000001a, 0 1px 2px -1px #0000001a;
                    border-radius: 6px;
                    border-color: aliceblue;
                ">
                    <h5 class="text-center">
                        <b>ПАРАМЕТРЫ</b>
                    </h5>
                    @foreach($content['options'] as $option)
                        <div class="mb-3">
                            <a href="#" class="d-block">
                                <b>{{ $option['data']['name'] }}</b>
                            </a>
                            <span>
                                <b>{{ $option['data']['value'] }}</b>
                            </span>
                        </div>
                    @endforeach
                </div>
            @endif
            <div class="card p-4 mb-5" style="
                background: #ffffff;
                color: #334155;
                box-shadow: 0 1px 3px #0000001a, 0 1px 2px -1px #0000001a;
                border-radius: 6px;
                border-color: aliceblue;
            ">
                <h5 class="text-center">
                    <b>СПИСКИ</b>
                </h5>
                <div class="mb-3">
                    <a href="#" class="d-block">
                        <b>Миронов Вячеслав</b>
                    </a>
                </div>
                <div class="mb-3">
                    <a href="#" class="d-block">
                        <b>Ванюков Дмитрий</b>
                    </a>
                </div>
                <div class="mb-3">
                    <a href="#" class="d-block">
                        <b>Константин Кохно</b>
                    </a>
                </div>
            </div>
        </div>
    </section>
</section>
