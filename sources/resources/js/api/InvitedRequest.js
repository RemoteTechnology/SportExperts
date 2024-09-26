import {
    BASE_URL,
    JSON_RPC_VERSION,
    REQUEST_METHOD_DEFAULT,
    PROCEDURES, TOKEN
} from '../constant';
import { InviteEndpointQuery } from './query/InviteEndpointQuery';

export async function addNotificationUserInviteEventRequest(attributes, inviteQuery = new InviteEndpointQuery())
{
    inviteQuery.setUrl(`${BASE_URL}api/v1/invite/notification/`);
    inviteQuery.setHeaders();
    inviteQuery.isAuth(`Bearer ${window.$cookies.get(TOKEN)}`);
    inviteQuery.setMethod(`${PROCEDURES.invites.notification}@${REQUEST_METHOD_DEFAULT}`);
    inviteQuery.setParams(attributes);
    return await inviteQuery.execute();
}

export async function createInvitedRequest(attributes, inviteQuery = new InviteEndpointQuery())
{
    inviteQuery.setUrl(`${BASE_URL}api/v1/invite/store`);
    inviteQuery.setHeaders();
    inviteQuery.setMethod(`${PROCEDURES.invites.create}@${REQUEST_METHOD_DEFAULT}`);
    inviteQuery.setParams(attributes);
    return await inviteQuery.execute();
}

export async function listInvitedRequest(attributes, inviteQuery = new InviteEndpointQuery())
{
    inviteQuery.setUrl(`${BASE_URL}api/v1/invite/`);
    inviteQuery.setHeaders();
    inviteQuery.setMethod(`${PROCEDURES.invites.list}@${REQUEST_METHOD_DEFAULT}`);
    inviteQuery.setParams(attributes);
    return await inviteQuery.execute();
}

export async function readUserParticipantInvitedRequest(attributes, inviteQuery = new InviteEndpointQuery())
{
    inviteQuery.setUrl(`${BASE_URL}api/v1/invite/read/participant`);
    inviteQuery.setHeaders();
    inviteQuery.setMethod(`${PROCEDURES.invites.readUserParticipant}@${REQUEST_METHOD_DEFAULT}`);
    inviteQuery.setParams(attributes);
    return await inviteQuery.execute();
}
