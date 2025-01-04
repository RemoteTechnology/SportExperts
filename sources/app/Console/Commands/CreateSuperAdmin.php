<?php

namespace App\Console\Commands;

use App\Domain\Constants\EnumConstants\RoleEnum;
use App\Repository\UserRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

require_once dirname(__DIR__, 3) . '/app/Domain/Constants/FieldConst.php';

class CreateSuperAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-superadmin  {first_name} {last_name} {birth_date} {gender} {email} {phone} {location}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Комманда создаёт стартового супер админа.';

    /**
     * Execute the console command.
     */
    public function handle(UserRepository $userRepository)
    {
        $password = Str::random(10);
        $userRepository->store([
            FIELD_FIRST_NAME => $this->argument(FIELD_FIRST_NAME),
            FIELD_FIRST_NAME_ENG => '-',
            FIELD_LAST_NAME => $this->argument(FIELD_LAST_NAME),
            FIELD_LAST_NAME_ENG => '-',
            FIELD_BIRTH_DATE => $this->argument(FIELD_BIRTH_DATE),
            FIELD_GENDER => $this->argument(FIELD_GENDER),
            FIELD_EMAIL => $this->argument(FIELD_EMAIL),
            FIELD_PHONE => $this->argument(FIELD_PHONE),
            FIELD_LOCATION => $this->argument(FIELD_LOCATION),
            FIELD_ROLE => RoleEnum::SUPERUSER->value,
            FIELD_PASSWORD => Hash::make($password),
        ]);

        $this->info('Супер-админ успешно создан!');
        $this->info('Данные для входа:');
        $this->info('Логин: ' . $this->argument(FIELD_EMAIL) . '/' . $this->argument(FIELD_PHONE));
        $this->info('Пароль: ' . $password);
    }
}
