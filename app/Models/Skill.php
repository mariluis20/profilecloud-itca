<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Skill extends Model
{
    public const LEVELS = [
        1 => 'Básico',
        2 => 'En desarrollo',
        3 => 'Intermedio',
        4 => 'Avanzado',
        5 => 'Experto',
    ];

    protected $fillable = [
        'name',
        'level',
    ];

    protected function casts(): array
    {
        return [
            'level' => 'integer',
        ];
    }

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }

    public function getLevelLabelAttribute(): string
    {
        return self::LEVELS[$this->level] ?? 'Básico';
    }

    public function getPercentAttribute(): int
    {
        return $this->level * 20;
    }
}
