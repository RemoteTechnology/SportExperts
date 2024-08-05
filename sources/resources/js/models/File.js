import { Base } from './common/Base';

/**
 * @inheritdoc
 * @constructor
 * @augments RequestBuilder
 */
export class File extends Base
{
    key;
    name;
    mime;
    size;
    extension;
}
