<?php

namespace App\Enum;

enum Currency: string
{
    case PLN = 'PLN';
    case EUR = 'EUR';
    case USD = 'USD';

    public function label(): string
    {
        return match($this) {
            self::PLN => 'Polski złoty (PLN)',
            self::EUR => 'Euro (EUR)',
            self::USD => 'Dolar amerykański (USD)',
        };
    }
}
