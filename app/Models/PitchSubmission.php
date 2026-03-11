<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PitchSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'authors',
        'lembaga',
        'judul',
        'abstract_link',
        'video_link',
        'status',
        'admin_notes',
    ];

    protected static function booted(): void
    {
        static::creating(function (PitchSubmission $submission) {
            $submission->uuid = (string) Str::uuid();

            $lastSubmission = static::orderByDesc('id')->first();
            $nextNum = $lastSubmission ? $lastSubmission->id + 1 : 1;
            $submission->submission_number = '3MPC-'.str_pad($nextNum, 4, '0', STR_PAD_LEFT);
        });
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function scopeSubmitted($query)
    {
        return $query->where('status', 'submitted');
    }

    public function scopeAccepted($query)
    {
        return $query->where('status', 'accepted');
    }

    public function getAuthorsArrayAttribute(): array
    {
        return array_map('trim', explode(';', $this->authors));
    }
}
