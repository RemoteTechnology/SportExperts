/**
 * @inheritdoc
 * @constructor
 * @augments RequestBuilder
 */
export class BaseModel
{
    constructor()
    {
        this.id = undefined;
        this.created_at = undefined;
        this.updated_at = undefined;
        this.deleted_at = undefined;
    }
}
