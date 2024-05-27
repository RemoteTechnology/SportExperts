import axios from "axios";
import {
    BASE_URL,
    JSON_RPC_VERSION,
    REQUEST_METHOD_DEFAULT,
    PROCEDURES
} from '../constant';


function registrationRequest(data)
{
    var response = null;
    axios.post(`${BASE_URL}api/v1/user/`, {
        headers: {
            'Content-Type': 'application/json',
            'Accept':       'application/json',
        },
        'jsonrpc':          JSON_RPC_VERSION,
        'id':               '1',
        'notification':     false,
        'method':           `${PROCEDURES.users.registration}@${REQUEST_METHOD_DEFAULT}`,
        'params': {
            first_name:     data.firstName,
            first_name_eng: data.firstNameEng,
            last_name:      data.lastName,
            last_name_eng:  data.lastNameEng,
            birth_date:     data.birthDate,
            gender:         data.gender,
            email:          data.email,
            phone:          data.phone,
            password:       data.password
        }
    })
        .then((httpResponse) => { response = httpResponse })
        .catch((error) => { /*TODO: тут надо что то придумать.*/ console.log(error) })
    return response;
}

async function getUser(data)
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
        'params': {
            id: data.id
        }
    });
}

export { registrationRequest, getUser }
