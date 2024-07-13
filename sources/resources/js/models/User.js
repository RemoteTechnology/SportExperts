import { Base } from './common/Base';

/**
 * @inheritdoc
 * @constructor
 * @augments RequestBuilder
 */
export class User extends Base
{
    firstName;
    firstNameEng;
    lastName;
    lastNameEng;
    birthDate;
    gender;
    email;
    phone;
    location;
    role;
    password;
}
