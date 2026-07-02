<?php

namespace App\Enums;

enum Level: int
{
    case Free   = 100 + 1;
    case Basic  = 100 + 3;
    case Vip    = 100 + 2;
    case Elite  = 100 + 4;
    case Admin  = 100 + 5;

    public function label(): string
    {
        return match($this) {
            self::Free  => 'Free',
            self::Basic => 'Basic',
            self::Vip   => 'Vip',
            self::Elite => 'Elite',
            self::Admin => 'Admin',
        };
    }

    public static function asArray(): array
    {
        $arr = [];
        foreach (self::cases() as $case) {
            $arr[$case->value] = $case->label();
        }
        return $arr;
    }
}
