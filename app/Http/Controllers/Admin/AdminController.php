<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        $stats = [
            'usuarios' => User::count(),
            'estudiantes' => User::where('role', User::ROLE_STUDENT)->count(),
            'inactivos' => User::where('is_active', false)->count(),
            'publicos' => Profile::visible()->count(),
            'proyectos' => Project::count(),
            'habilidades' => Skill::count(),
            'fallidos' => ActivityLog::where('action', 'login_fallido')
                ->where('created_at', '>=', now()->subDay())->count(),
        ];

        $recentUsers = User::latest()->take(5)->get();
        $recentLogs = ActivityLog::with('user')->latest()->take(8)->get();

        return view('admin.dashboard', compact('stats', 'recentUsers', 'recentLogs'));
    }

    public function users(Request $request): View
    {
        $query = User::query()->with('profile');

        $q = trim((string) $request->input('q'));
        if ($q !== '') {
            $query->where(fn (Builder $w) => $w->where('name', 'like', "%{$q}%")->orWhere('email', 'like', "%{$q}%"));
        }

        if (in_array($request->input('rol'), [User::ROLE_ADMIN, User::ROLE_STUDENT], true)) {
            $query->where('role', $request->input('rol'));
        }

        if ($request->input('estado') === 'activos') {
            $query->where('is_active', true);
        } elseif ($request->input('estado') === 'inactivos') {
            $query->where('is_active', false);
        }

        $users = $query->orderBy('name')->paginate(15)->withQueryString();

        return view('admin.users', compact('users'));
    }

    public function toggle(Request $request, User $user): RedirectResponse
    {
        if ($user->id === $request->user()->id) {
            return back()->with('error', 'No puedes desactivar tu propia cuenta.');
        }

        $user->is_active = ! $user->is_active;
        $user->save();

        ActivityLog::record(
            $user->is_active ? 'usuario_activado' : 'usuario_desactivado',
            $request->user(),
            $user->email
        );

        return back()->with('success', $user->is_active ? 'Usuario activado.' : 'Usuario desactivado.');
    }

    public function role(Request $request, User $user): RedirectResponse
    {
        if ($user->id === $request->user()->id) {
            return back()->with('error', 'No puedes cambiar tu propio rol.');
        }

        $data = $request->validate([
            'role' => ['required', Rule::in([User::ROLE_ADMIN, User::ROLE_STUDENT])],
        ]);

        $user->role = $data['role'];
        $user->save();

        if ($user->isStudent() && ! $user->profile) {
            $user->profile()->create([
                'slug' => Profile::uniqueSlug($user->name),
                'is_public' => false,
                'available' => false,
            ]);
        }

        ActivityLog::record('rol_cambiado', $request->user(), $user->email.' → '.$user->role);

        return back()->with('success', 'Rol actualizado.');
    }

    public function logs(Request $request): View
    {
        $query = ActivityLog::with('user')->latest();

        if (array_key_exists((string) $request->input('accion'), ActivityLog::LABELS)) {
            $query->where('action', $request->input('accion'));
        }

        $logs = $query->paginate(25)->withQueryString();

        return view('admin.logs', [
            'logs' => $logs,
            'labels' => ActivityLog::LABELS,
        ]);
    }
}
