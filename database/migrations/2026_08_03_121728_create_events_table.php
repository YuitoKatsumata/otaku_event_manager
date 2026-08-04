<?php

use App\Models\Event;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\EventStatus;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();

            //ユーザーIDを外部キーとして設定し、ユーザーが削除された場合に関連するイベントも削除されるようにする
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->nullable(false);

            //カテゴリIDを外部キーとして設定し、カテゴリが削除された場合に関連するイベントも削除されるようにする
            $table->foreignId('category_id')->constrained()->onDelete('cascade')->nullable(false);

            $table->string('title', 255)->nullable(false);
            $table->date('event_date')->nullable(false);
            $table->string('status')->default(EventStatus::Scheduled->value)->nullable(false);

            $table->text('description')->nullable();
            $table->string('location', 255)->nullable();

            // 画像のパスを保存するカラム
            $table->string('image_path', 255)->nullable();

            $table->string('event_url', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
