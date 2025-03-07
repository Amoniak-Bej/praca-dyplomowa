<?php

namespace App\Enum;

enum TransportOrderStatus: string
{
    case NEW = 'nowe';
    case ASSIGNED = 'przypisane';
    case IN_PROGRESS = 'w trakcie realizacji';
    case COMPLETED = 'zakończone';

    public function label(): string
    {
        return match($this) {
            self::NEW => 'Nowe',
            self::ASSIGNED => 'Przypisane',
            self::IN_PROGRESS => 'W trakcie realizacji',
            self::COMPLETED => 'Zakończone',
        };
    }
}
