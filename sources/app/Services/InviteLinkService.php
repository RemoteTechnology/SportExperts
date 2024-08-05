<?php

namespace App\Services;

use App\Domain\Interfaces\Services\InviteLinkServiceInterface;
use App\Repository\EventRepository;
use App\Repository\UserRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class InviteLinkService implements InviteLinkServiceInterface
{
    private UserRepository $userRepository;
    private EventRepository $eventRepository;

    public function __construct(UserRepository $userRepository, EventRepository $eventRepository)
    {
        $this->userRepository = $userRepository;
        $this->eventRepository = $eventRepository;
    }

    public function getUser(int $userId): Model
    {
        return $this->userRepository->findById($userId);
    }

    public function getEvent(string $eventKey): Model
    {
        return $this->eventRepository->findByKey($eventKey);
    }

    public function generated(int $ownerId, string $eventKey): string
    {
        $user = $this->getUser($ownerId);
        $event = $this->getEvent($eventKey);
        $uuid = Uuid::uuid5(Str::uuid(), $user->id . ':' . $event->key);
        return "u:{$user->id}_e:{$event->key}_{$uuid}";
    }
}
