<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Event;
use App\Models\Category;
use App\Enums\EventStatus;
use Database\Seeders\CategorySeeder;
use Illuminate\Support\Facades\Hash;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_user(): void {
        // 事前にユーザーを作成（パスワードハッシュ化OK！）
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        // ログイン成功後はダッシュボード等にリダイレクトされるから302で正解！
        $response->assertStatus(302);
    }

    public function test_edit_event_screen(): void {
        // 事前にユーザーを作成
        $user = User::factory()->create();

        // ユーザーでログイン
        $this->actingAs($user);

        // シーダーを実行してカテゴリを取得
        $this->seed(CategorySeeder::class);
        $category = Category::firstOrFail();

        // イベントを事前に作成
        $event = Event::factory()->create([
            'user_id' => $user->id,
            'title' => 'Test Event',
            'event_date' => now()->addDays(10)->format('Y-m-d'),
            'category_id' => $category->id,
            'status' => EventStatus::Scheduled->value,
            'image_path' => null,
        ]);

        // 編集画面を開く（GETリクエスト）
        $response = $this->get("/event/edit/{$event->id}");

        // ログイン済み＆データが存在するので200（成功）を検証！
        $response->assertStatus(200);
    }

    public function test_update_event(): void {
        // 事前にユーザーを作成
        $user = User::factory()->create();

        // ユーザーでログイン
        $this->actingAs($user);

        // シーダーを実行してカテゴリを取得
        $this->seed(CategorySeeder::class);
        $category = Category::firstOrFail();

        // イベントステータスを取得
        $status = EventStatus::Scheduled->value;

        // イベントを事前に作成
        $event = Event::factory()->create([
            'user_id' => $user->id,
            'title' => '更新前イベント',
            'event_date' => now()->addDays(5)->format('Y-m-d'),
            'category_id' => $category->id,
            'status' => $status,
            'location' => '東京ドーム',
            'description' => '更新前のメモです',
            'image_path' => null,
        ]);

        // 更新データを用意
        $updateData = [
            'title' => '更新後イベント（自動テスト）',
            'event_date' => now()->addDays(10)->format('Y-m-d'),
            'category_id' => $category->id,
            'status' => EventStatus::Completed->value,
            'location' => '幕張メッセ',
            'description' => '更新後のメモです',
        ];

        // PUTリクエストで更新処理を実行
        $response = $this->put("/event/update/{$event->id}", $updateData);

        // 更新成功後はイベント詳細画面へリダイレクトされる（302）
        $response->assertStatus(302);
        $response->assertRedirect(route('event.show', $event->id));
        $response->assertSessionHas('success', 'イベントが更新されました。');

        // データベースの値が正しく更新されていることを検証！
        $this->assertDatabaseHas('events', [
            'id' => $event->id,
            'title' => '更新後イベント（自動テスト）',
            'location' => '幕張メッセ',
            'description' => '更新後のメモです',
            'status' => EventStatus::Completed->value,
        ]);
    }
}
