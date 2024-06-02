import axios from "axios";
import {
    BASE_URL,
    JSON_RPC_VERSION,
    REQUEST_METHOD_DEFAULT,
    PROCEDURES,
    TOKEN
} from '../constant';


async function registrationRequest(data)
{
    return await axios.post(`${BASE_URL}api/v1/user/registration`, {
        headers: {
            'Content-Type': 'application/json',
            'Accept':       'application/json',
        },
        'jsonrpc':          JSON_RPC_VERSION,
        'id':               '1',
        'notification':     false,
        'method':           `${PROCEDURES.users.registration}@${REQUEST_METHOD_DEFAULT}`,
        'params': attributes
    })
}

async function getUser(attributes)
{
    return await axios.post(`${BASE_URL}api/v1/user/read`, {
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
        'jsonrpc': JSON_RPC_VERSION,
        'id': '1',
        'notification': false,
        'method': `${PROCEDURES.users.read}@${REQUEST_METHOD_DEFAULT}`,
        'params': attributes
    });
}

async function updateUserRequest(attributes)
{
    return await axios.post(`${BASE_URL}api/v1/user/update`, {
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization': `Bearer Bearer ${window.$cookies.get(TOKEN)}`
        },
        validateStatus: () => true,
        'jsonrpc': JSON_RPC_VERSION,
        'id': '1',
        'notification': false,
        'method': `${PROCEDURES.users.update}@${REQUEST_METHOD_DEFAULT}`,
        'params': attributes
    });
}

async function getInvitedOwnerRequest(attributes)
{
    return await axios.post(`${BASE_URL}api/v1/invite/`, {
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            // 'Authorization': `Bearer Bearer ${window.$cookies.get(TOKEN)}`
        },
        validateStatus: () => true,
        'jsonrpc': JSON_RPC_VERSION,
        'id': '1',
        'notification': false,
        'method': `${PROCEDURES.invites.list}@${REQUEST_METHOD_DEFAULT}`,
        'params': attributes
    });
}

export { registrationRequest, getUser, updateUserRequest, getInvitedOwnerRequest }
