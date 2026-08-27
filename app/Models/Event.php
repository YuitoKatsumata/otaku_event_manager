<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Enums\EventStatus;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'event_date',
        'status',
        'description',
        'location',
        'image_path',
        'event_url',
    ];

    protected $casts = [
        'event_date' => 'date',
    ];

    protected function status(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                if ($value instanceof EventStatus) {
                    return $value;
                }
                return EventStatus::tryFromLegacy($value) ?? EventStatus::Scheduled;
            },
            set: function ($value) {
                if ($value instanceof EventStatus) {
                    return $value->value;
                }
                return EventStatus::tryFromLegacy($value)?->value ?? $value;
            }
        );
    }

    protected static function booted(): void
    {
        static::deleting(function (Event $event) {
            if ($event->image_path) {
                Storage::disk('public')->delete($event->image_path);
            }
        });
    }

    public function getDaysRemainingAttribute(): int
    {
        if (!$this->event_date || $this->event_date->isPast()) {
            return 0;
        }

        return (int) now()->startOfDay()->diffInDays($this->event_date->startOfDay(), false);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
