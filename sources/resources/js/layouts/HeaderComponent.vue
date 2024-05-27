<script>
import { BASE_URL, TOKEN, IDENTIFIER } from '../constant';
import Menubar from 'primevue/menubar';
import Image from 'primevue/image';
import Button from 'primevue/button';

export default {
    name: 'HeaderComponent',
    data() {
        return {
            baseUrl: BASE_URL,
            token: null,
            items: [
                {
                    text: 'События',
                }
            ]
        };
    },
    components: {
        Menubar: Menubar,
        Image: Image,
        Button: Button,
    },
    methods: {
        tokenRead: function ()
        {
          this.token = window.$cookies.get(TOKEN);
        },
        logout: function ()
        {
            window.$cookies.remove(TOKEN);
            window.$cookies.remove(IDENTIFIER);
            window.location = BASE_URL;
        }
    },
    beforeMount() {
        this.tokenRead()
    }
}
</script>

<template>
    <header>
        <Menubar :model="items" style="
                backgroundColor: var(--surface-900);
                borderRadius: 0px;
                border: none;
        ">
            <template #start>
                <a :href="baseUrl">
                    <Image :src="baseUrl +'images/logo.png'" alt="Image" width="250" />
                </a>
            </template>
            <template #item="{ item }"> <!-- TODO: добавить меню --> </template>
            <template #end>
                <div class="flex align-items-center gap-2">
                    <Button v-if="this.token" label="Выход" severity="success" @click="logout" />
                    <a v-else :href="baseUrl + 'login'">
                        <Button label="Войти в личный кабинет" severity="success" />
                    </a>
                </div>
            </template>
        </Menubar>
    </header>
</template>

