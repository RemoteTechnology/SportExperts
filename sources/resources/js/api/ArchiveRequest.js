import axios from "axios";
import {
    BASE_URL,
    JSON_RPC_VERSION,
    REQUEST_METHOD_DEFAULT,
    PROCEDURES
} from '../constant';


async function createArchiveRequest(attributes)
{
    return await axios.post(`${BASE_URL}api/v1/event/archive/store`, {
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
        'jsonrpc': JSON_RPC_VERSION,
        'id': '1',
        'notification': false,
        'method': `${PROCEDURES.archive.create}@${REQUEST_METHOD_DEFAULT}`,
        'params': attributes
    })
}

async function removeArchiveRequest(attributes)
{
    return await axios.post(`${BASE_URL}api/v1/event/archive/destroy`, {
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
        'jsonrpc': JSON_RPC_VERSION,
        'id': '1',
        'notification': false,
        'method': `${PROCEDURES.archive.delete}@${REQUEST_METHOD_DEFAULT}`,
        'params': attributes
    })
}

export { createArchiveRequest, removeArchiveRequest }
