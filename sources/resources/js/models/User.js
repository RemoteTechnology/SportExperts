import { Base } from './common/Base';

/**
 * @inheritdoc
 * @constructor
 * @augments RequestBuilder
 */
export class User extends Base
{
    constructor()
    {
        super();
        this.first_name = undefined;
        this.first_name_eng = undefined;
        this.last_name = undefined;
        this.last_name_eng = undefined;
        this.birth_date = undefined;
        this.gender = undefined;
        this.email = undefined;
        this.phone = undefined;
        this.location = undefined;
        this.role = undefined;
        this.password = undefined;
    }
}
