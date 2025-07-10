<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('games', function (Blueprint $table) {
            $table->boolean('is_recommended')->default(false)->comment('是否推荐');
            $table->unsignedBigInteger('views')->default(0)->comment('观看次数');
        });
    }

    public function down()
    {
        Schema::table('games', function (Blueprint $table) {
            $table->dropColumn(['is_recommended', 'views']);
        });
    }
};
