import axios from 'axios';
import {
    baseUrl,
    jsonRpcVersion,
    requestMethodDefault,
    procedures
} from '../constant';


async function authorizationRequest(data) {
    return await axios.post(`${baseUrl}api/v1/user/auth/`, {
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
        'jsonrpc': jsonRpcVersion,
        'id': '1',
        'notification': false,
        'method': `${procedures.auth.login}@${requestMethodDefault}`,
        'params': {
            email: data.email,
            password: data.password
        }
    })
}

export { authorizationRequest }
