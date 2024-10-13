import {TournamentHistoryEndpointQuery} from "./query/TournamentHistoryEndpointQuery";
import {BASE_URL, PROCEDURES, REQUEST_METHOD_DEFAULT, TOKEN} from "../constant";

export async function getTournamentHistoryRequest(attributes, tournamentHistoryQuery = new TournamentHistoryEndpointQuery()) {
    tournamentHistoryQuery.setUrl(`${BASE_URL}api/v1/tournament/history`);
    tournamentHistoryQuery.setHeaders();
    tournamentHistoryQuery.isAuth(`Bearer ${window.$cookies.get(TOKEN)}`);
    tournamentHistoryQuery.setMethod(`${PROCEDURES.tournament.history.read}@${REQUEST_METHOD_DEFAULT}`);
    tournamentHistoryQuery.setParams(attributes);
    return await tournamentHistoryQuery.execute();
}
