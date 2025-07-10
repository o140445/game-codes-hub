<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable()->default('')->comment('名称');
            $table->string('description')->nullable()->default('')->comment('描述');
            $table->string('slug')->nullable()->default('')->comment('slug');
            $table->string('image')->nullable()->default('')->comment('图片');
            $table->tinyInteger('status')->default(1)->comment('状态');
            $table->string('category')->nullable()->default('')->comment('分类');
            $table->string('platform')->nullable()->default('')->comment('平台');
            $table->text('content')->nullable()->comment('正文');
            $table->integer('codes_total')->default(0)->comment('总码数');
            $table->integer('codes_valid')->default(0)->comment('有效码数');
            $table->integer('codes_invalid')->default(0)->comment('无效码数');
            $table->timestamps();
            $table->softDeletes();
            $table->index('name');
            $table->index('slug');
            $table->comment('游戏表');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
