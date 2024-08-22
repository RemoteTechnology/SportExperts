import {
    BASE_URL,
    REQUEST_METHOD_DEFAULT,
    PROCEDURES
} from '../constant';
import { TournamentEndpointQuery } from './query/TournamentEndpointQuery';

export async function tournamentReadRequest(attributes, tournamentQuery = new TournamentEndpointQuery()) {
    // Для записи из списка спортсменов
    tournamentQuery.setUrl(`${BASE_URL}api/v1/tournament/read`);
    tournamentQuery.setHeaders();
    tournamentQuery.setMethod(`${PROCEDURES.tournament.read}@${REQUEST_METHOD_DEFAULT}`);
    tournamentQuery.setParams(attributes);
    return await tournamentQuery.execute();
}
