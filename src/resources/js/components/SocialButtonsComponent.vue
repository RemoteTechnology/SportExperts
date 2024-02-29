<template>
    <div class="col mb-4">
        <p class="text-center mb-2"><strong >Войти через Вконтакте</strong></p>
        <div id="vk_oauth"></div>
    </div>
    <hr>
    <div class="col mb-4">
        <p class="text-center mb-2"><strong >Войти через Google</strong></p>
        <div class="g-signin2" data-onsuccess="onSignIn"></div>
    </div>
</template>

<script>
    import axios from "axios";

    export default {
        name: 'SocialButtonsComponent',
        methods: {

        },
        mounted() {
            VK.init({ apiId: 51572081 });
            VK.Widgets.Auth("vk_oauth", {width: 390, authUrl: "/login"});
            window.vkAsyncInit = function() {
                VK.init({
                    apiId: 51572081
                });
            };
            function onSignIn(googleUser) {
                var profile = googleUser.getBasicProfile();
                console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
                console.log('Name: ' + profile.getName());
                console.log('Image URL: ' + profile.getImageUrl());
                console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.
            }
        }
    }
</script>

<style scoped>

</style>
