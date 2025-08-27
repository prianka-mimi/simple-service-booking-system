<?php

namespace App\Manager\Constants;
class GlobalConstants
{
    public const DEFAULT_PAGINATION = 20;

    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 2;

    public const STATUS_LIST_COLOR = [
        self::STATUS_ACTIVE     => '#27ae60',
        self::STATUS_INACTIVE   => '#e67e22',
    ];

    public const STATUS_PENDING   = 1;
    public const STATUS_CONFIRMED = 2;
    public const STATUS_CANCELLED = 3;
    public const STATUS_COMPLETED = 4;

    public const STATUS_LIST = [
        self::STATUS_PENDING     => '#e67e22',
        self::STATUS_CONFIRMED   => '#27ae60',
        self::STATUS_CANCELLED   => '#e74c3c',
        self::STATUS_COMPLETED   => '#141d17ff',
    ];
}
