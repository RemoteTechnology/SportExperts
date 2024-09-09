import {
    BASE_URL,
    JSON_RPC_VERSION,
    REQUEST_METHOD_DEFAULT,
    PROCEDURES
} from '../constant';
import { OptionEndpointQuery } from './query/OptionEndpointQuery';

export async function createOptionRequest(attributes, optionQuery = new OptionEndpointQuery())
{
    optionQuery.setUrl(`${BASE_URL}api/v1/option/store`);
    optionQuery.setHeaders();
    optionQuery.setMethod(`${PROCEDURES.option.create}@${REQUEST_METHOD_DEFAULT}`);
    optionQuery.setParams(attributes);
    return await optionQuery.execute();
}

export async function updateOptionRequest(attributes, optionQuery = new OptionEndpointQuery())
{
    optionQuery.setUrl(`${BASE_URL}api/v1/option/update`);
    optionQuery.setHeaders();
    optionQuery.setMethod(`${PROCEDURES.option.update}@${REQUEST_METHOD_DEFAULT}`);
    optionQuery.setParams(attributes);
    return await optionQuery.execute();
}

export async function getOptionRequest(attributes, optionQuery = new OptionEndpointQuery())
{
    optionQuery.setUrl(`${BASE_URL}api/v1/option/read`);
    optionQuery.setHeaders();
    optionQuery.setMethod(`${PROCEDURES.option.read}@${REQUEST_METHOD_DEFAULT}`);
    optionQuery.setParams(attributes);
    return await optionQuery.execute();
}

export async function deleteOptionRequest(attributes, optionQuery = new OptionEndpointQuery())
{
    optionQuery.setUrl(`${BASE_URL}api/v1/option/destroy`);
    optionQuery.setHeaders();
    optionQuery.setMethod(`${PROCEDURES.option.delete}@${REQUEST_METHOD_DEFAULT}`);
    optionQuery.setParams(attributes);
    return await optionQuery.execute();
}
