import axios from "axios";
import {
    BASE_URL,
    JSON_RPC_VERSION,
    REQUEST_METHOD_DEFAULT,
    PROCEDURES
} from '../constant';

async function getRecordToEventsRequest(attributes, mode='after', limit=9) {
    return await axios.post(`${BASE_URL}api/v1/participant/filter/`, {
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

export { getRecordToEventsRequest }
