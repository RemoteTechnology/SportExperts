import axios from "axios";
import {
    BASE_URL,
    JSON_RPC_VERSION,
    REQUEST_METHOD_DEFAULT,
    PROCEDURES
} from '../constant';

async function uploadFileRequest(formData) {
    return await axios.post(`${BASE_URL}api/v1/file/`, formData, {
        headers: {
            'Content-Type': 'multipart/form-data',
            'Accept': 'application/json',
        }
    })
}

export { uploadFileRequest }
