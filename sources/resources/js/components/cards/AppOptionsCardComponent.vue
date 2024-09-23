<script setup>

</script>

<template>
    <section class="w-25" style="
                position: relative;
                left: -10%;
            ">
        <Card>
            <template #header>
                <h4 class="text-center">Параметры</h4>
            </template>
            <template #content>
                <form>
                    <section class="mb-3">
                        <div class="mb-3">
                            <label for="#">Название параметра</label>
                            <InputText type="text" v-model="this.optionName" class="w-100" />
                        </div>
                        <div class="mb-3">
                            <label for="#">Значение параметра</label>
                            <InputText type="text" v-model="this.optionValue" class="w-100" />
                        </div>
                        <Button type="button"
                                label="Добавить параметр"
                                class="w-100 mt-3"
                                severity="success"
                                @click="this.addOption" />
                    </section>
                </form>
            </template>
        </Card>
        <section class="mt-3">
            <Card v-for="(option, idx) in this.options" class="mt-1">
                <template #header>
                    <div class="d-flex d-end" style="
                                position: relative;
                                right: 5%;
                                top: 0.7em;
                            ">
                        <i class="pi pi-times pointer" @click="this.removeOption(idx)"></i>
                    </div>
                </template>
                <template #content>
                    <strong>{{ option.name }}</strong><br>
                    <span>{{ option.value }}</span>
                </template>
            </Card>
        </section>
    </section>
</template>

<style scoped>

</style>
