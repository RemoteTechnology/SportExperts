import axios from 'axios';
import {
    BASE_URL,
    JSON_RPC_VERSION,
    REQUEST_METHOD_DEFAULT,
    PROCEDURES
} from '../constant';


async function authorizationRequest(data) {
    return await axios.post(`${BASE_URL}api/v1/user/auth/`, {
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
        'jsonrpc': JSON_RPC_VERSION,
        'id': '1',
        'notification': false,
        'method': `${PROCEDURES.auth.login}@${REQUEST_METHOD_DEFAULT}`,
        'params': {
            email: data.email,
            password: data.password
        }
    })
}

export { authorizationRequest }
