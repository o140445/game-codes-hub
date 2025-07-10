<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Attachment;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // 创建一些测试附件
        Attachment::factory(20)->create();

        // 创建一些图片附件
        Attachment::factory(10)->image()->create();

        // 创建一些文档附件
        Attachment::factory(10)->document()->create();
    }
}
