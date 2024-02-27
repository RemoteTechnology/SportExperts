import { createWebHistory, createRouter } from "vue-router";
import Home from "@/views/HomeView.vue";
import Registration from "@/views/RegistrationView.vue";
import Login from "@/views/LoginView.vue";
import Error404 from "@/views/Error404View.vue"

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
