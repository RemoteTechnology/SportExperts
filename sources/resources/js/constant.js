const baseUrl = 'http://localhost:8080/';
const jsonRpcVersion = '2.0';
// Процедуры
const procedures = {
    users: {
        registration: 'UserRegistrationProcedure',
    },
    auth: {
        login: 'AuthByEmailProcedure',
    }
};
const requestMethodDefault = 'handle';

export { baseUrl, jsonRpcVersion, requestMethodDefault, procedures };
