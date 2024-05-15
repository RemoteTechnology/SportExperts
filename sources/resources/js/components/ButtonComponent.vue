<script>

export default {
    data() {
        return {
            active: 0
        };
    },
    name: 'ButtonComponent',
    props: {
        title: String,
    },
    components: {

    }
}
</script>

<template>
    <button type="button" class="btn btn-primary">Primary</button>
</template>
