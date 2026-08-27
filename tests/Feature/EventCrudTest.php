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
    use RefreshDatabase;

    private User $user;
    private User $otherUser;
    private Category $category;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->otherUser = User::factory()->create();

        $this->category = Category::create([
            'name' => 'アニメ',
            'slug' => 'anime',
            'color' => '#FF5733',
            'sort_order' => 1,
        ]);
    }

    public function test_guest_cannot_access_events(): void
    {
        $response = $this->get(route('event.create'));
        $response->assertRedirect(route('login'));
    }

    public function test_user_can_view_create_form(): void
    {
        $response = $this->actingAs($this->user)->get(route('event.create'));

        $response->assertStatus(200);
        $response->assertSee('イベント新規登録');
    }

    public function test_user_can_create_event(): void
    {
        $eventData = [
            'title' => 'コミックマーケット',
            'category_id' => $this->category->id,
            'event_date' => now()->addDays(10)->format('Y-m-d'),
            'status' => EventStatus::Scheduled->value,
            'location' => '東京ビッグサイト',
            'description' => '東ホール 10:00開場',
            'event_url' => 'https://example.com/comiket',
        ];

        $response = $this->actingAs($this->user)->post(route('event.store'), $eventData);

        $response->assertRedirect(route('home'));
        $response->assertSessionHas('success', 'イベントを作成しました。');

        $this->assertDatabaseHas('events', [
            'user_id' => $this->user->id,
            'title' => 'コミックマーケット',
            'location' => '東京ビッグサイト',
            'status' => 'scheduled',
        ]);
    }

    public function test_user_can_create_event_with_image(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('ticket.jpg');

        $eventData = [
            'title' => 'アニサマ 2026',
            'category_id' => $this->category->id,
            'event_date' => now()->addDays(30)->format('Y-m-d'),
            'status' => EventStatus::Scheduled->value,
            'image_path' => $file,
        ];

        $response = $this->actingAs($this->user)->post(route('event.store'), $eventData);

        $response->assertRedirect(route('home'));

        $event = Event::where('title', 'アニサマ 2026')->first();
        $this->assertNotNull($event);
        $this->assertNotNull($event->image_path);

        Storage::disk('public')->assertExists($event->image_path);
    }

    public function test_user_can_view_their_own_event(): void
    {
        $event = Event::create([
            'user_id' => $this->user->id,
            'category_id' => $this->category->id,
            'title' => '声優ライブ',
            'event_date' => now()->addDays(5)->format('Y-m-d'),
            'status' => EventStatus::Scheduled->value,
            'location' => '日本武道館',
        ]);

        $response = $this->actingAs($this->user)->get(route('event.show', $event->id));

        $response->assertStatus(200);
        $response->assertSee('声優ライブ');
        $response->assertSee('日本武道館');
    }

    public function test_user_cannot_view_other_users_event(): void
    {
        $otherEvent = Event::create([
            'user_id' => $this->otherUser->id,
            'category_id' => $this->category->id,
            'title' => '他人の秘密イベント',
            'event_date' => now()->addDays(5)->format('Y-m-d'),
            'status' => EventStatus::Scheduled->value,
        ]);

        $response = $this->actingAs($this->user)->get(route('event.show', $otherEvent->id));

        $response->assertStatus(403);
    }

    public function test_user_can_view_edit_form_of_their_own_event(): void
    {
        $event = Event::create([
            'user_id' => $this->user->id,
            'category_id' => $this->category->id,
            'title' => '編集テストイベント',
            'event_date' => now()->addDays(3)->format('Y-m-d'),
            'status' => EventStatus::Scheduled->value,
        ]);

        $response = $this->actingAs($this->user)->get(route('event.edit', $event->id));

        $response->assertStatus(200);
        $response->assertSee('編集テストイベント');
    }

    public function test_user_cannot_view_edit_form_of_other_users_event(): void
    {
        $otherEvent = Event::create([
            'user_id' => $this->otherUser->id,
            'category_id' => $this->category->id,
            'title' => '他人の編集対象イベント',
            'event_date' => now()->addDays(3)->format('Y-m-d'),
            'status' => EventStatus::Scheduled->value,
        ]);

        $response = $this->actingAs($this->user)->get(route('event.edit', $otherEvent->id));

        $response->assertStatus(403);
    }

    public function test_user_can_update_event(): void
    {
        $event = Event::create([
            'user_id' => $this->user->id,
            'category_id' => $this->category->id,
            'title' => '更新前タイトル',
            'event_date' => now()->addDays(10)->format('Y-m-d'),
            'status' => EventStatus::Scheduled->value,
        ]);

        $updateData = [
            'title' => '更新後タイトル',
            'category_id' => $this->category->id,
            'event_date' => now()->addDays(15)->format('Y-m-d'),
            'status' => EventStatus::Completed->value,
            'location' => '幕張メッセ',
        ];

        $response = $this->actingAs($this->user)->put(route('event.update', $event->id), $updateData);

        $response->assertRedirect(route('event.show', $event->id));
        $response->assertSessionHas('success', 'イベントを更新しました。');

        $this->assertDatabaseHas('events', [
            'id' => $event->id,
            'title' => '更新後タイトル',
            'status' => 'completed',
            'location' => '幕張メッセ',
        ]);
    }

    public function test_user_can_update_event_image_and_old_image_is_deleted(): void
    {
        Storage::fake('public');

        $oldFile = UploadedFile::fake()->image('old_banner.png');
        $oldPath = $oldFile->store('event_images', 'public');

        $event = Event::create([
            'user_id' => $this->user->id,
            'category_id' => $this->category->id,
            'title' => '画像変更テスト',
            'event_date' => now()->addDays(10)->format('Y-m-d'),
            'status' => EventStatus::Scheduled->value,
            'image_path' => $oldPath,
        ]);

        Storage::disk('public')->assertExists($oldPath);

        $newFile = UploadedFile::fake()->image('new_banner.png');

        $updateData = [
            'title' => '画像変更テスト（更新後）',
            'category_id' => $this->category->id,
            'event_date' => now()->addDays(10)->format('Y-m-d'),
            'status' => EventStatus::Scheduled->value,
            'image_path' => $newFile,
        ];

        $response = $this->actingAs($this->user)->put(route('event.update', $event->id), $updateData);

        $response->assertRedirect(route('event.show', $event->id));

        $event->refresh();

        // 旧画像が削除され、新画像が存在することを確認
        Storage::disk('public')->assertMissing($oldPath);
        Storage::disk('public')->assertExists($event->image_path);
    }

    public function test_user_cannot_update_other_users_event(): void
    {
        $otherEvent = Event::create([
            'user_id' => $this->otherUser->id,
            'category_id' => $this->category->id,
            'title' => '他人の更新対象イベント',
            'event_date' => now()->addDays(10)->format('Y-m-d'),
            'status' => EventStatus::Scheduled->value,
        ]);

        $updateData = [
            'title' => '不正更新タイトル',
            'category_id' => $this->category->id,
            'event_date' => now()->addDays(10)->format('Y-m-d'),
            'status' => EventStatus::Scheduled->value,
        ];

        $response = $this->actingAs($this->user)->put(route('event.update', $otherEvent->id), $updateData);

        $response->assertStatus(403);
    }

    public function test_user_can_delete_event_and_image_is_deleted(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('event_banner.png');
        $imagePath = $file->store('event_images', 'public');

        $event = Event::create([
            'user_id' => $this->user->id,
            'category_id' => $this->category->id,
            'title' => '削除対象イベント',
            'event_date' => now()->addDays(5)->format('Y-m-d'),
            'status' => EventStatus::Scheduled->value,
            'image_path' => $imagePath,
        ]);

        Storage::disk('public')->assertExists($imagePath);

        $response = $this->actingAs($this->user)->delete(route('event.destroy', $event->id));

        $response->assertRedirect(route('home'));
        $response->assertSessionHas('success', 'イベントを削除しました。');

        $this->assertDatabaseMissing('events', ['id' => $event->id]);
        Storage::disk('public')->assertMissing($imagePath);
    }

    public function test_user_cannot_delete_other_users_event(): void
    {
        $otherEvent = Event::create([
            'user_id' => $this->otherUser->id,
            'category_id' => $this->category->id,
            'title' => '他人の削除対象イベント',
            'event_date' => now()->addDays(5)->format('Y-m-d'),
            'status' => EventStatus::Scheduled->value,
        ]);

        $response = $this->actingAs($this->user)->delete(route('event.destroy', $otherEvent->id));

        $response->assertStatus(403);
        $this->assertDatabaseHas('events', ['id' => $otherEvent->id]);
    }

    public function test_home_dashboard_only_shows_authenticated_user_events(): void
    {
        // ログインユーザーのイベント
        Event::create([
            'user_id' => $this->user->id,
            'category_id' => $this->category->id,
            'title' => '自分の参加予定イベント',
            'event_date' => now()->addDays(2)->format('Y-m-d'),
            'status' => EventStatus::Scheduled->value,
        ]);

        // 他ユーザーのイベント
        Event::create([
            'user_id' => $this->otherUser->id,
            'category_id' => $this->category->id,
            'title' => '他人の参加予定イベント',
            'event_date' => now()->addDays(3)->format('Y-m-d'),
            'status' => EventStatus::Scheduled->value,
        ]);

        $response = $this->actingAs($this->user)->get(route('home'));

        $response->assertStatus(200);
        $response->assertSee('自分の参加予定イベント');
        $response->assertDontSee('他人の参加予定イベント');
    }

    public function test_legacy_japanese_status_is_supported(): void
    {
        // DBに直接旧形式の日本語ステータスを挿入
        \Illuminate\Support\Facades\DB::table('events')->insert([
            'user_id' => $this->user->id,
            'category_id' => $this->category->id,
            'title' => '旧データイベント',
            'event_date' => now()->addDays(2)->format('Y-m-d'),
            'status' => '参加済み',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $event = Event::where('title', '旧データイベント')->first();
        $this->assertInstanceOf(EventStatus::class, $event->status);
        $this->assertSame(EventStatus::Completed, $event->status);
        $this->assertSame('参加済み', $event->status->label());

        // ホーム画面での集計も旧データを含めて正しく動作することを確認
        $response = $this->actingAs($this->user)->get(route('home'));
        $response->assertStatus(200);
        $response->assertSee('旧データイベント');
    }
}

