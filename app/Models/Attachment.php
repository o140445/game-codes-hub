<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Attachment extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'original_name',
        'file_path',
        'file_size',
        'mime_type',
        'extension',
        'disk',
        'description',
        'alt_text',
        'user_id',
        'attachable_type',
        'attachable_id',
        'is_public',
        'download_count',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'file_size' => 'integer',
        'is_public' => 'boolean',
        'download_count' => 'integer',
    ];

    /**
     * Get the user that owns the attachment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the parent attachable model.
     */
    public function attachable()
    {
        return $this->morphTo();
    }

    /**
     * Get the file URL.
     */
    public function getUrlAttribute()
    {
        return Storage::disk($this->disk)->url($this->file_path);
    }

    /**
     * Get the file size in human readable format.
     */
    public function getHumanSizeAttribute()
    {
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Check if the file is an image.
     */
    public function getIsImageAttribute()
    {
        return str_starts_with($this->mime_type, 'image/');
    }

    /**
     * Check if the file is a document.
     */
    public function getIsDocumentAttribute()
    {
        $documentTypes = [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'text/plain',
        ];

        return in_array($this->mime_type, $documentTypes);
    }

    /**
     * Delete the file when the model is deleted.
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($attachment) {
            if (Storage::disk($attachment->disk)->exists($attachment->file_path)) {
                Storage::disk($attachment->disk)->delete($attachment->file_path);
            }
        });
    }
}
