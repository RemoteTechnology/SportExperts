import { createWebHistory, createRouter } from "vue-router";
import Home from "@/views/HomeView.vue";
import Registration from "@/views/RegistrationView.vue";
import Login from "@/views/LoginView.vue";
import Profile from "@/views/ProfileView.vue";
import Events from "@/views/events/EventsView.vue";
import CreateEvent from "@/views/events/CreateEventView.vue";
import MyEvents from "@/views/events/MyEventsView.vue";
import Error404 from "@/views/Error404View.vue";

const routes = [
    {
        path: "/",
        name: "Home",
        component: Home,
    },
    {
        path: "/registration",
        name: "Registration",
        component: Registration,
    },
    {
        path: "/login",
        name: "Login",
        component: Login,
    },
    {
        path: "/profile",
        name: "Profile",
        component: Profile,
    },
    {
        path: "/events",
        name: "Events",
        component: Events,
    },
    {
        path: "/events/create",
        name: "CreateEvent",
        component: CreateEvent,
    },
    {
        path: "/events/my",
        name: "MyEvents",
        component: MyEvents,
    },
    {
        path: '/:pathMatch(.*)*',
        name: 'Error404',
        component: Error404,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
