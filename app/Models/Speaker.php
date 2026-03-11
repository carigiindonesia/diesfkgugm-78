<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Speaker extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'name',
        'title',
        'topic',
        'section',
        'day',
        'photo',
        'initials',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    public function scopeSection($query, string $section)
    {
        return $query->where('section', $section);
    }

    public function getPhotoUrlAttribute(): ?string
    {
        if ($this->photo) {
            return asset('storage/'.$this->photo);
        }

        return null;
    }

    public function getInitialsDisplayAttribute(): string
    {
        if ($this->initials) {
            return $this->initials;
        }

        $words = explode(' ', $this->name);
        $initials = '';
        foreach ($words as $word) {
            $clean = preg_replace('/[^A-Za-z]/', '', $word);
            if ($clean && strtolower($clean) !== 'drg' && strtolower($clean) !== 'dr' && strtolower($clean) !== 'prof') {
                $initials .= strtoupper($clean[0]);
            }
            if (strlen($initials) >= 2) {
                break;
            }
        }

        return $initials ?: '??';
    }
}
