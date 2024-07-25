<?php

namespace App\Enum;

enum RoleEnum: string
{
    case USER = 'ROLE_USER';
    case ADMIN = 'ROLE_ADMIN';
    case CREATOR = 'ROLE_CREATOR';
    case BUSINESS_USER = 'ROLE_BUSINESS_USER';

    /**
     * Get all roles as an array.
     *
     * @return string[]
     */
    public static function getAllRoles(): array
    {
        return array_map(fn($role) => $role->value, self::cases());
    }

    /**
     * Check if the role is valid.
     *
     * @param string $role
     * @return bool
     */
    public static function isValidRole(string $role): bool
    {
        return in_array($role, self::getAllRoles(), true);
    }
}