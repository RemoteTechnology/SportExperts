import {
    BASE_URL,
    JSON_RPC_VERSION,
    REQUEST_METHOD_DEFAULT,
    PROCEDURES
} from '../constant';
import { ArchiveEndpointQuery } from './query/ArchiveEndpointQuery';

export async function createArchiveRequest(attributes, archiveQuery  = new ArchiveEndpointQuery())
{
    archiveQuery.setUrl(`${BASE_URL}api/v1/event/archive/store`);
    archiveQuery.setHeaders();
    archiveQuery.setMethod(`${PROCEDURES.archive.create}@${REQUEST_METHOD_DEFAULT}`);
    archiveQuery.setParams(attributes);
    return await archiveQuery.execute();
}

export async function removeArchiveRequest(attributes, archiveQuery  = new ArchiveEndpointQuery())
{
    archiveQuery.setUrl(`${BASE_URL}api/v1/event/archive/destroy`);
    archiveQuery.setHeaders();
    archiveQuery.setMethod(`${PROCEDURES.archive.delete}@${REQUEST_METHOD_DEFAULT}`);
    archiveQuery.setParams(attributes);
    return await archiveQuery.execute();
}
