<?php

namespace App\Enums;

enum EventType: string
{
    case Simposium = 'simposium';
    case Handson = 'handson';
    case FunRun = 'funrun';
    case Pengmas = 'pengmas';

    public function label(): string
    {
        return match ($this) {
            self::Simposium => 'Simposium',
            self::Handson => 'Hands-on Workshop',
            self::FunRun => 'Fun Run',
            self::Pengmas => 'Pengabdian Masyarakat',
        };
    }

    public function shortCode(): string
    {
        return match ($this) {
            self::Simposium => 'SIM',
            self::Handson => 'HOS',
            self::FunRun => 'FNR',
            self::Pengmas => 'PGM',
        };
    }

    public function formType(): string
    {
        return match ($this) {
            self::FunRun => 'funrun',
            default => 'satusehat',
        };
    }
}
