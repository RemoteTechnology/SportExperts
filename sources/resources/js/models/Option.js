import { Base } from './common/Base';

/**
 * @inheritdoc
 * @constructor
 * @augments RequestBuilder
 */
export class Option extends Base
{
    eventKey;
    userId;
    entity;
    name;
    value;
    type;
}
