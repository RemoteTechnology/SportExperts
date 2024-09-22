import { BaseModel } from './common/BaseModel';

/**
 * @inheritdoc
 * @extends BaseModel
 * @see BaseModel
 */
export class EventModel extends BaseModel
{
    constructor(attributes){
        super();
        this.key = undefined;
        this.name = undefined;
        this.description = undefined;
        this.startDate = undefined;
        this.startTime = undefined;
        this.expirationDate = undefined;
        this.expirationTime = undefined;
        this.location = undefined;
        this.status = undefined;
        this.owner = undefined;
        this.admins = undefined;
        this.image = undefined;
        this.options = undefined;
        this.participants = undefined;
    }
}
