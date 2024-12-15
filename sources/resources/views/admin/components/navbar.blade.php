<div class="h-100 p-3">
    <section id="navbarBrand">
        <img src="{{ asset('images/logo.png') }}" class="img-fluid" alt="SportExperts">
        <strong class="text-light">Панель администратора</strong>
    </section>
    <div class="mt-5"></div>
    <section id="navbarMenu">
        <div class="row mb-3">
            <a href="#" class="btn btn-light position-relative">
                <svg xmlns="http://www.w3.org/2000/svg"
                     width="20"
                     height="20"
                     viewBox="0 0 24 24"
                     style="fill: rgba(0, 0, 0, 1);">
                    <path d="M8 15h3v3h2v-3h3v-2h-3v-3h-2v3H8z"></path>
                    <path d="M19 4h-2V2h-2v2H9V2H7v2H5c-1.103 0-2 .897-2 2v14c0 1.103.897 2 2 2h14c1.103 0 2-.897 2-2V6c0-1.103-.897-2-2-2zm.002 16H5V8h14l.002 12z"></path>
                </svg>
                Заявки на события
                <span class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle">
                    <span class="visually-hidden">New alerts</span>
                </span>
            </a>
        </div>
        <div class="row mb-3">
            <a href="#" class="btn btn-light position-relative">
                <svg xmlns="http://www.w3.org/2000/svg"
                     width="20"
                     height="20"
                     viewBox="0 0 24 24"
                     style="fill: rgba(0, 0, 0, 1);">
                    <path d="M19 8h-2v3h-3v2h3v3h2v-3h3v-2h-3zM4 8a3.91 3.91 0 0 0 4 4 3.91 3.91 0 0 0 4-4 3.91 3.91 0 0 0-4-4 3.91 3.91 0 0 0-4 4zm6 0a1.91 1.91 0 0 1-2 2 1.91 1.91 0 0 1-2-2 1.91 1.91 0 0 1 2-2 1.91 1.91 0 0 1 2 2zM4 18a3 3 0 0 1 3-3h2a3 3 0 0 1 3 3v1h2v-1a5 5 0 0 0-5-5H7a5 5 0 0 0-5 5v1h2z"></path>
                </svg>
                Заявки на смену роли
                <span class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle">
                    <span class="visually-hidden">New alerts</span>
                </span>
            </a>
        </div>
        {{--  --}}
        <div class="row mb-3">
            <a href="#" class="btn btn-light">
                <svg xmlns="http://www.w3.org/2000/svg"
                     width="20"
                     height="20"
                     viewBox="0 0 24 24"
                     style="fill: rgba(0, 0, 0, 1);">
                    <path d="M20 7h-4V4c0-1.103-.897-2-2-2h-4c-1.103 0-2 .897-2 2v5H4c-1.103 0-2 .897-2 2v9a1 1 0 0 0 1 1h18a1 1 0 0 0 1-1V9c0-1.103-.897-2-2-2zM4 11h4v8H4v-8zm6-1V4h4v15h-4v-9zm10 9h-4V9h4v10z"></path>
                </svg>
                Лиды
            </a>
        </div>
        <div class="row mb-3">
            <a href="#" class="btn btn-light">
                <svg xmlns="http://www.w3.org/2000/svg"
                     width="20"
                     height="20"
                     viewBox="0 0 24 24"
                     style="fill: rgba(0, 0, 0, 1);">
                    <path d="M12 2a5 5 0 1 0 5 5 5 5 0 0 0-5-5zm0 8a3 3 0 1 1 3-3 3 3 0 0 1-3 3zm9 11v-1a7 7 0 0 0-7-7h-4a7 7 0 0 0-7 7v1h2v-1a5 5 0 0 1 5-5h4a5 5 0 0 1 5 5v1z"></path>
                </svg>
                Профили
            </a>
        </div>
        <div class="row mb-3">
            <a href="#" class="btn btn-light">
                <svg xmlns="http://www.w3.org/2000/svg"
                     width="20"
                     height="20"
                     viewBox="0 0 24 24"
                     style="fill: rgba(0, 0, 0, 1);">
                    <path d="M11 12h6v6h-6z"></path>
                    <path d="M19 4h-2V2h-2v2H9V2H7v2H5c-1.103 0-2 .897-2 2v14c0 1.103.897 2 2 2h14c1.103 0 2-.897 2-2V6c0-1.103-.897-2-2-2zm.001 16H5V8h14l.001 12z"></path>
                </svg>
                События
            </a>
        </div>
        <div class="row mb-3">
            <a href="#" class="btn btn-light">
                <svg xmlns="http://www.w3.org/2000/svg"
                     width="20"
                     height="20"
                     viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);">
                    <path d="M9 9h6v2H9zm0 4h6v2H9z"></path>
                    <path d="m18 5.414 1.707-1.707-1.414-1.414-1.563 1.562C15.483 2.708 13.824 2 12 2s-3.483.708-4.73 1.855L5.707 2.293 4.293 3.707 6 5.414A6.937 6.937 0 0 0 5 9H3v2h2v2H3v2h2c0 3.86 3.141 7 7 7s7-3.14 7-7h2v-2h-2v-2h2V9h-2a6.937 6.937 0 0 0-1-3.586zM17 13v2c0 2.757-2.243 5-5 5s-5-2.243-5-5V9c0-2.757 2.243-5 5-5s5 2.243 5 5v4z"></path>
                </svg>
                Лог трекер
            </a>
        </div>
        <hr>
        <div class="row mb-3">
            <a href="{{ route('home') }}" class="btn btn-light">
                На сайт
                <svg xmlns="http://www.w3.org/2000/svg"
                     width="20"
                     height="20"
                     viewBox="0 0 24 24"
                     style="fill: rgba(0, 0, 0, 1);">
                    <path d="m11.293 17.293 1.414 1.414L19.414 12l-6.707-6.707-1.414 1.414L15.586 11H6v2h9.586z"></path>
                </svg>
            </a>
        </div>
        {{--  --}}
    </section>
</div>
