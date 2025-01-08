const protocol = import.meta.env.VITE_HTTP_PROTOCOL || 'http';
const host = import.meta.env.VITE_HTTP_HOST || 'localhost';
const port = import.meta.env.VITE_HTTP_PORT || (protocol === 'https' ? 443 : 80);

const url = protocol === 'https'
    ? `${protocol}://${host}/`
    : `${protocol}://${host}:${port}/`;

export const WEB_URL = url;