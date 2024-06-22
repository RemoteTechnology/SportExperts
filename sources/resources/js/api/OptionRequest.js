import axios from "axios";
import {
    BASE_URL,
    JSON_RPC_VERSION,
    REQUEST_METHOD_DEFAULT,
    PROCEDURES
} from '../constant';

async function createOptionRequest(attributes) {
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

async function updateOptionRequest(attributes) {
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

export { createOptionRequest, updateOptionRequest };
