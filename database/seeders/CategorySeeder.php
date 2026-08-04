<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use app\Models\Category;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'name' => 'アニメ',
                'slug' => 'anime',
                'color' => '#FF5733',
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'マンガ',
                'slug' => 'manga',
                'color' => '#33FF57',
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'ゲーム',
                'slug' => 'game',
                'color' => '#3357FF',
                'sort_order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'ライブ・コンサート',
                'slug' => 'live-concert',
                'color' => '#FF33FF',
                'sort_order' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'イベント・展示会',
                'slug' => 'event-exhibition',
                'color' => '#33FFFF',
                'sort_order' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '舞台・ミュージカル',
                'slug' => 'stage-musical',
                'color' => '#FFFF33',
                'sort_order' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '映画',
                'slug' => 'movie',
                'color' => '#FF9933',
                'sort_order' => 7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'ファンミーミーティング',
                'slug' => 'fan-meeting',
                'color' => '#999999',
                'sort_order' => 8,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'コラボカフェ',
                'slug' => 'collaboration-cafe',
                'color' => '#FF66CC',
                'sort_order' => 9,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'ポップアップストア',
                'slug' => 'popup-store',
                'color' => '#CCCCCC',
                'sort_order' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'その他',
                'slug' => 'other',
                'color' => '#000000',
                'sort_order' => 11,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
