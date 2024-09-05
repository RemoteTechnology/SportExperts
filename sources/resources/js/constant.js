export const BASE_URL = 'http://localhost:8080/';
export const JSON_RPC_VERSION = '2.0';
export const TOKEN = 'user_personal_access_token';
export const IDENTIFIER = 'user_identifier';
// Процедуры
export const PROCEDURES = {
    users: {
        registration:           'UserRegistrationProcedure',
        read:                   'UserReadProcedure',
        update:                 'UserUpdateProcedure',
        reset:                  'ResetProcedure',
    },
    invites: {
        list:                   'InvitedListProcedure',
        create:                 'InvitedStoreProcedure',
        read:                   'InvitedReadProcedure',
        readUserParticipant:        'InvitedReadUserParticipantProcedure',
        notification:           'NotificationProcedure',
    },
    auth: {
        login:                  'AuthByEmailProcedure',
    },
    filter: {
        userRecord:             'EventDateFilterProcedure',
        ownerParticipantList:   'ParticipantOwnerFilterProcedure',
        ownerEventsList:        'EventOwnerFilterProcedure',
        participantUsers:       'ParticipantUsersToEventFilterProcedure',
    },
    event: {
        list:                   'EventListProcedure',
        create:                 'EventStoreProcedure',
        read:                   'EventReadProcedure',
        update:                 'EventUpdateProcedure',
        getKey:                 'EventGetKeyProcedure',
    },
    archive: {
        create:                 'ArchiveStoreProcedure',
        delete:                 'ArchiveDestroyProcedure',
    },
    option: {
        create:                 'OptionStoreProcedure',
        read:                   'OptionReadProcedure',
        update:                 'OptionUpdateProcedure',
    },
    participant: {
        create:                 'ParticipantStoreProcedure',
        additionally: {
            drop:               'ParticipantDiscvaleficationProcedure',
            replace:            'ParticipantКReplacementProcedure',
            skip:               'ParticipantSkippedProcedure',
        }
    },
    log: {
        create:                 'LogStoreProcedure',
        list:                   'LogListProcedure',
    },
    tournament: {
        read:                   'TournamentReadProcedure',
        value: {
            create:             'TournamentValueStoreProcedure'
        }
    }
};
export const REQUEST_METHOD_DEFAULT = 'handle';

export const MESSAGES = {
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
export const ENDPOINTS = {
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
    TOURNAMENT: 'tournament'
};

export const RESPONSE = {
    data: 'data'
};
