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
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('文件名');
            $table->string('original_name')->comment('原始文件名');
            $table->string('file_path')->comment('文件路径');
            $table->bigInteger('file_size')->comment('文件大小(字节)');
            $table->string('mime_type')->comment('MIME类型');
            $table->string('extension')->comment('文件扩展名');
            $table->string('disk')->default('public')->comment('存储磁盘');
            $table->text('description')->nullable()->comment('描述');
            $table->string('alt_text')->nullable()->comment('替代文本');
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->comment('上传用户ID');
            $table->string('attachable_type')->nullable()->comment('关联模型类型');
            $table->unsignedBigInteger('attachable_id')->nullable()->comment('关联模型ID');
            $table->boolean('is_public')->default(true)->comment('是否公开');
            $table->integer('download_count')->default(0)->comment('下载次数');
            $table->timestamps();
            $table->softDeletes();

            // 索引
            $table->index(['attachable_type', 'attachable_id']);
            $table->index('user_id');
            $table->index('is_public');
            $table->index('created_at');

            $table->comment('附件表');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attachments');
    }
};
