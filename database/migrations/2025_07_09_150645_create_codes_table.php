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
        Schema::create('codes', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable()->default('')->comment('码');
            $table->foreignId('game_id')->constrained('games')->comment('游戏ID');
            $table->tinyInteger('status')->default(1)->comment('状态');
            $table->string('name')->nullable()->default('')->comment('名称');
            $table->tinyInteger('is_latest')->default(0)->comment('最新标记');
            $table->string('description')->nullable()->default('')->comment('描述');
            $table->timestamps();
            $table->softDeletes();
            $table->index('code');
            $table->index('game_id');
            $table->index('status');
            $table->comment('码表');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('codes');
    }
};
