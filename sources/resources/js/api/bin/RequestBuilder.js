import axios from "axios";
import {
    BASE_URL,
    JSON_RPC_VERSION,
    REQUEST_METHOD_DEFAULT,
    PROCEDURES
} from '../../constant';

//TODO: зафигачить взде в запросах билдер
/**
 * Класс занимается сборкой реквестов, респонсы нужно смотреть в реализациях
 * @class
 */
class RequestBuilder {
    constructor() {
        this.url = null;
        this.headers = {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        };
        this.data = {
            'jsonrpc': JSON_RPC_VERSION,
            'id': '1',
            'notification': false,
            'method': '',
            'params': {}
        };
    }

    /**
     * Определение урла, к которому нужно обратиться
     * @param url
     * @returns {RequestBuilder}
     */
    setUrl(url) {
        this.url = url;
        return this;
    }

    /**
     * Определение метода, необходимо для JSON-RPC
     * @param method
     * @returns {RequestBuilder}
     */
    setMethod(method) {
        this.data.method = method;
        return this;
    }

    /**
     * Сборка тела параметров запроса
     * @param params
     * @returns {RequestBuilder}
     */
    setParams(params) {
        this.data.params = params;
        return this;
    }

    /**
     * Сборка заголовков
     * @param headers
     * @returns {RequestBuilder}
     */
    setHeaders(headers) {
        this.headers = { ...this.headers, ...headers };
        return this;
    }

    /**
     * Установка заголовка авторизации.
     * Необходим Bearer токен
     * @param accessToken
     */
    isAuth(accessToken) {
        this.headers['Authorization'] = `Bearer ${accessToken}`;
    }

    /**
     * Отправляет запрос к серверу.
     * @returns {Promise<axios.AxiosResponse<any>>}
     */
    async execute() {
        return await axios.post(this.url, this.data, {
            headers: this.headers,
        });
    }
}

export { RequestBuilder }
