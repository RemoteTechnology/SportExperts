<template>
    <div class="col mb-4">
<!--        <p class="text-center mb-2"><strong >Войти через Вконтакте</strong></p>-->
<!--        <div id="vk_oauth"></div>-->
        <button type="button"
                id="loginWithVk"
                class="btn btn-vk w-100">
            <svg xmlns="http://www.w3.org/2000/svg"
                 width="24"
                 height="24"
                 viewBox="0 0 24 24"
                 style="fill: rgba(255, 255, 255, 1);">
                <path d="M21.579 6.855c.14-.465 0-.806-.662-.806h-2.193c-.558 0-.813.295-.953.619 0 0-1.115 2.719-2.695 4.482-.51.513-.743.675-1.021.675-.139 0-.341-.162-.341-.627V6.855c0-.558-.161-.806-.626-.806H9.642c-.348 0-.558.258-.558.504 0 .528.79.65.871 2.138v3.228c0 .707-.127.836-.407.836-.743 0-2.551-2.729-3.624-5.853-.209-.607-.42-.852-.98-.852H2.752c-.627 0-.752.295-.752.619 0 .582.743 3.462 3.461 7.271 1.812 2.601 4.363 4.011 6.687 4.011 1.393 0 1.565-.313 1.565-.853v-1.966c0-.626.133-.752.574-.752.324 0 .882.164 2.183 1.417 1.486 1.486 1.732 2.153 2.567 2.153h2.192c.626 0 .939-.313.759-.931-.197-.615-.907-1.51-1.849-2.569-.512-.604-1.277-1.254-1.51-1.579-.325-.419-.231-.604 0-.976.001.001 2.672-3.761 2.95-5.04z"></path>
            </svg> Войти через Вконтакте</button>
    </div>
    <div class="col mb-4">
<!--        <p class="text-center mb-2"><strong >Войти через Google</strong></p>-->
<!--        <div class="g-signin2" data-onsuccess="onSignIn"></div>-->
        <button type="button"
                id="loginWithGoogle"
                class="btn btn-google w-100">
            <svg xmlns="http://www.w3.org/2000/svg"
                 width="24"
                 height="24"
                 viewBox="0 0 24 24"
                 style="fill: rgba(255, 255, 255, 1);">
                <path d="M20.283 10.356h-8.327v3.451h4.792c-.446 2.193-2.313 3.453-4.792 3.453a5.27 5.27 0 0 1-5.279-5.28 5.27 5.27 0 0 1 5.279-5.279c1.259 0 2.397.447 3.29 1.178l2.6-2.599c-1.584-1.381-3.615-2.233-5.89-2.233a8.908 8.908 0 0 0-8.934 8.934 8.907 8.907 0 0 0 8.934 8.934c4.467 0 8.529-3.249 8.529-8.934 0-.528-.081-1.097-.202-1.625z"></path>
            </svg> Войти через Google</button>
    </div>
    <!-- Подключаем jQuery и openapi.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://vk.com/js/api/openapi.js?154" type="text/javascript"></script>
</template>

<script>
    import axios from "axios";

    export default {
        name: 'SocialButtonsComponent',
        data() {
            return {
                charMap: {
                    'а': 'a', 'б': 'b', 'в': 'v', 'г': 'g', 'д': 'd', 'е': 'e', 'ё': 'e', 'ж': 'zh',
                    'з': 'z', 'и': 'i', 'й': 'j', 'к': 'k', 'л': 'l', 'м': 'm', 'н': 'n',
                    'о': 'o', 'п': 'p', 'р': 'r', 'с': 's', 'т': 't', 'у': 'u', 'ф': 'f', 'х': 'h',
                    'ц': 'c', 'ч': 'ch', 'ш': 'sh', 'щ': 'sh', 'ъ': '',
                    'ы': 'y', 'ь': '', 'э': 'e', 'ю': 'yu', 'я': 'ya'
                }
            }
        },
        mounted() {
            const urlParams = this.$route.fullPath.split('&');
            if (urlParams.length > 0)
            {
                for(let i=0; i < urlParams.length; i++)
                {
                    if(urlParams[i].split('=')[0] === 'access_token')
                    {
                        window.google_access_token = urlParams[i].split('=')[1];
                        axios.get('https://www.googleapis.com/oauth2/v1/userinfo', {
                            headers: {
                                'Authorization': `Bearer ${urlParams[i].split('=')[1]}`
                            }
                        })
                        .then((response) => {
                            axios.post('/api/user/auth/callback/Google',{
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept':       'application/json'
                                },
                                google_id:              response.data.id,
                                google_access_token:    window.google_access_token,

                                first_name:             response.data.family_name,
                                last_name:              response.data.given_name,
                                first_name_eng:         response.data.family_name
                                                            .split('')
                                                            .map(char => this.charMap[char.toLowerCase()] || char)
                                                            .join(''),
                                last_name_eng:          response.data.given_name
                                                            .split('')
                                                            .map(char => this.charMap[char.toLowerCase()] || char)
                                                            .join(''),
                                email:                  response.data.email
                            })
                            .then((response) => {
                                window.google_access_token = null;
                                $cookies.set('bearerToken', `Bearer ${response.data.personal_access_token}`);
                                $cookies.set('user_id', response.data.user.id);
                                document.location.href = '/profile';
                            })
                        })
                    }
                }
            }
            // Auth Vk
            document.getElementById('loginWithVk')
                .addEventListener('click', function() {
                    VK.init({ apiId: 51572081 });
                    VK.Auth.login(function (response) {
                        const charMap = {
                            'а': 'a', 'б': 'b', 'в': 'v', 'г': 'g', 'д': 'd', 'е': 'e', 'ё': 'e', 'ж': 'zh',
                            'з': 'z', 'и': 'i', 'й': 'j', 'к': 'k', 'л': 'l', 'м': 'm', 'н': 'n',
                            'о': 'o', 'п': 'p', 'р': 'r', 'с': 's', 'т': 't', 'у': 'u', 'ф': 'f', 'х': 'h',
                            'ц': 'c', 'ч': 'ch', 'ш': 'sh', 'щ': 'sh', 'ъ': '',
                            'ы': 'y', 'ь': '', 'э': 'e', 'ю': 'yu', 'я': 'ya'
                        };
                        axios.post('/api/user/auth/callback/Вконтакте',{
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept':       'application/json'
                            },
                            vk_id:              response.session.user.id,
                            vk_sid_token:       response.session.sid,
                            vk_sig_token:       response.session.sig,
                            first_name:         response.session.user.first_name,
                            last_name:          response.session.user.last_name,
                            first_name_eng:     response.session.user.first_name
                                                    .split('')
                                                    .map(char => charMap[char.toLowerCase()] || char)
                                                    .join(''),
                            last_name_eng:      response.session.user.last_name
                                                    .split('')
                                                    .map(char => charMap[char.toLowerCase()] || char)
                                                    .join(''),
                        })
                        .then((response) => {
                            $cookies.set('bearerToken', `Bearer ${response.data.personal_access_token}`);
                            $cookies.set('user_id', response.data.user.id);
                            document.location.href = '/profile';
                        })
                    });
                });
            // Auth Google
            document.getElementById('loginWithGoogle')
                .addEventListener('click', function () {
                    var form = document.createElement('form');
                    form.setAttribute('method', 'GET');
                    form.setAttribute('action', 'https://accounts.google.com/o/oauth2/v2/auth');
                    var params = {
                        'client_id': '28317098568-gq1dl8s4f636s0sft3h8ro135ivom0vd.apps.googleusercontent.com',
                        'redirect_uri': 'http://127.0.0.1/login',
                        'response_type': 'token',
                        'scope': 'profile',
                        'access_type': 'online',
                        'include_granted_scopes': 'true',
                        'state': 'pass-through value'
                    };
                    for (var p in params) {
                        var input = document.createElement('input');
                        input.setAttribute('type', 'hidden');
                        input.setAttribute('name', p);
                        input.setAttribute('value', params[p]);
                        form.appendChild(input);
                    }
                    document.body.appendChild(form);
                    form.submit();
                });
        }
    }
</script>

<style scoped>

</style>
