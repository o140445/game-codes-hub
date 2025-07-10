<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Services\AttachmentService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AttachmentController extends Controller
{
    protected AttachmentService $attachmentService;

    public function __construct(AttachmentService $attachmentService)
    {
        $this->attachmentService = $attachmentService;
    }

    /**
     * 上传文件
     */
    public function upload(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|max:51200', // 50MB
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'alt_text' => 'nullable|string|max:255',
            'is_public' => 'nullable|boolean',
            'attachable_type' => 'nullable|string|max:255',
            'attachable_id' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => '验证失败',
                'errors' => $validator->errors(),
            ], 422);
        }

        $file = $request->file('file');

        // 验证文件类型
        if (!$this->attachmentService->validateFileType($file)) {
            return response()->json([
                'success' => false,
                'message' => '不支持的文件类型',
            ], 400);
        }

        try {
            $attachment = $this->attachmentService->upload($file, [
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'alt_text' => $request->input('alt_text'),
                'is_public' => $request->input('is_public', true),
                'attachable_type' => $request->input('attachable_type'),
                'attachable_id' => $request->input('attachable_id'),
                'user_id' => auth()->id(),
            ]);

            return response()->json([
                'success' => true,
                'message' => '文件上传成功',
                'data' => [
                    'id' => $attachment->id,
                    'name' => $attachment->name,
                    'original_name' => $attachment->original_name,
                    'file_size' => $attachment->file_size,
                    'human_size' => $attachment->human_size,
                    'mime_type' => $attachment->mime_type,
                    'extension' => $attachment->extension,
                    'url' => $attachment->url,
                    'is_image' => $attachment->is_image,
                    'is_document' => $attachment->is_document,
                    'created_at' => $attachment->created_at,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '文件上传失败: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * 批量上传文件
     */
    public function uploadMultiple(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'files.*' => 'required|file|max:51200', // 50MB
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'alt_text' => 'nullable|string|max:255',
            'is_public' => 'nullable|boolean',
            'attachable_type' => 'nullable|string|max:255',
            'attachable_id' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => '验证失败',
                'errors' => $validator->errors(),
            ], 422);
        }

        $files = $request->file('files');

        if (empty($files)) {
            return response()->json([
                'success' => false,
                'message' => '没有选择文件',
            ], 400);
        }

        try {
            $attachments = $this->attachmentService->uploadMultiple($files, [
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'alt_text' => $request->input('alt_text'),
                'is_public' => $request->input('is_public', true),
                'attachable_type' => $request->input('attachable_type'),
                'attachable_id' => $request->input('attachable_id'),
                'user_id' => auth()->id(),
            ]);

            $data = collect($attachments)->map(function ($attachment) {
                return [
                    'id' => $attachment->id,
                    'name' => $attachment->name,
                    'original_name' => $attachment->original_name,
                    'file_size' => $attachment->file_size,
                    'human_size' => $attachment->human_size,
                    'mime_type' => $attachment->mime_type,
                    'extension' => $attachment->extension,
                    'url' => $attachment->url,
                    'is_image' => $attachment->is_image,
                    'is_document' => $attachment->is_document,
                    'created_at' => $attachment->created_at,
                ];
            });

            return response()->json([
                'success' => true,
                'message' => '文件批量上传成功',
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '文件批量上传失败: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * 下载文件
     */
    public function download(Attachment $attachment)
    {
        // 检查文件是否存在
        if (!Storage::disk($attachment->disk)->exists($attachment->file_path)) {
            abort(404, '文件不存在');
        }

        // 检查访问权限
        if (!$attachment->is_public && auth()->id() !== $attachment->user_id) {
            abort(403, '没有权限访问此文件');
        }

        // 增加下载次数
        $this->attachmentService->incrementDownloadCount($attachment);

        // 返回文件下载
        return Storage::disk($attachment->disk)->download(
            $attachment->file_path,
            $attachment->original_name
        );
    }

    /**
     * 获取附件列表
     */
    public function index(Request $request): JsonResponse
    {
        $query = Attachment::with('user');

        // 搜索
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('original_name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // 文件类型过滤
        if ($request->has('mime_type')) {
            $mimeType = $request->input('mime_type');
            if (str_ends_with($mimeType, '/*')) {
                $baseType = str_replace('/*', '', $mimeType);
                $query->where('mime_type', 'like', "{$baseType}%");
            } else {
                $query->where('mime_type', $mimeType);
            }
        }

        // 公开状态过滤
        if ($request->has('is_public')) {
            $query->where('is_public', $request->boolean('is_public'));
        }

        // 用户过滤
        if ($request->has('user_id')) {
            $query->where('user_id', $request->input('user_id'));
        }

        // 排序
        $sortBy = $request->input('sort_by', 'created_at');
        $sortOrder = $request->input('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // 分页
        $perPage = $request->input('per_page', 15);
        $attachments = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $attachments,
        ]);
    }

    /**
     * 获取附件详情
     */
    public function show(Attachment $attachment): JsonResponse
    {
        // 检查访问权限
        if (!$attachment->is_public && auth()->id() !== $attachment->user_id) {
            return response()->json([
                'success' => false,
                'message' => '没有权限访问此文件',
            ], 403);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $attachment->id,
                'name' => $attachment->name,
                'original_name' => $attachment->original_name,
                'file_size' => $attachment->file_size,
                'human_size' => $attachment->human_size,
                'mime_type' => $attachment->mime_type,
                'extension' => $attachment->extension,
                'url' => $attachment->url,
                'description' => $attachment->description,
                'alt_text' => $attachment->alt_text,
                'is_public' => $attachment->is_public,
                'download_count' => $attachment->download_count,
                'is_image' => $attachment->is_image,
                'is_document' => $attachment->is_document,
                'user' => [
                    'id' => $attachment->user->id,
                    'name' => $attachment->user->name,
                ],
                'created_at' => $attachment->created_at,
                'updated_at' => $attachment->updated_at,
            ],
        ]);
    }

    /**
     * 删除附件
     */
    public function destroy(Attachment $attachment): JsonResponse
    {
        // 检查权限
        if (auth()->id() !== $attachment->user_id && !auth()->user()->hasRole('admin')) {
            return response()->json([
                'success' => false,
                'message' => '没有权限删除此文件',
            ], 403);
        }

        try {
            $this->attachmentService->delete($attachment);

            return response()->json([
                'success' => true,
                'message' => '文件删除成功',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '文件删除失败: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * 获取附件统计信息
     */
    public function stats(): JsonResponse
    {
        $stats = $this->attachmentService->getStats();

        return response()->json([
            'success' => true,
            'data' => $stats,
        ]);
    }
}
