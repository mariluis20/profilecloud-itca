<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    public const LABELS = [
        'login' => 'Inicio de sesión',
        'login_fallido' => 'Intento de acceso fallido',
        'logout' => 'Cierre de sesión',
        'registro' => 'Registro de cuenta',
        'perfil_actualizado' => 'Perfil actualizado',
        'habilidad_agregada' => 'Habilidad agregada',
        'habilidad_eliminada' => 'Habilidad eliminada',
        'proyecto_creado' => 'Proyecto creado',
        'proyecto_actualizado' => 'Proyecto actualizado',
        'proyecto_eliminado' => 'Proyecto eliminado',
        'usuario_activado' => 'Usuario activado',
        'usuario_desactivado' => 'Usuario desactivado',
        'rol_cambiado' => 'Rol cambiado',
    ];

    protected $fillable = [
        'user_id',
        'action',
        'detail',
        'ip_address',
        'user_agent',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getLabelAttribute(): string
    {
        return self::LABELS[$this->action] ?? $this->action;
    }

    public static function record(string $action, ?User $user = null, ?string $detail = null): void
    {
        static::create([
            'user_id' => $user?->id ?? auth()->id(),
            'action' => $action,
            'detail' => $detail ? mb_substr($detail, 0, 255) : null,
            'ip_address' => request()->ip(),
            'user_agent' => mb_substr((string) request()->userAgent(), 0, 255),
        ]);
    }
}
