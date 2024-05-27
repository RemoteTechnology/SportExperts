const BASE_URL = 'http://localhost:8080/';
const JSON_RPC_VERSION = '2.0';
const TOKEN = 'user_identifier';
const IDENTIFIER = 'user_identifier';
// Процедуры
const PROCEDURES = {
    users: {
        registration: 'UserRegistrationProcedure',
        read: 'UserReadProcedure',
    },
    auth: {
        login: 'AuthByEmailProcedure',
    }
};
const REQUEST_METHOD_DEFAULT = 'handle';

export { BASE_URL, JSON_RPC_VERSION, TOKEN, IDENTIFIER, REQUEST_METHOD_DEFAULT, PROCEDURES };
