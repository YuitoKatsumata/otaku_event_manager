<?php

namespace App\Enums;

enum EventStatus: string
{
    case Scheduled = 'scheduled';
    case Completed = 'completed';
    case Cancelled = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::Scheduled => '参加予定',
            self::Completed => '参加済み',
            self::Cancelled => 'キャンセル',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::Scheduled => 'badge-plan',
            self::Completed => 'badge-done',
            self::Cancelled => 'badge-wish',
        };
    }

    public static function tryFromLegacy(?string $value): ?self
    {
        if ($value === null) {
            return null;
        }

        return match ($value) {
            '参加予定', 'scheduled' => self::Scheduled,
            '参加済み', 'completed' => self::Completed,
            'キャンセル', 'cancelled' => self::Cancelled,
            default => self::tryFrom($value),
        };
    }
}
