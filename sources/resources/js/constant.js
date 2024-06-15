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
        reset: 'ResetProcedure',
    },
    invites: {
        list: 'InvitedListProcedure',
        read: 'InvitedReadProcedure',
        notification: 'NotificationProcedure',
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
    archive: {
        create: 'ArchiveStoreProcedure',
        delete: 'ArchiveDestroyProcedure',
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

const MESSAGES = {
    NO_DATA: 'Данных нет!',
    NO_VALID_DATA: 'Проверьте правильность введенных данных!',
    ERROR_DEFAULT: 'Ошибка, пожалуйста обратитесь к администратору!',
    FORM_SUCCESS: 'Данные усмешно сохранены!',
    ERROR_ERROR: 'Ошибка сохранения данных!',
    LOADING_ERROR: 'Ошибка загрузки данных!',
    SEND_NOTIFICATION: 'Письмо отправлено вам на почту!',
    LOGIN_ERROR: 'Неправильный логин или пароль!',
    PASSWORD_DOUBLE: 'Пароли должны совпадать!',
    ARCHIVE_SUCCESS: 'Событие добавлено в архив!',
};
// TODO: Выставить всё по алфавиту, импорты во всех файлах тоже только там где это уместно!!!!
const ENDPOINTS = {
    API: {
        LIST: 'list',
        STORE: 'store',
        READ: 'read',
        UPDATE: 'update',
        DESTROY: 'destroy',
        FILTER: 'filter',
    },
    SETTINGS: 'settings',
    HISTORY: 'history',
    ARCHIVE: 'archive',
    BASE: '/',
    CREATE: 'create',
    DETAIL: 'detail',
    DELETE: 'delete',
    EVENT: 'event',
    FILTER: 'filter',
    LOGIN: 'login',
    PROFILE: 'profile',
    RECOVERY: 'recovery',
    REGISTRATION: 'registration',
    UPDATE: 'update',
};

const RESPONSE = {
    data: 'data'
};

export {
    BASE_URL,
    JSON_RPC_VERSION,
    TOKEN, IDENTIFIER,
    REQUEST_METHOD_DEFAULT,
    PROCEDURES,
    MESSAGES,
    ENDPOINTS,
    RESPONSE
};
