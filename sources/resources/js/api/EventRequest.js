import axios from "axios";
import {
    BASE_URL,
    JSON_RPC_VERSION,
    REQUEST_METHOD_DEFAULT,
    PROCEDURES
} from '../constant';

async function getEventListRequest() {
    return await axios.post(`${BASE_URL}api/v1/event/`, {
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
        'jsonrpc': JSON_RPC_VERSION,
        'id': '1',
        'notification': false,
        'method': `${PROCEDURES.event.list}@${REQUEST_METHOD_DEFAULT}`,
    })
}

async function getEventRequest(attributes) {
    return await axios.post(`${BASE_URL}api/v1/event/read`, {
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
        'jsonrpc': JSON_RPC_VERSION,
        'id': '1',
        'notification': false,
        'method': `${PROCEDURES.event.read}@${REQUEST_METHOD_DEFAULT}`,
        'params': attributes
    })
}

async function createEventRequest(attributes) {
    return await axios.post(`${BASE_URL}api/v1/event/store`, {
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
        'jsonrpc': JSON_RPC_VERSION,
        'id': '1',
        'notification': false,
        'method': `${PROCEDURES.event.create}@${REQUEST_METHOD_DEFAULT}`,
        'params': attributes
    })
}

async function updateEventRequest(attributes) {
    return await axios.post(`${BASE_URL}api/v1/event/update`, {
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
        'jsonrpc': JSON_RPC_VERSION,
        'id': '1',
        'notification': false,
        'method': `${PROCEDURES.event.update}@${REQUEST_METHOD_DEFAULT}`,
        'params': attributes
    })
}
// TODO: Вынести в отдельные реквесты
async function createEventOptionRequest(attributes) {
    return await axios.post(`${BASE_URL}api/v1/option/store`, {
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
        'jsonrpc': JSON_RPC_VERSION,
        'id': '1',
        'notification': false,
        'method': `${PROCEDURES.option.create}@${REQUEST_METHOD_DEFAULT}`,
        'params': attributes
    })
}

async function updateEventOptionRequest(attributes) {
    return await axios.post(`${BASE_URL}api/v1/option/update`, {
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
        'jsonrpc': JSON_RPC_VERSION,
        'id': '1',
        'notification': false,
        'method': `${PROCEDURES.option.update}@${REQUEST_METHOD_DEFAULT}`,
        'params': attributes
    })
}
async function getKeyEventRequest(attributes){
    // TODO: сделать выборку записи по ключу
}

export {
    getEventListRequest,
    createEventRequest,
    getEventRequest,
    updateEventRequest,
    createEventOptionRequest,
    updateEventOptionRequest,
    getKeyEventRequest,
}
