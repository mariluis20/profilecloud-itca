<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public const ROLE_ADMIN = 'admin';
    public const ROLE_STUDENT = 'estudiante';

    protected $fillable = [
        'name',
        'first_name',
        'middle_name',
        'last_name',
        'second_last_name',
        'email',
        'password',
    ];

    public const NAME_RULE = "regex:/^[\\pL\\s'\\-]+$/u";

    public static function nameRules(): array
    {
        return [
            'first_name' => ['required', 'string', 'min:2', 'max:60', self::NAME_RULE],
            'middle_name' => ['nullable', 'string', 'max:60', self::NAME_RULE],
            'last_name' => ['required', 'string', 'min:2', 'max:60', self::NAME_RULE],
            'second_last_name' => ['nullable', 'string', 'max:60', self::NAME_RULE],
        ];
    }

    public static function fullName(array $parts): string
    {
        return collect([
            $parts['first_name'] ?? null,
            $parts['middle_name'] ?? null,
            $parts['last_name'] ?? null,
            $parts['second_last_name'] ?? null,
        ])->map(fn ($p) => trim((string) $p))->filter()->implode(' ');
    }

    public static function cleanNameParts(array $data): array
    {
        $parts = [];
        foreach (['first_name', 'middle_name', 'last_name', 'second_last_name'] as $key) {
            $value = trim(preg_replace('/\s+/u', ' ', (string) ($data[$key] ?? '')));
            $parts[$key] = $value === '' ? null : mb_convert_case($value, MB_CASE_TITLE, 'UTF-8');
        }

        return $parts;
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isStudent(): bool
    {
        return $this->role === self::ROLE_STUDENT;
    }

    public function getInitialsAttribute(): string
    {
        if ($this->first_name && $this->last_name) {
            return mb_strtoupper(mb_substr($this->first_name, 0, 1).mb_substr($this->last_name, 0, 1));
        }

        $parts = preg_split('/\s+/', trim($this->name)) ?: [];
        $first = mb_substr($parts[0] ?? '', 0, 1);
        $last = count($parts) > 1 ? mb_substr(end($parts), 0, 1) : '';

        return mb_strtoupper($first.$last);
    }
}
