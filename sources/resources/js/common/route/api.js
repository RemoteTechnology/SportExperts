const protocol = import.meta.env.VITE_HTTP_PROTOCOL || 'http';
const host = import.meta.env.VITE_HTTP_HOST || 'localhost';
const port = import.meta.env.VITE_HTTP_PORT || (protocol === 'https' ? 443 : 80);

const url = protocol === 'https'
    ? `${protocol}://${host}/`
    : `${protocol}://${host}:${port}/`;


export const API_URL = url;
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
