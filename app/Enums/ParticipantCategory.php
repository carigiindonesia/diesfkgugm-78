<?php

namespace App\Enums;

enum ParticipantCategory: string
{
    case Alumni = 'alumni';
    case Civitas = 'civitas';
    case Umum = 'umum';

    public function label(): string
    {
        return match ($this) {
            self::Alumni => 'Alumni',
            self::Civitas => 'Civitas Akademika',
            self::Umum => 'Umum',
        };
    }

    public function shortCode(): string
    {
        return match ($this) {
            self::Alumni => 'A',
            self::Civitas => 'C',
            self::Umum => 'U',
        };
    }
}
