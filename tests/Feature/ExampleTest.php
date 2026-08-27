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

    public function test_update_event(): void {
        // 事前にユーザーを作成
        $user = User::factory()->create();

        // ユーザーでログイン
        $this->actingAs($user);

        // シーダーを正しい方法で実行してカテゴリを取得
        $this->seed(CategorySeeder::class);
        $category = Category::firstOrFail();

        // イベントステータスを取得
        $status = EventStatus::Scheduled->value;

        // イベントを事前に作成
        $event = Event::factory()->create([
            'user_id' => $user->id,
            'title' => 'Test Event',
            'event_date' => now()->addDays(10)->format('Y-m-d'),
            'category_id' => $category->id,
            'status' => $status,
            'image_path' => null,
        ]);

        // 編集画面を開く（GETリクエスト）
        $response = $this->get(route('event.edit', $event->id));

        // ログイン済み＆データが存在するので200（成功）を検証！
        $response->assertStatus(200);

        // 更新データを用意
        $updateData = [
            'title' => '更新自動テスト',
            'event_date' => now()->addDays(10)->format('Y-m-d'),
            'category_id' => $category->id,
            'status' => $status,
            'location' => null,
            'image_path' => null,
        ];

        $updateResponse = $this->put(route('event.update', $event->id), $updateData);
        $updateResponse->assertRedirect(route('event.show', $event->id));
    }
}
