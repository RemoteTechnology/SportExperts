import { type BaseType } from "../baseType";

export interface User extends BaseType {
    google_id?: string;
    vk_id?: string;
    first_name?: string;
    first_name_eng?: string;
    last_name?: string;
    last_name_eng?: string;
    birth_date?: string;
    gender?: string;
    email?: string;
    phone?: string;
    location?: string;
    role: string;
    password?: string;
}
