import {
    BASE_URL,
    REQUEST_METHOD_DEFAULT,
    PROCEDURES
} from '../constant';
import { TournamentValueEndpointQuery } from './query/TournamentValueEndpointQuery';

export async function tournamentValueCreateRequest(attributes, tournamentValueQuery = new TournamentValueEndpointQuery()) {
    // Для записи из списка спортсменов
    tournamentValueQuery.setUrl(`${BASE_URL}api/v1/tournament/value/store`);
    tournamentValueQuery.setHeaders();
    tournamentValueQuery.setMethod(`${PROCEDURES.tournament.value.create}@${REQUEST_METHOD_DEFAULT}`);
    tournamentValueQuery.setParams(attributes);
    return await tournamentValueQuery.execute();
}

export async function getFreeParticipantsRequest(attributes, tournamentValueQuery = new TournamentValueEndpointQuery()) {
    tournamentValueQuery.setUrl(`${BASE_URL}api/v1/tournament/value/filter`);
    tournamentValueQuery.setHeaders();
    tournamentValueQuery.setMethod(`${PROCEDURES.tournament.value.filter.free}@${REQUEST_METHOD_DEFAULT}`);
    tournamentValueQuery.setParams(attributes);
    return await tournamentValueQuery.execute();
}
