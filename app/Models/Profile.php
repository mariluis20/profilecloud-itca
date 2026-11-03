<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Profile extends Model
{
    public const CARRERAS = [
        'Ingeniería en Desarrollo de Software',
        'Técnico en Ingeniería de Sistemas Informáticos',
        'Técnico en Ingeniería de Redes Informáticas',
        'Técnico en Ingeniería Eléctrica',
        'Técnico en Ingeniería Mecatrónica',
        'Técnico en Ingeniería Industrial',
        'Técnico en Diseño Gráfico',
        'Técnico en Gastronomía',
        'Otra carrera',
    ];

    public const SEDES = [
        'Santa Tecla',
        'San Miguel',
        'Santa Ana',
        'Zacatecoluca',
        'La Unión',
    ];

    protected $fillable = [
        'slug',
        'headline',
        'bio',
        'carrera',
        'sede',
        'ciclo',
        'github_url',
        'linkedin_url',
        'website_url',
        'photo_path',
        'is_public',
        'available',
    ];

    protected function casts(): array
    {
        return [
            'is_public' => 'boolean',
            'available' => 'boolean',
            'ciclo' => 'integer',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function skills(): HasMany
    {
        return $this->hasMany(Skill::class)->orderByDesc('level')->orderBy('name');
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class)->latest();
    }

    public function scopeVisible(Builder $query): Builder
    {
        return $query->where('is_public', true)
            ->whereHas('user', fn (Builder $u) => $u->where('is_active', true)->where('role', User::ROLE_STUDENT));
    }

    public function getPhotoUrlAttribute(): ?string
    {
        return $this->photo_path ? asset('storage/'.$this->photo_path) : null;
    }

    public function isVisible(): bool
    {
        return $this->is_public && $this->user && $this->user->is_active && $this->user->isStudent();
    }

    public function completion(): int
    {
        $checks = [
            filled($this->headline),
            filled($this->bio),
            filled($this->carrera),
            filled($this->sede),
            filled($this->photo_path),
            filled($this->github_url) || filled($this->linkedin_url) || filled($this->website_url),
            $this->skills()->count() >= 3,
            $this->projects()->count() >= 1,
        ];

        return (int) round(collect($checks)->filter()->count() / count($checks) * 100);
    }

    public static function uniqueSlug(string $name): string
    {
        $base = Str::slug($name) ?: 'perfil';
        $slug = $base;
        $i = 2;

        while (static::where('slug', $slug)->exists()) {
            $slug = $base.'-'.$i++;
        }

        return $slug;
    }
}
