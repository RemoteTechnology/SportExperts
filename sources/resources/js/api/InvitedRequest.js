import axios from "axios";
import {
    BASE_URL,
    JSON_RPC_VERSION,
    REQUEST_METHOD_DEFAULT,
    PROCEDURES
} from '../constant';

async function addNotificationUserInviteEventRequest(attributes)
{
    return await axios.post(`${BASE_URL}api/v1/invite/notification/`, {
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
        'jsonrpc': JSON_RPC_VERSION,
        'id': '1',
        'notification': false,
        'method': `${PROCEDURES.invites.notification}@${REQUEST_METHOD_DEFAULT}`,
        'params': attributes
    })
}

async function createInvitedRequest(attributes)
{
    return await axios.post(`${BASE_URL}api/v1/invite/store`, {
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
        'jsonrpc': JSON_RPC_VERSION,
        'id': '1',
        'notification': false,
        'method': `${PROCEDURES.invites.notification}@${REQUEST_METHOD_DEFAULT}`,
        'params': attributes
    })
}

export { addNotificationUserInviteEventRequest, createInvitedRequest }
