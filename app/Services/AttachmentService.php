<?php

namespace App\Services;

use App\Models\Attachment;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AttachmentService
{
    /**
     * 上传文件并创建附件记录
     */
    public function upload(UploadedFile $file, array $data = []): Attachment
    {
        $originalName = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $mimeType = $file->getMimeType();
        $fileSize = $file->getSize();

        // 生成唯一文件名
        $fileName = Str::uuid() . '.' . $extension;

        // 确定存储路径
        $disk = $data['disk'] ?? 'public';
        $directory = $data['directory'] ?? 'attachments';
        $filePath = $directory . '/' . $fileName;

        // 存储文件
        Storage::disk($disk)->putFileAs($directory, $file, $fileName);

        // 创建附件记录
        return Attachment::create([
            'name' => $data['name'] ?? $originalName,
            'original_name' => $originalName,
            'file_path' => $filePath,
            'file_size' => $fileSize,
            'mime_type' => $mimeType,
            'extension' => $extension,
            'disk' => $disk,
            'description' => $data['description'] ?? null,
            'alt_text' => $data['alt_text'] ?? null,
            'user_id' => $data['user_id'] ?? auth()->id(),
            'attachable_type' => $data['attachable_type'] ?? null,
            'attachable_id' => $data['attachable_id'] ?? null,
            'is_public' => $data['is_public'] ?? true,
            'download_count' => 0,
        ]);
    }

    /**
     * 批量上传文件
     */
    public function uploadMultiple(array $files, array $data = []): array
    {
        $attachments = [];

        foreach ($files as $file) {
            if ($file instanceof UploadedFile) {
                $attachments[] = $this->upload($file, $data);
            }
        }

        return $attachments;
    }

    /**
     * 删除附件
     */
    public function delete(Attachment $attachment): bool
    {
        // 删除物理文件
        if (Storage::disk($attachment->disk)->exists($attachment->file_path)) {
            Storage::disk($attachment->disk)->delete($attachment->file_path);
        }

        // 删除数据库记录
        return $attachment->delete();
    }

    /**
     * 获取文件下载URL
     */
    public function getDownloadUrl(Attachment $attachment): string
    {
        return Storage::disk($attachment->disk)->url($attachment->file_path);
    }

    /**
     * 增加下载次数
     */
    public function incrementDownloadCount(Attachment $attachment): void
    {
        $attachment->increment('download_count');
    }

    /**
     * 验证文件类型
     */
    public function validateFileType(UploadedFile $file, array $allowedTypes = []): bool
    {
        if (empty($allowedTypes)) {
            $allowedTypes = [
                'image/*',
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/vnd.ms-excel',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'text/plain',
                'application/zip',
                'application/x-rar-compressed',
            ];
        }

        $mimeType = $file->getMimeType();

        foreach ($allowedTypes as $allowedType) {
            if (str_ends_with($allowedType, '/*')) {
                $baseType = str_replace('/*', '', $allowedType);
                if (str_starts_with($mimeType, $baseType)) {
                    return true;
                }
            } elseif ($mimeType === $allowedType) {
                return true;
            }
        }

        return false;
    }

    /**
     * 获取文件统计信息
     */
    public function getStats(): array
    {
        return [
            'total' => Attachment::count(),
            'images' => Attachment::where('mime_type', 'like', 'image/%')->count(),
            'documents' => Attachment::whereIn('mime_type', [
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/vnd.ms-excel',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'text/plain',
            ])->count(),
            'public' => Attachment::where('is_public', true)->count(),
            'private' => Attachment::where('is_public', false)->count(),
            'total_size' => Attachment::sum('file_size'),
        ];
    }
}
