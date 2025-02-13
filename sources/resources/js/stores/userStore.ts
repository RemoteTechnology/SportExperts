import { defineStore } from "pinia";
import { type User } from "../models/user/type";
import { registrationRequest } from "../api/UserRequest";
import { createLogOptionRequest } from "../api/CreateLogOptionRequest";
import { MESSAGES } from "../common/messages";

export const useUsersStore = defineStore("users", {
    state: () => ({
        users: [] as User[],
        user: null as User,
        responseError: null as object,
        messageSuccessEmit: null as string,
        messageErrorEmit: null as string,
        currentDate: new Date()
    }),

    getters: {
        getUsers: (state) => state.users,
        getUser: (state) => state.user,
        getResponseError: (state) => state.responseError,
        getMessageSuccessEmit: (state) => state.messageSuccessEmit,
        getMessageErrorEmit: (state) => state.messageErrorEmit,
    },
    actions: {
        async v1UserCreate(attributes: object|object[]): Promise<void> {
            await registrationRequest(attributes)
                .then(async (response) => {
                    if ('error' in response.data) {
                        this.responseError = response.data.error.data;
                        return;
                    }
                    this.messageSuccessEmit = MESSAGES.FORM_SUCCESS;
                    const data = response.data.result.original;
                    this.user = data?.attributes;
                })
                .catch(async (error) => {
                    await createLogOptionRequest({
                        current_date: `${this.currentDate.getDate().toString().padStart(2, '0')}-${(this.currentDate.getMonth() + 1).toString().padStart(2, '0')}-${this.currentDate.getFullYear()}`,
                        current_time: `${this.currentDate.getHours().toString().padStart(2, '0')}:${this.currentDate.getMinutes().toString().padStart(2, '0')}:${this.currentDate.getSeconds().toString().padStart(2, '0')}`,
                        method: 'v1UserCreate',
                        status: error.code,
                        request_data: attributes.toString(),
                        message: error.message
                    })
                });
        },
    }
});
