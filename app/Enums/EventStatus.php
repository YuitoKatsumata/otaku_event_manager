<?php

namespace App\Enums;

enum EventStatus: string
{
    case Scheduled = '参加予定';
    case Completed = '参加済み';
    case OnCancel = 'キャンセル';

    public function label(): string
    {
        return match ($this) {
            self::Scheduled => '参加予定',
            self::Completed => '参加済み',
            self::OnCancel => 'キャンセル',
        };
    }
}
