import {
    BASE_URL,
    REQUEST_METHOD_DEFAULT,
    PROCEDURES
} from '../constant';
import { ParticipantEndpointQuery } from './query/ParticipantEndpointQuery';

export async function recordUserToEventRequest(attributes, participantQuery = new ParticipantEndpointQuery()) {
    // Для записи из списка спортсменов
    participantQuery.setUrl(`${BASE_URL}api/v1/participant/store/`);
    participantQuery.setHeaders();
    participantQuery.setMethod(`${PROCEDURES.participant.create}@${REQUEST_METHOD_DEFAULT}`);
    participantQuery.setParams(attributes);
    return await participantQuery.execute();
}

export async function eventRecordRequest(attributes,  participantQuery = new ParticipantEndpointQuery()) {
    participantQuery.setUrl(`${BASE_URL}api/v1/participant/store/`);
    participantQuery.setHeaders();
    participantQuery.setMethod(`${PROCEDURES.participant.create}@${REQUEST_METHOD_DEFAULT}`);
    participantQuery.setParams(attributes);
    return await participantQuery.execute();
}

export async function participantUserRemove(attributes,  participantQuery = new ParticipantEndpointQuery()) {
    participantQuery.setUrl(`${BASE_URL}api/v1/participant/store/`);
    participantQuery.setHeaders();
    participantQuery.setMethod(`${PROCEDURES.participant.create}@${REQUEST_METHOD_DEFAULT}`);
    participantQuery.setParams(attributes);
    return await participantQuery.execute();
}
