<?php

namespace App\Models\ModelConvert;

use App\Domain\Constants\EnumConstants\GenderEnum;

require_once dirname(__DIR__, 3) . '/app/Domain/Constants/FieldConst.php';

class VkUserConvert
{
    public int $vkId;
    public string|null $city;
    public string|null $mobilePhone;
    public string|null|GenderEnum $sex;
    public string $firstName;
    public string $lastName;

    public function __construct(array $data)
    {

        $this->vkId = $data['id'];
        $this->city = !empty($data['city']) ? $data['city'][FIELD_TITLE] : null;
        $this->mobilePhone = !empty($data['mobile_phone']) ? $data['mobile_phone'] : null;
        $this->sex = $data['sex']=== 1 ? GenderEnum::FEMALE : ($data['sex'] === 2 ? GenderEnum::MALE : null);
        $this->firstName = $data[FIELD_FIRST_NAME];
        $this->lastName = $data[FIELD_LAST_NAME];
    }

    public function __invoke(): array
    {
        return [
            FIELD_VK_ID => $this->vkId,
            FIELD_FIRST_NAME => $this->firstName,
            FIELD_FIRST_NAME_ENG => '-',
            FIELD_LAST_NAME => $this->lastName,
            FIELD_LAST_NAME_ENG => '-',
            FIELD_GENDER => $this->sex,
            FIELD_PHONE => $this->mobilePhone,
            FIELD_LOCATION => $this->city,
        ];
    }
}
