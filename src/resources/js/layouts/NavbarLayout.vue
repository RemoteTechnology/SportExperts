<template>
    <header class="col">
        <nav className="navbar navbar-expand-lg">
            <div className="container">
                <div class="col-3">
                    <router-link className="navbar-brand" to="/">
                        <img src="img/logo.png"
                             class="img-fluid"
                             alt="SportExperts">
                    </router-link>
                </div>
                <div className="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul className="navbar-nav me-auto mb-2 mb-lg-0">
                        <li className="nav-item"
                            v-for="item in menuList"
                            key="item">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 width="24"
                                 height="24"
                                 viewBox="0 0 24 24"
                                 style="fill: rgba(255, 255, 255, 1);">
                                <path v-bind:d="item.path_d"></path>
                            </svg>
                            <router-link v-bind:class="`nav-link`"
                                         aria-current="page"
                                         v-bind:to="item.url">{{ item.title }}</router-link>
                        </li>
                    </ul>
                    <!-- TODO: После входа или выхода передать состояние в компонент -->
                    <section className="d-flex justify-content-between w-20" v-if="isAuth">
                        <button type="button"
                                className="btn"
                                v-on:click="logout">Выйти</button>
                    </section>
                    <section className="d-flex justify-content-between w-20" v-else>
                        <a className="btn"
                           aria-current="page"
                           href="/login">Вход</a>
                        <a className="btn"
                           aria-current="page"
                           href="/registration">Регистрация</a>
                    </section>
                </div>
            </div>
        </nav>
    </header>
</template>

<script>
    export default {
        name: 'NavbarLayout',
        data() {
            return {
                menuList: [
                    {title: 'События', url: '/events', path_d: 'M19 4h-2V2h-2v2H9V2H7v2H5c-1.103 0-2 .897-2 2v14c0 1.103.897 2 2 2h14c1.103 0 2-.897 2-2V6c0-1.103-.897-2-2-2zm-1 15h-6v-6h6v6zm1-10H5V7h14v2z'}
                ],
                isAuth: $cookies.get('bearerToken') && $cookies.get('user_id')
            };
        },
        methods: {
            logout: function()
            {
                $cookies.remove('bearerToken');
                $cookies.remove('user_id');
                this.isAuth = false;
                this.$router.push('/').redirect('/');
            }
        },
        beforeMount() {

        }
    }
</script>

<style scoped>

</style>
