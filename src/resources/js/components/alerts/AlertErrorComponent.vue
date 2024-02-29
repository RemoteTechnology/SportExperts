<template>
    <div class="alert alert-danger" role="alert">{{ this.message }}</div>
</template>

<script>
export default {
    name: 'AlertErrorComponent',
    props: {
        message: String
    }
}
</script>

<style scoped>

</style>
