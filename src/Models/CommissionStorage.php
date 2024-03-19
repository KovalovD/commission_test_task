<?php

declare(strict_types=1);

namespace App\CommissionTask\Models;

class CommissionStorage
{
    private static array $storage = [];

    /**
     * @throws \JsonException
     */
    public static function pushToStorage(Operation $operation): StorageRecord
    {
        $weekStorage = self::getFromStorage($operation->getDate(), $operation->getUserId());
        $weekStorage->pushOperation($operation);
        self::saveToStorage($operation->getDate(), $operation->getUserId(), $weekStorage);

        return $weekStorage;
    }

    private static function getFromStorage(\DateTime $date, int $userId): StorageRecord
    {
        return self::$storage[$date->format('oW')][$userId] ?? new StorageRecord();
    }

    private static function saveToStorage(\DateTime $date, int $userId, StorageRecord $storageRecord): void
    {
        self::$storage[$date->format('oW')][$userId] = $storageRecord;
    }

    public static function getFromStorageByOperation(Operation $operation): StorageRecord
    {
        return self::getFromStorage($operation->getDate(), $operation->getUserId());
    }
}
