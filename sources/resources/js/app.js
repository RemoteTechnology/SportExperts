/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp } from 'vue';
import VueCookies from 'vue-cookies'
import PrimeVue from 'primevue/config';
import 'primevue/resources/themes/aura-light-blue/theme.css';
import "primeicons/primeicons.css";
import '@vueup/vue-quill/dist/vue-quill.snow.css';

/**
 * Next, we will create a fresh Vue application instance. You may thlayouten begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const app = createApp({});
app.use(PrimeVue, { unstyled: false });
app.use(VueCookies, {
    expires: '7d',
    path: '/',
    domain: '',
    secure: '',
    sameSite: 'Lax' ,
    partitioned: false
});
// Use Layouts
import HeaderComponent from './layouts/HeaderComponent.vue';
app.component('header-component', HeaderComponent);

// Use View
import HomeView from './views/HomeView.vue';
app.component('home-view', HomeView);

import RegistrationView from './views/Users/RegistrationView.vue';
app.component('registration-view', RegistrationView);

import LoginView from './views/Users/LoginView.vue';
app.component('login-view', LoginView);

import RecoveryView from './views/Users/RecoveryView.vue';
app.component('recovery-view', RecoveryView);

import ProfileView from './views/Users/ProfileView.vue';
app.component('profile-view', ProfileView);

import Settings from './views/Users/SettingsView.vue';
app.component('settings-view', Settings);

import InvitedView from './views/Participants/InvitedView.vue';
app.component('participant-invited-view', InvitedView);

import HistoryView from './views/Events/HistoryView.vue';
app.component('history-view', HistoryView);

import EventListView from './views/Events/ListView.vue';
app.component('event-view', EventListView);

import CreateOfUpdateView from './views/Events/CreateOfUpdateView.vue';
app.component('event-create-of-update-view', CreateOfUpdateView);

import EventDetailsView from './views/Events/DetailsView.vue';
app.component('event-detail-view', EventDetailsView);
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */
app.mount('#app');
