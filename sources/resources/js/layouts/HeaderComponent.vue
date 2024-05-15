<script>
import { baseUrl } from '../constant';
import Menubar from 'primevue/menubar';
import Image from 'primevue/image';
import Button from 'primevue/button';

export default {
    name: 'HeaderComponent',
    data() {
        return {
          baseUrl: baseUrl,
          items: [

          ]
        };
    },
    components: {
        Menubar: Menubar,
        Image: Image,
        Button: Button,
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
                    <Image src="images/logo.png" alt="Image" width="250" />
                </a>
            </template>
            <template #item="{ item }"> <!-- TODO: добавить меню --> </template>
            <template #end>
                <div class="flex align-items-center gap-2">
                    <a :href="baseUrl + 'login'">
                        <Button label="Войти в личный кабинет" severity="success" />
                    </a>
                </div>
            </template>
        </Menubar>
    </header>
</template>

