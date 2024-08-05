<?php

namespace App\Domain\Interfaces\Services;

use Illuminate\Database\Eloquent\Model;

interface InviteLinkServiceInterface
{
    /**
     * @param int $userId
     * @return Model
     */
    public function getUser(int $userId): Model;

    /**
     * @param string $eventKey
     * @return Model
     */
    public function getEvent(string $eventKey): Model;

    /**
     * @param int $ownerId
     * @param string $eventKey
     * @return UuidInterface
     */
    public function generated(int $ownerId, string $eventKey): string;
}
