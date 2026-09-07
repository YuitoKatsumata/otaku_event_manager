<?php

namespace Tests\Feature;

use App\Enums\EventStatus;
use App\Models\Category;
use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class EventCrudTest extends TestCase
{
/**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $this->assertTrue(true);
    }
}

