import { BaseModel } from './common/BaseModel';

/**
 * @inheritdoc
 * @extends BaseModel
 * @see BaseModel
 */
export class FileModel extends BaseModel
{
    constructor() {
        super();
        this.key =  undefined;
        this.name =  undefined;
        this.mime =  undefined;
        this.size =  undefined;
        this.extension =  undefined;
    }
}
