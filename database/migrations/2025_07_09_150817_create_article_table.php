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
        Schema::create('article', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable()->comment('标题');
            $table->string('slug')->nullable()->comment('slug');
            $table->string('image')->nullable()->comment('图片');
            $table->text('content')->nullable()->comment('正文');
            $table->tinyInteger('status')->default(1)->comment('状态');
            $table->string('category')->nullable()->default('')->comment('分类');
            $table->string('author')->nullable()->default('')->comment('作者');
            $table->string('source')->nullable()->default('')->comment('来源');
            $table->timestamps();
            $table->softDeletes();
            $table->index('title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article');
    }
};
