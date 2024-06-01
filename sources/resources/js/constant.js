const BASE_URL = 'http://localhost:8080/';
const JSON_RPC_VERSION = '2.0';
const TOKEN = 'user_personal_access_token';
const IDENTIFIER = 'user_identifier';
// Процедуры
const PROCEDURES = {
    users: {
        registration: 'UserRegistrationProcedure',
        read: 'UserReadProcedure',
        update: 'UserUpdateProcedure',
    },
    invites: {
        list: 'InvitedListProcedure',
        read: 'InvitedReadProcedure',
        // delete: 'InvitedDestroyProcedure',
    },
    auth: {
        login: 'AuthByEmailProcedure',
    },
    filter: {
        userRecord: 'EventDateFilterProcedure',
        ownerParticipantList: 'ParticipantOwnerFilterProcedure',
        ownerEventsList: 'EventOwnerFilterProcedure',
    },
    event: {
        list: 'EventListProcedure',
        create: 'EventStoreProcedure',
        read: 'EventReadProcedure',
        update: 'EventUpdateProcedure',
    },
    option: {
        create: 'OptionStoreProcedure',
        update: 'OptionUpdateProcedure',
    },
    participant: {
        create: 'ParticipantStoreProcedure',
    }
};
const REQUEST_METHOD_DEFAULT = 'handle';

export {
    BASE_URL,
    JSON_RPC_VERSION,
    TOKEN, IDENTIFIER,
    REQUEST_METHOD_DEFAULT,
    PROCEDURES
};
