<template>
    <div class="d-flex justify-content-center col-12">
        <div class="col-xxl-4 p-4">
            <div class="col-12">
                <h3 class="text-center">Вход</h3>
            </div>
            <form action="#" method="post">
                <div class="mb-3">
                    <label for="exampleInputEmail" class="form-label">Адрес электронной почты</label>
                    <input type="email"
                           class="form-control"
                           name="email"
                           id="exampleInputEmail">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword" class="form-label">Пароль</label>
                    <input type="password"
                           class="form-control"
                           name="password"
                           id="exampleInputPassword">
                </div>
                <button type="submit" class="btn btn-primary">Войти</button>
            </form>
            <div class="mt-3 mb-3 text-center">ИЛИ</div>
            <div class="col mb-3">
                <a href="#" class="btn btn-vk w-100">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         width="24"
                         height="24"
                         viewBox="0 0 24 24"
                         style="fill: rgba(255, 255, 255, 1);">
                        <path d="M21.579 6.855c.14-.465 0-.806-.662-.806h-2.193c-.558 0-.813.295-.953.619 0 0-1.115 2.719-2.695 4.482-.51.513-.743.675-1.021.675-.139 0-.341-.162-.341-.627V6.855c0-.558-.161-.806-.626-.806H9.642c-.348 0-.558.258-.558.504 0 .528.79.65.871 2.138v3.228c0 .707-.127.836-.407.836-.743 0-2.551-2.729-3.624-5.853-.209-.607-.42-.852-.98-.852H2.752c-.627 0-.752.295-.752.619 0 .582.743 3.462 3.461 7.271 1.812 2.601 4.363 4.011 6.687 4.011 1.393 0 1.565-.313 1.565-.853v-1.966c0-.626.133-.752.574-.752.324 0 .882.164 2.183 1.417 1.486 1.486 1.732 2.153 2.567 2.153h2.192c.626 0 .939-.313.759-.931-.197-.615-.907-1.51-1.849-2.569-.512-.604-1.277-1.254-1.51-1.579-.325-.419-.231-.604 0-.976.001.001 2.672-3.761 2.95-5.04z"></path>
                    </svg> Войти через Вконтакте
                </a>
            </div>
            <div class="col">
                <a href="#" class="btn btn-google w-100">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         width="24"
                         height="24"
                         viewBox="0 0 24 24"
                         style="fill: rgba(255, 255, 255, 1);">
                        <path d="M20.283 10.356h-8.327v3.451h4.792c-.446 2.193-2.313 3.453-4.792 3.453a5.27 5.27 0 0 1-5.279-5.28 5.27 5.27 0 0 1 5.279-5.279c1.259 0 2.397.447 3.29 1.178l2.6-2.599c-1.584-1.381-3.615-2.233-5.89-2.233a8.908 8.908 0 0 0-8.934 8.934 8.907 8.907 0 0 0 8.934 8.934c4.467 0 8.529-3.249 8.529-8.934 0-.528-.081-1.097-.202-1.625z"></path>
                    </svg> Войти через Google</a>
            </div>
        </div>
    </div>
</template>

<script setup>

</script>

<style scoped>

</style>
