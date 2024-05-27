<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Супер админ
        User::create([
            'first_name' => 'Константин',
            'first_name_eng' => 'KONSTANTIN',
            'last_name' => 'Кохно',
            'last_name_eng' => 'KOHNO',
            'birth_date' => '01.01.1999',
            'gender' => 'Мужчина',
            'email' => Str::random(10).'@example.com',
            'phone' => '+7 (000) 000-00-01',
            'location' => 'гор. Новосибирск. ',
            'role' => 'superuser',
            'password' => Hash::make('superadmin'),
        ]);
        // Тестовый админ
        User::create([
            'first_name' => 'Артём',
            'first_name_eng' => 'ARTEM',
            'last_name' => 'Маркиянов',
            'last_name_eng' => 'MARKIYANOV',
            'birth_date' => '01.01.1999',
            'gender' => 'Мужчина',
            'email' => Str::random(10).'@example.com',
            'phone' => '+7 (000) 000-00-02',
            'location' => 'гор. Питер. ст. м. Приморская.',
            'role' => 'admin',
            'password' => Hash::make('admin'),
        ]);
        // Участник мероприятия админ
        User::create([
            'first_name' => 'Вячеслав',
            'first_name_eng' => 'VUACHESLAV',
            'last_name' => 'Миронов',
            'last_name_eng' => 'MIRONOV',
            'birth_date' => '01.01.1999',
            'gender' => 'Мужчина',
            'email' => Str::random(10).'@example.com',
            'phone' => '+7 (000) 000-00-03',
            'location' => 'гор. Новосибирск. ст. м. Берёзовая роща.',
            'role' => 'athlete',
            'password' => Hash::make('athlete'),
        ]);
        // Генерация случайных юзеров
        $i = 0;
        while($i <= 10000)
        {
            User::create([
                'first_name' => fake('ru')->firstName(),
                'first_name_eng' => fake('en')->firstName(),
                'last_name' => fake('ru')->lastName(),
                'last_name_eng' => fake('en')->lastName(),
                'birth_date' => fake()->date(),
                'gender' => ['Мужчина', 'Женщина'][array_rand(['Мужчина', 'Женщина'])],
                'email' => Str::random(10).'@example.com',
                'phone' => '+7 (' . mt_rand(100, 999) . ') ' . mt_rand(100, 999) . '-' . mt_rand(10, 99) . '-' . mt_rand(10, 99),
                'location' => fake('ru')->city(),
                'role' => $i < 400 ? 'admin' : 'athlete',
                'password' => Hash::make('password')
            ]);
            $i++;
        }
    }
}
