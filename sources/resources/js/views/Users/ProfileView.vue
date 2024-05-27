<script>
import { BASE_URL, TOKEN, IDENTIFIER } from '../../constant';
import { getUser } from '../../api/UserRequest';
import Card from 'primevue/card';
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
import Message from 'primevue/message';
import Image from 'primevue/image';

export default {
    data() {
        return {
            baseUrl: BASE_URL,
            id: null,
            user: null,
            token: null,
        };
    },
    components: {
        Card: Card,
        InputText: InputText,
        Button: Button,
        Message: Message,
        Image: Image,
    },
    methods: {
        userIdentifier: function ()
        {
            getUser({id: window.$cookies.get(IDENTIFIER)})
                .then((response) => { this.user = response.data.result.original })
                .catch((error) => { /*TODO: тут надо что то придумать.*/ console.log(error) })
        },
        tokenRead: function ()
        {
            this.token = window.$cookies.get(TOKEN);
        },
        logout: function ()
        {
            window.$cookies.remove(TOKEN);
            window.$cookies.remove(IDENTIFIER);
            window.location = this.baseUrl;
        }
    },
    beforeMount() {
        this.userIdentifier();
        this.tokenRead();
    }
}
</script>

<template>
    <section class="d-flex d-center">
        <div v-if="this.user"  class="text-center mt-5">
            <h2>Профиль
                <span v-if="this.user.role === 'admin'">Администратора</span>
                <span v-if="this.user.role === 'athlete'">Спортсмена</span></h2>
        </div>
    </section>
    <section class="d-flex d-between container">
        <div class="w-30">
            <Image src="images/athlete_default_avatar.png" width="250" />
            <div class="mt-06">
                <h2>
                    <strong>{{ this.user.first_name }} {{ this.user.last_name }}</strong> <br>
                    <small>{{ this.user.first_name_eng }} {{ this.user.last_name_eng }}</small>
                </h2>
            </div>
            <div class="mt-06">
                <a :href="this.baseUrl + 'profile/settings'">
                    <Button type="button" label="Настройки" class="w-50" severity="secondary"/>
                </a>
            </div>
            <div class="mt-06">
                <Button type="button" label="Выход" class="w-50" severity="danger" @click="logout"/>
            </div>
        </div>
        <div class="w-70">
            <section class="mb-5">
                <Card style="border-radius: 5em;">
                    <template #content>
                        <div class="d-flex d-between d-align-center">
                            <h3>Ближайшие мероприятия</h3>
                            <a href="#">
                                <Button type="button" label="Все мои мероприятия"  severity="link"/>
                            </a>
                        </div>
                    </template>
                </Card>
            </section>
        </div>
    </section>
</template>
