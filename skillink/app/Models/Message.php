<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    protected $fillable = [
        'swap_request_id', 'sender_id', 'body', 'file_path', 'file_name', 'file_size', 'file_mime',
    ];

    public function swapRequest(): BelongsTo
    {
        return $this->belongsTo(SwapRequest::class);
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function hasAttachment(): bool
    {
        return ! is_null($this->file_path);
    }

    /**
     * Human-readable file size, e.g. "240 KB" or "1.3 MB".
     */
    public function fileSizeForHumans(): ?string
    {
        if (is_null($this->file_size)) {
            return null;
        }

        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];

        for ($i = 0; $bytes >= 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $bytes < 10 ? 1 : 0).' '.$units[$i];
    }
}
