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
        Schema::table('games', function (Blueprint $table) {
            $table->string('author')->nullable()->default('')->comment('作者');
            $table->text('summary')->nullable()->comment('简介');
            $table->text('how_to_redeem')->nullable()->comment('如何兑换');
            $table->text('faq')->nullable()->comment('常见问题');
            $table->tinyInteger('is_special_recommend')->default(0)->comment('特别推荐');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('games', function (Blueprint $table) {
            $table->dropColumn(['author', 'summary', 'how_to_redeem', 'faq', 'is_special_recommend']);
        });
    }
};
