<?php

namespace App\Services;

use App\Domain\Interfaces\Services\VK_APIServiceInterface;
use GuzzleHttp\Client;

class VK_APIService implements VK_APIServiceInterface
{
    protected static string $url = 'https://api.vk.com/method/';
    protected static string $versionApi = '5.199';
    protected static string $fields = 'contacts,bdate,military,city,sex';
    protected static array $headers = [
        'Content-Type' => 'application/json',
    ];

    public function getUser(array $attributes): array
    {
        $client = new Client();
        $response = $client->request('GET', self::$url . 'users.get', [
            'query' => [
                'user_id' => $attributes['user_id'],
                'fields' => self::$fields,
                'access_token' => $attributes['access_token'],
                'v' => self::$versionApi
            ],
            'headers' => self::$headers
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }
}
