import { Base } from './common/Base';

/**
 * @inheritdoc
 * @constructor
 * @augments RequestBuilder
 */
export class Event extends Base
{
    userId;
    key;
    name;
    description;
    image;
    location;
    status;
    startDate;
    startTime;
    expirationDate;
    expirationTime;
}
