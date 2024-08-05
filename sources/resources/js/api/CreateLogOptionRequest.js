import {
    BASE_URL,
    JSON_RPC_VERSION,
    REQUEST_METHOD_DEFAULT,
    PROCEDURES,
    TOKEN
} from '../constant';
import {LogEndpointQuery} from "./query/LogEndpointQuery";
// createLogOptionRequest
export async function createLogOptionRequest(attributes, logQuery = new LogEndpointQuery())
{
    logQuery.setUrl(`${BASE_URL}api/v1/log/store`);
    logQuery.setHeaders();
    logQuery.setMethod(`${PROCEDURES.log.create}@${REQUEST_METHOD_DEFAULT}`);
    logQuery.setParams(attributes);
    return await logQuery.execute();
}

export async function listLogOptionRequest(logQuery = new LogEndpointQuery())
{
    logQuery.setUrl(`${BASE_URL}api/v1/log/`);
    logQuery.setHeaders();
    logQuery.setMethod(`${PROCEDURES.log.list}@${REQUEST_METHOD_DEFAULT}`);
    return await logQuery.execute();
}
