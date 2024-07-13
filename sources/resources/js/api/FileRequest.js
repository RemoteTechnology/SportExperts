import {
    BASE_URL,
    JSON_RPC_VERSION,
    REQUEST_METHOD_DEFAULT,
    PROCEDURES
} from '../constant';
import { FileEndpointQuery } from './query/FileEndpointQuery';

async function uploadFileRequest(formData, fileQuery = new FileEndpointQuery())
{
    try {
        fileQuery.setUrl(`${BASE_URL}api/v1/file/`);
        fileQuery.setHeaders();
        return await fileQuery.execute(formData);
    } catch (error) {
        throw error;
    }
}

export { uploadFileRequest }
