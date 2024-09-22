import { BaseModel } from './common/BaseModel';

/**
 * @inheritdoc
 * @extends BaseModel
 * @see BaseModel
 */
export class UserModel extends BaseModel
{
    constructor() {
        super();
        this.first_name =  undefined;
        this.first_name_eng =  undefined;
        this.last_name =  undefined;
        this.last_name_eng =  undefined;
        this.birth_date =  undefined;
        this.age =  undefined;
        this.gender =  undefined;
        this.email =  undefined;
        this.phone =  undefined;
        this.location =  undefined;
        this.role =  undefined;
        this.options =  undefined;
    }
}
