<template>
    <section id="alert_modal" class="position-fixed w-100 h-100">
        <div class="col-7 bh-1 p-2">
            <div class="container">
                <h2 class="text-center">
                    Активируйте аккаунт! На почту мы отправили уведомление с ссылкой на активацию аккаунта.
                </h2>
                <div class="row">
                    <a href="/login" class="btn btn-primary w-75 mt-5 mx-auto btn-lg">Вход</a>
                </div>
            </div>
        </div>
    </section>
</template>

<script>

</script>

<style>
    #alert_modal{
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        background-color: #1a1a1a2e;
        display: flex;
        align-items: center;
    }
    .bh-1{
        box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15);
        left: 0;
        position: absolute !important;
        right: 0;
        margin: 0 auto;
        z-index: 99999999999999;
        height: 60%;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #fff;
    }
</style>
