<template>
    <Navbar />
    <main class="wrapper container">
        <div class="mt-10">
            <router-view />
        </div>
    </main>
    <Footer />
</template>

<script>
import Navbar from "@/layouts/NavbarLayout.vue";
import Footer from "@/layouts/FooterLayout.vue";
    export default {
        name: 'HomeView',
        components: {
            Navbar,
            Footer
        }
    }
</script>
