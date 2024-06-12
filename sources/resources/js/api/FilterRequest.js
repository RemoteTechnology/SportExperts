import axios from "axios";
import {
    BASE_URL,
    JSON_RPC_VERSION,
    REQUEST_METHOD_DEFAULT,
    PROCEDURES
} from '../constant';

async function getRecordToEventsRequest(attributes, mode='after', limit=9) {
    return await axios.post(`${BASE_URL}api/v1/event/filter/participant/to/events`, {
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
        'jsonrpc': JSON_RPC_VERSION,
        'id': '1',
        'notification': false,
        'method': `${PROCEDURES.filter.userRecord}@${REQUEST_METHOD_DEFAULT}`,
        'params': {
            filter: attributes,
            mode: mode,
            limit: limit
        }
    })
}

async function getEventOwnerRequest(attributes) {
    return await axios.post(`${BASE_URL}api/v1/event/filter/my/events`, {
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
        'jsonrpc': JSON_RPC_VERSION,
        'id': '1',
        'notification': false,
        'method': `${PROCEDURES.filter.ownerEventsList}@${REQUEST_METHOD_DEFAULT}`,
        'params': attributes
    })
}

async function getEventParticipantRequest(attributes, limit=9) {
    return await axios.post(`${BASE_URL}api/v1/participant/filter/events/my/participants`, {
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
        'jsonrpc': JSON_RPC_VERSION,
        'id': '1',
        'notification': false,
        'method': `${PROCEDURES.filter.ownerParticipantList}@${REQUEST_METHOD_DEFAULT}`,
        'params': {
            filter: attributes,
            limit: limit
        }
    })
}

export {
    getRecordToEventsRequest,
    getEventOwnerRequest,
    getEventParticipantRequest
}
