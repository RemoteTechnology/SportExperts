import './bootstrap';
import {createApp} from 'vue'
import App from './App.vue'
import router from './router'
import VueCookies from 'vue-cookies'

createApp(App).use(router).use(VueCookies, {
    expires: '1d',
    path: '/',
    domain: '',
    secure: '',
    sameSite: 'Lax'
}).mount("#app")
