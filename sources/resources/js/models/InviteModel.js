import { BaseModel } from './common/BaseModel';

/**
 * @inheritdoc
 * @extends BaseModel
 * @see BaseModel
 */
export class InviteModel extends BaseModel
{
   constructor() {
       super();
       this.who_user_id =  undefined;
       this.who_user =  undefined;
       this.users =  undefined;
       this.participants =  undefined;
       this.events =  undefined;
       this.options =  undefined;
   }
}
