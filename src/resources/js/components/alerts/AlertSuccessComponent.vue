<template>
    <div class="alert alert-success" role="alert">{{ this.message }}</div>
</template>

<script>
export default {
    name: 'AlertSuccessComponent',
    props: {
        message: String
    }
}
</script>

<style scoped>

</style>
