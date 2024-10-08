import {
    BASE_URL,
    REQUEST_METHOD_DEFAULT,
    PROCEDURES, TOKEN
} from '../constant';
import { TournamentAdminEndpointQuery } from './query/TournamentAdminEndpointQuery';

export async function getTournamentAdminRequest(attributes, tournamentAdminQuery = new TournamentAdminEndpointQuery()) {
    tournamentAdminQuery.setUrl(`${BASE_URL}api/v1/tournament/admin`);
    tournamentAdminQuery.setHeaders();
    //tournamentAdminQuery.isAuth(`Bearer ${window.$cookies.get(TOKEN)}`);
    tournamentAdminQuery.setMethod(`${PROCEDURES.tournament.admin.list}@${REQUEST_METHOD_DEFAULT}`);
    tournamentAdminQuery.setParams(attributes);
    return await tournamentAdminQuery.execute();
}
