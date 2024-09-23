<script setup>

</script>

<template>
    <form class="w-50">
        <div class="form-block">
            <label for="#">Введите название мероприятия</label>
            <InputText type="text" v-model="event.name" class="w-100"/>
        </div>
        <div class="form-block">
            <label for="#">Введите описание</label>
            <!-- TODO: удалить или применить html теги при сохранении в бд -->
            <QuillEditor ref="editor"
                         v-model:content="event.description"
                         :options="editor"
                         content-type="html"/>
        </div>
        <div class="form-block">
            <Card>
                <template #content>
                    <section v-if="this.eventId" class="mb-3">
                        <p>Текущий баннер события:</p>
                        <Image :src="this.baseUrl + 'storage/uploads/' + event.image.name"
                               :alt="event.name"
                               style="display:block;"
                               class="w-74"
                               preview />
                    </section>
                    <label class="text-center" for="#">Добавьте баннер</label>
                    <br>
                    <section class="d-flex d-center">
                        <!-- TODO: разрешать загрузку баннера размеров 600х602 -->
                        <FileUpload ref="fileInput"
                                    mode="basic"
                                    name="file"
                                    accept="image/*"
                                    :maxFileSize="1000000"
                                    chooseLabel="Загрузить" />
                    </section>
                </template>
            </Card>
        </div>
        <div class="form-block">
            <label for="#">Укажите место проведения мероприятия</label>
            <InputText type="text" v-model="event.location" class="w-100"/>
            <small id="username-help">Желательный формат: Город, улица, номер дома</small>
        </div>
        <div class="d-flex d-between">
            <div class="form-block w-70">
                <label for="#">Укажите дату старта</label>
                <Calendar v-model="event.start_date" class="w-70" />
            </div>
            <div class="form-block w-70">
                <label for="#">Укажите время старта</label>
                <InputText type="time" v-model="event.start_time" class="w-70" />
            </div>
        </div>
        <div class="d-flex d-between">
            <div class="form-block w-70">
                <label for="#">Укажите дату старта</label>
                <Calendar v-model="event.expiration_date" class="w-70" />
            </div>
            <div class="form-block w-70">
                <label for="#">Укажите время старта</label>
                <InputText type="time" v-model="event.expiration_time" class="w-70" />
            </div>
        </div>
        <section class="mb-5">
            <Button v-if="this.eventId == null"
                    type="button"
                    label="Создать событие"
                    class="w-100 mt-3"
                    severity="success"
                    @click="this.createEventObject" />
            <Button v-else
                    type="button"
                    label="Обновить"
                    class="w-100 mt-3"
                    severity="success"
                    @click="this.updateEventObject" />
        </section>
        <br>
    </form>
</template>

<style scoped>

</style>
