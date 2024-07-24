<script>
import {
    BASE_URL,
    IDENTIFIER,
    MESSAGES,
    ENDPOINTS,
    RESPONSE
} from "../../constant";
import { getEventListRequest } from '../../api/EventRequest';
import { loggingRequest } from '../../api/LoggingRequest';
import Card from 'primevue/card';
import Button from 'primevue/button';
import Dialog from 'primevue/dialog';
import Paginator from 'primevue/paginator';
import InlineMessage from 'primevue/inlinemessage';
import InputText from 'primevue/inputtext';
import { getUser } from "../../api/UserRequest";
import { getRecordToEventsRequest } from "../../api/FilterRequest";
import {createOptionRequest, getOptionRequest} from "../../api/OptionRequest";
import Message from "primevue/message";

export default {
    data() {
      return {
          userOptionView: false,
          messageSuccess: false,
          messageError: false,
          response: RESPONSE,
          route: ENDPOINTS,
          baseUrl: BASE_URL,
          events: null,
          eventsToRead: null,
          user: null,
          options: [
              {
                  user_id: window.$cookies.get(IDENTIFIER),
                  entity: 'user',
                  name: 'Weight',
                  value: null,
                  type: 'string',
              },
              {
                  user_id: window.$cookies.get(IDENTIFIER),
                  entity: 'user',
                  name: 'Height',
                  value: null,
                  type: 'string',
              },
          ],
          noData: MESSAGES.NO_DATA,
          currentDate: new Date(),
          visible: true
      };
    },
    components: {
        Card: Card,
        Button: Button,
        InputText: InputText,
        Dialog: Dialog,
        Message: Message,
        Paginator: Paginator,
        InlineMessage: InlineMessage
    },
    methods: {
        formatDate: (inputDate) => {
            const [year, month, day] = inputDate.split('-');
            return `${day.padStart(2, '0')}.${month.padStart(2, '0')}.${year}`;
        },
        short: (str, maxlen) => str.length <= maxlen ? str : str.slice(0, maxlen) + '...',
        stripHtmlTags: function(html)
        {
            let tmp = document.createElement("DIV");
            tmp.innerHTML = html;
            return tmp.textContent || tmp.innerText || "";
        },
        userIdentifier: async function ()
        {
            const userId = window.$cookies.get(IDENTIFIER);
            if (userId)
            {
                let attributes = {id: userId};
                await getUser(attributes)
                    .then((response) => { this.user = response.data.result.original; })
                    .catch((error) => {
                        loggingRequest({
                            current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                            current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                            method: 'getUser',
                            status: error.code,
                            request_data: attributes.toString(),
                            message: error.message
                        })
                    });
            }
        },
        userReadToEvent: async function ()
        {
            let attributes = `invited_user_id:${window.$cookies.get(IDENTIFIER)}`;
            await getRecordToEventsRequest(attributes, 'after')
                .then((response) => { this.eventsToRead = response.data.result.original; })
                .catch((error) => {
                    loggingRequest({
                        current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                        current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                        method: 'getRecordToEventsRequest',
                        status: error.code,
                        request_data: attributes.toString() + 'mode:after',
                        message: error.message
                    });
                    this.messageError = MESSAGES.LOADING_ERROR;
                });
        },
        eventList: async function ()
        {
            await getEventListRequest()
                .then((response) => { console.log(response); this.events = response.data.result.original; })
                .catch((error) => {
                    console.log(error);
                    loggingRequest({
                        current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                        current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                        method: 'getUser',
                        status: error.code,
                        request_data: '',
                        message: error.message
                    })
                });
        },
        userOptionsCreate: async function (idx)
        {
            if (this.options[idx].value)
            {
                let attributes = this.options[idx];
                await createOptionRequest(attributes)
                    .then((response) => {
                        this.options[idx] = response.data.result.original;
                        this.messageSuccess = MESSAGES.FORM_SUCCESS;
                    })
                    .catch((error) => {
                        this.messageError = MESSAGES.ERROR_ERROR;
                        loggingRequest({
                            current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                            current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                            method: 'userOptionsCreate',
                            status: error.code,
                            request_data: '',
                            message: error.message
                        })
                    });
            }
        },
        userOptionsUpdate: async function (idx)
        {
            if (this.options[idx].value)
            {
                let attributes = this.options[idx];
                await createOptionRequest(attributes)
                    .then((response) => {
                        this.options[idx] = response.data.result.original;
                        this.messageSuccess = MESSAGES.FORM_SUCCESS;
                    })
                    .catch((error) => {
                        this.messageError = MESSAGES.ERROR_ERROR;
                        loggingRequest({
                            current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                            current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                            method: 'userOptionsUpdate',
                            status: error.code,
                            request_data: '',
                            message: error.message
                        })
                    });
            }
        },
        setUserOptions: async function ()
        {
            for (let i=0; i < this.options.length; i++)
            {
                if (Object.keys(this.options[i]).includes('id'))
                {
                    await this.userOptionsUpdate(i);
                }
                else
                {
                    console.log(123)
                    await this.userOptionsCreate(i);
                }
            }
        },
        getUserOptions: async function()
        {
            let attributes = {
                user_id: this.user.id
            };
            await getOptionRequest(attributes)
                .then((response) => {
                    this.options = response.data.result.original;
                    if (this.options.length == 0)
                    {
                        this.userOptionView = true;
                    }
                })
                .catch((error) => {
                    loggingRequest({
                        current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                        current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                        method: 'getOptionRequest',
                        status: error.code,
                        request_data: '',
                        message: error.message
                    })
                });
        }
    },
    async beforeMount() {
        await this.userIdentifier();
        await this.eventList();
        if (this.user.role === 'athlete') {
            await this.userReadToEvent();
            await this.getUserOptions();
        }

    }
}
</script>

<template>
    <Dialog
        v-if="this.user && this.user.role === 'athlete' && this.userOptionView"
        v-model:visible="visible"
        modal
        header="Укажите ваши параметры"
        :style="{ width: '50rem' }"
        :breakpoints="{ '1199px': '75vw', '575px': '90vw' }">
        <section>
            <form>
                <small>Параметры учитываются в алгоритме жеребьёвки. Их желательно заполнить.</small>
                <section class="d-flex d-center">
                    <div class="form-block w-100">
                        <label for="name">Рост</label>
                        <InputText type="number"
                                   v-model="this.options[1].value"
                                   class="w-100"
                                   :value="this.options[1].value"
                                   required />
                    </div>
                </section>
                <section class="d-flex d-center">
                    <div class="form-block w-100">
                        <label for="name">Вес</label>
                        <InputText type="number"
                                   v-model="this.options[0].value"
                                   class="w-100"
                                   :value="this.options[0].value"
                                   required />
                    </div>
                </section>
                <Button type="button"
                        label="Добавить параметры"
                        class="w-100 mt-3"
                        severity="success"
                        @click="this.setUserOptions"/>
            </form>
        </section>
    </Dialog>
    <section v-if="this.events && this.events[this.response.data].length > 0" class="mt-5 mb-5">
        <section class="mt-1 mb-2" v-if="this.messageError">
            <Message severity="error">{{ this.messageError }}</Message>
        </section>
        <section class="mt-1 mb-2" v-if="this.messageSuccess">
            <Message severity="success">{{ this.messageSuccess }}</Message>
        </section>
        <section class="container d-flex d-between d-flex-wrap">
            <Card v-for="event in this.events[this.response.data]"
                  v-key="event"
                  style="overflow: hidden"
                  class="mb-3 w-22">
                <template #header>
                    <div :style="
                            'background-size: cover;' +
                            'background-position: top;' +
                            'background-image: url(' + this.baseUrl + 'storage/uploads/' + event.image.name + ');' +
                            'height: 14em;' +
                            'width: 100%;' +
                            'background-repeat: no-repeat;'
                    "></div>
                </template>
                <template #title>{{event.name }}</template>
                <template #content>
<!--                    <p class="m-0"> {{ this.stripHtmlTags(this.short(event.description, 130)) }}</p>-->
                </template>
                <template #footer>
                    <span>Даты проведения:</span>
                    <div class="d-flex d-between">
                        <strong>
                            <div>
                                <i class="pi pi-calendar-plus" style="
                                    font-weight: bold;
                                    color: #4aa81f;
                                "></i> {{ this.formatDate(event.start_date) }}
                            </div>
                            <div><i class="pi pi-stopwatch" style="
                                    font-weight: bold;
                                    color: #1f41a8;
                                "></i> {{ event.start_time.slice(0, -3) }}</div>
                        </strong>
                    </div>
                    <div v-for="eventParticipant in this.eventsToRead" class="flex gap-3 mt-2">
                        <section v-if="this.user && Object.keys(this.user).includes('role') && this.user.role == 'athlete'">
                            <a v-if="eventParticipant.key === event.key"
                               :href="this.baseUrl + this.route.EVENT + this.route.BASE + this.route.HISTORY + '?key=' + event.key">
                                <Button label="Вы записаны"
                                        icon="pi pi-check"
                                        severity="link"
                                        class="w-100" />
                            </a>
                            <a v-else
                               :href="this.baseUrl + this.route.EVENT + this.route.BASE + this.route.DETAIL + '?id=' + event.id">
                                <Button label="Записаться 1"
                                        severity="secondary"
                                        outlined
                                        class="w-100" />
                            </a>
                        </section>
                        <br>
                    </div>
                    <section>
                        <a v-if="this.user &&
                                Object.keys(this.user).includes('role') &&
                                this.user.role == 'admin'"
                           :href="this.baseUrl + this.route.EVENT + this.route.BASE + this.route.DETAIL + '?id=' + event.id">
                            <Button label="Подробнее"
                                    severity="secondary"
                                    outlined
                                    class="w-100" />
                        </a>
                    </section>
                    <section>
                        <a v-if="!this.user"
                           :href="this.baseUrl + this.route.EVENT + '/detail?id=' + event.id">
                            <Button label="Записаться"
                                    severity="secondary"
                                    outlined
                                    class="w-100" />
                        </a>
                    </section>
                </template>
            </Card>
        </section>
    </section>
    <section v-else class="d-flex d-center">
        <InlineMessage severity="info" class="w-50 mt-5">{{ this.noData }}</InlineMessage>
    </section>
<!--    <section v-if="this.events && this.events[this.response.data].length > 9" class="mt-5 mb-5">-->
<!--    <Paginator :rows="9" :totalRecords="120"></Paginator>-->
<!--    </section>-->
</template>

