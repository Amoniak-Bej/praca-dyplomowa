<?php

namespace App\Enum;

enum LoadType: string
{
    case FTL = 'FTL';
    case LTL = 'LTL';

    public function label(): string{
        return match ($this){
            self::FTL => 'Pełny ładunek (FTL)',
            self::LTL => 'Częściowy ładunek (LTL)',
        };
    }
}