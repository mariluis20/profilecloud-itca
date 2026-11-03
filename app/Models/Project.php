<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Project extends Model
{
    protected $fillable = [
        'title',
        'description',
        'technologies',
        'repo_url',
        'demo_url',
        'year',
    ];

    protected function casts(): array
    {
        return [
            'year' => 'integer',
        ];
    }

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }

    public function getTechListAttribute(): array
    {
        return collect(explode(',', (string) $this->technologies))
            ->map(fn ($t) => trim($t))
            ->filter()
            ->values()
            ->all();
    }
}
