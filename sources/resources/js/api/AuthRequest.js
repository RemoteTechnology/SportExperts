import {
    BASE_URL,
    JSON_RPC_VERSION,
    REQUEST_METHOD_DEFAULT,
    PROCEDURES
} from '../constant';
import { AuthEndpointQuery } from './query/AuthEndpointQuery';

export async function authorizationRequest(attributes, authQuery = new AuthEndpointQuery())
{
    authQuery.setUrl(`${BASE_URL}api/v1/user/auth/`);
    authQuery.setHeaders();
    authQuery.setMethod(`${PROCEDURES.auth.login}@${REQUEST_METHOD_DEFAULT}`)
    authQuery.setParams(attributes)
    return await authQuery.execute();
}
