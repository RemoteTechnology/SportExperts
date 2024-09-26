import axios from "axios";
import {
    BASE_URL,
    JSON_RPC_VERSION,
    REQUEST_METHOD_DEFAULT,
    PROCEDURES, TOKEN
} from '../constant';
import { FileEndpointQuery } from './query/FileEndpointQuery';

export async function uploadFileRequest(formData, fileQuery = new FileEndpointQuery())
{
    try {
        return await axios.post(`${BASE_URL}api/v1/file/`, formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
                'Accept': 'application/json',
                'Authorization': `Bearer ${window.$cookies.get(TOKEN)}`
            }
        })
        // fileQuery.setUrl(`${BASE_URL}api/v1/file/`);
        // fileQuery.setHeaders();
        // return await fileQuery.execute(formData);
    } catch (error) {
        throw error;
    }
}
