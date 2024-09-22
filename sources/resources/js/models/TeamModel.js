import { BaseModel } from './common/BaseModel';

/**
 * @inheritdoc
 * @constructor
 * @augments RequestBuilder
 */
export class TeamModel extends BaseModel
{
    constructor(props) {
        super(props);
        this.key =  undefined;
        this.name =  undefined;
        this.description =  undefined;
        this.location =  undefined;
        this.image =  undefined;
        this.users =  undefined;
    }

}
