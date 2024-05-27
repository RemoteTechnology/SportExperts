<script>
import { BASE_URL } from '../../constant';
import Card from 'primevue/card';
import InputText from 'primevue/inputtext';
import InputMask from 'primevue/inputmask';
import Button from 'primevue/button';
import Message from 'primevue/message';
// import Image from 'primevue/image';

export default {
    data() {
      return {
          baseUrl: BASE_URL,
          user: {
              firstName: null,
              firstNameEng: null,
              lastName: null,
              lastNameEng: null,
              birthDate: null,
              gender: null,
              email: null,
              phone: null,
              password: null,
              newPassword: null,
          }
      };
    },
    components: {
        Card: Card,
        InputText: InputText,
        InputMask: InputMask,
        Button: Button,
        Message: Message,
        // Image: Image,
    }
}
</script>

<template>
    <section class="d-flex d-center">
        <section class="mt-5 w-30 mb-5">
            <div class="text-center">
                <h2>Настройки профиля</h2>
            </div>
            <Card>
                <template #content>
                    <h3>Общая информация:</h3>
                    <form>
                        <section class="d-flex d-center">
                            <div class="form-block w-100">
                                <label for="name">Имя</label>
                                <InputText type="text" v-model="user.firstName" class="w-100" :value="user.firstName" required />
                            </div>
                        </section>
                        <section class="d-flex d-center">
                            <div class="form-block w-100">
                                <label for="name">Имя на Английском</label>
                                <InputText type="text"v-model="user.firstNameEng" class="w-100" :value="user.firstNameEng" required />
                            </div>
                        </section>
                        <section class="d-flex d-center">
                            <div class="form-block w-100">
                                <label for="name">Фамилия</label>
                                <InputText type="text" v-model="user.lastName"  class="w-100" :value="user.lastName" required />
                            </div>
                        </section>
                        <section class="d-flex d-center">
                            <div class="form-block w-100">
                                <label for="name">Фамилия на Английском</label>
                                <InputText type="text" v-model="user.lastNameEng" class="w-100" :value="user.lastNameEng" required />
                            </div>
                        </section>
                        <section class="d-flex d-center">
                            <div class="form-block w-100">
                                <label for="name">Дата рождения</label>
                                <InputText type="date" v-model="user.birthDate" class="w-100" :value="user.birthDate" required />
                            </div>
                        </section>
                    </form>
                </template>
            </Card>
            <Card class="mt-5">
                <template #content>
                    <h3>Сменить адрес электронной почты</h3>
                    <form>
                        <section class="d-flex d-center">
                            <div class="form-block w-100">
                                <label for="name">Адрес электронной почты</label>
                                <InputText type="email" v-model="user.email" class="w-100" :value="user.email" required />
                            </div>
                        </section>
                    </form>
                </template>
            </Card>
            <Card class="mt-5">
                <template #content>
                    <h3>Сменить номер телефона</h3>
                    <form>
                        <section class="d-flex d-center">
                            <div class="form-block w-100">
                                <label for="name">Ваш номер телефона</label>
                                <InputMask type="tel" v-model="user.phone" :value="user.phone" mask="+7 (999) 999-99-99" class="w-100" />
                            </div>
                        </section>
                    </form>
                </template>
            </Card>
            <Card class="mt-5">
                <template #content>
                    <h3>Сменить пароль</h3>
                    <form>
                        <section class="d-flex d-center">
                            <div class="form-block w-100">
                                <label for="name">Укажите текущий пароль</label>
                                <InputText type="password" v-model="user.password" :value="user.password" class="w-100" />
                                <div class="mt-3"></div>
                                <label for="name">Укажите новый пароль</label>
                                <InputText type="password" v-model="user.newPassword" :value="user.newPassword" class="w-100" />
                            </div>
                        </section>
                    </form>
                </template>
            </Card>
        </section>
    </section>
</template>
