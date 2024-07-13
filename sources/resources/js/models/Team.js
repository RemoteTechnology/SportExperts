import { Base } from './common/Base';

/**
 * @inheritdoc
 * @constructor
 * @augments RequestBuilder
 */
export class Team extends Base
{
    userId;
    key;
    name;
    description;
    image;
    location;
}
