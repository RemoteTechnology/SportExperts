<template>
    <div class="d-flex justify-content-center col-12">
        <div class="col-xxl-4 p-4">
            <div class="col-12">
                <h3 class="text-center">Вход</h3>
            </div>
            <LoginFormComponent />
            <div class="mt-3 mb-3 text-center">ИЛИ</div>
            <SocialButtonsComponent />
        </div>
    </div>
</template>

<script>
import LoginFormComponent from '@/components/forms/LoginFormComponent.vue';
import SocialButtonsComponent from '@/components/SocialButtonsComponent.vue';


 export default {
     name: 'LoginView',
     components: {
         LoginFormComponent,
         SocialButtonsComponent
     }
 }
</script>

<style scoped>

</style>
