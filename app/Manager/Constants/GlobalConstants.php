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
}
