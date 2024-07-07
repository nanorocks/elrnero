<?php

namespace App\Enum;

enum LevelEnum: string
{
    case BEGINNER = '1';
    case INTERMEDIATE = '2';
    case EXPERT = '3';

    /**
     * Get all levels as an array.
     *
     * @return array[]
     */
    public static function getAllLevels(): array
    {
        return array_map(fn ($item) => $item->name, self::cases());
    }

    /**
     * Check if the Item is valid.
     *
     * @param string $Item
     * @return bool
     */
    public static function isValidItem(string $item): bool
    {
        return in_array($item, self::getAllLevels(), true);
    }

    public static function getNameByValue(string $value)
    {
        $items = array_filter(self::cases(), fn ($item) => $item->value == $value);

        $items = array_map(fn ($item) => $item->name, $items);

        $items = array_values($items);

        return $items[0];
    }
}