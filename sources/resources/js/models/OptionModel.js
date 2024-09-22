import { BaseModel } from './common/BaseModel';

/**
 * @inheritdoc
 * @extends BaseModel
 * @see BaseModel
 */
export class OptionModel extends BaseModel
{
    constructor() {
        super();
        this.event_key =  undefined;
        this.participant_key =  undefined;
        this.entity =  undefined;
        this.name =  undefined;
        this.value =  undefined;
        this.type =  undefined;
    }
}
