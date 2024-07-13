import { Base } from './common/Base';

/**
 * @inheritdoc
 * @constructor
 * @augments RequestBuilder
 */
export class Participant extends Base
{
    eventId;
    userId;
    invitedUserId;
    teamKey;
    key;
}
