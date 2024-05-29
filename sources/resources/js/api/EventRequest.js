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

export { getEventListRequest }
