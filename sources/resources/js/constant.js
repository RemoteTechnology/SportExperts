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
