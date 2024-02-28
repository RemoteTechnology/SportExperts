<template>
    <div class="d-flex justify-content-center col-12">
        <div class="col-xxl-5 p-4">
            <div class="col-12">
                <h3 class="text-center">Регистрация</h3>
            </div>
            <RegistrationFormComponent />
        </div>
    </div>
</template>

<script>
import RegistrationFormComponent from '@/components/forms/RegistrationFormComponent.vue'

export default {
    name: 'RegistrationView',
    data () {
        return {

        };
    },
    components: {
        RegistrationFormComponent
    },
    methods: {

    },
    beforeMount() {

    }
}
</script>

<style scoped>

</style>
