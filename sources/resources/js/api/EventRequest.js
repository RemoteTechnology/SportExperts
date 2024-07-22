import {
    BASE_URL,
    JSON_RPC_VERSION,
    REQUEST_METHOD_DEFAULT,
    PROCEDURES
} from '../constant';
import { EventEndpointQuery } from './query/EventEndpointQuery';

export async function getEventListRequest(eventQuery = new EventEndpointQuery())
{
    eventQuery.setUrl(`${BASE_URL}api/v1/event/`);
    eventQuery.setHeaders();
    eventQuery.setMethod(`${PROCEDURES.event.list}@${REQUEST_METHOD_DEFAULT}`);
    return await eventQuery.execute();
}

export async function getEventRequest(attributes, eventQuery = new EventEndpointQuery())
{
    eventQuery.setUrl(`${BASE_URL}api/v1/event/read`);
    eventQuery.setHeaders();
    eventQuery.setMethod(`${PROCEDURES.event.read}@${REQUEST_METHOD_DEFAULT}`);
    eventQuery.setParams(attributes);
    return await eventQuery.execute();
}

export async function createEventRequest(attributes, eventQuery = new EventEndpointQuery())
{
    eventQuery.setUrl(`${BASE_URL}api/v1/event/store`);
    eventQuery.setHeaders();
    eventQuery.setMethod(`${PROCEDURES.event.create}@${REQUEST_METHOD_DEFAULT}`);
    eventQuery.setParams(attributes);
    return await eventQuery.execute();
}

export async function updateEventRequest(attributes, eventQuery = new EventEndpointQuery())
{
    eventQuery.setUrl(`${BASE_URL}api/v1/event/update`);
    eventQuery.setHeaders();
    eventQuery.setMethod(`${PROCEDURES.event.update}@${REQUEST_METHOD_DEFAULT}`);
    eventQuery.setParams(attributes);
    return await eventQuery.execute();
}

export async function createEventOptionRequest(attributes, eventQuery = new EventEndpointQuery())
{
    eventQuery.setUrl(`${BASE_URL}api/v1/option/store`);
    eventQuery.setHeaders();
    eventQuery.setMethod(`${PROCEDURES.option.create}@${REQUEST_METHOD_DEFAULT}`);
    eventQuery.setParams(attributes);
    return await eventQuery.execute();
}

export async function updateEventOptionRequest(attributes, eventQuery = new EventEndpointQuery())
{
    eventQuery.setUrl(`${BASE_URL}api/v1/option/update`);
    eventQuery.setHeaders();
    eventQuery.setMethod(`${PROCEDURES.option.update}@${REQUEST_METHOD_DEFAULT}`);
    eventQuery.setParams(attributes);
    return await eventQuery.execute();
}
export async function getKeyEventRequest(attributes, eventQuery = new EventEndpointQuery())
{
    // TODO: сделать выборку записи по ключу
}
