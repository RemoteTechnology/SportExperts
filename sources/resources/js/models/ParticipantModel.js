import { BaseModel } from './common/BaseModel';

/**
 * @inheritdoc
 * @extends BaseModel
 * @see BaseModel
 */
export class ParticipantModel extends BaseModel
{
    constructor() {
        super();
        this.key =  undefined;
        this.events =  undefined;
        this.users =  undefined;
        this.teams =  undefined;
        this.invites =  undefined;
    }
}
