import { axios } from 'axios';
import {
    baseUrl,
    jsonRpcVersion,
    requestMethodDefault,
    procedures
} from '../constant';


function registrationRequest(data)
{
    var response = null;
    axios.post(`${baseUrl}api/v1/user/`, {
        headers: {
            'Content-Type': 'application/json',
            'Accept':       'application/json',
        },
        'jsonrpc':          jsonRpcVersion,
        'id':               '1',
        'notification':     false,
        'method':           `${procedures.users.registration}@${requestMethodDefault}`,
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
