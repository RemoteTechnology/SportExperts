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
<!--                        <li className="nav-item">-->
<!--                            <a className="nav-link" aria-current="page" href="#">Home</a>-->
<!--                        </li>-->
<!--                        <li className="nav-item">-->
<!--                            <a className="nav-link" aria-current="page" href="#">Link</a>-->
<!--                        </li>-->
<!--                        <li className="nav-item">-->
<!--                            <a className="nav-link" aria-current="page" href="#">Link 2</a>-->
<!--                        </li>-->
<!--                        <li className="nav-item">-->
<!--                            <a className="nav-link disabled" aria-current="page" aria-disabled="true">Disabled</a>-->
<!--                        </li>-->
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
                isAuth: $cookies.get('bearerToken') && $cookies.get('user_id')
            };
        },
        methods: {
            logout: function()
            {
                $cookies.remove('bearerToken');
                $cookies.remove('user_id');
                this.isAuth = false;
                this.$router.push('/');
            }
        },
        beforeMount() {

        }
    }
</script>

<style scoped>

</style>
