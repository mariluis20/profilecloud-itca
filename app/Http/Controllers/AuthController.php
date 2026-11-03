<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $key = Str::lower($credentials['email']).'|'.$request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);

            throw ValidationException::withMessages([
                'email' => "Demasiados intentos. Intenta de nuevo en {$seconds} segundos.",
            ]);
        }

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            RateLimiter::hit($key, 60);
            ActivityLog::record('login_fallido', null, 'Correo: '.$credentials['email']);

            throw ValidationException::withMessages([
                'email' => 'Las credenciales no coinciden con nuestros registros.',
            ]);
        }

        RateLimiter::clear($key);

        if (! $request->user()->is_active) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            throw ValidationException::withMessages([
                'email' => 'Tu cuenta está desactivada. Contacta al administrador.',
            ]);
        }

        $request->session()->regenerate();
        ActivityLog::record('login', $request->user());

        return redirect()->intended(route('dashboard'))
            ->with('success', '¡Bienvenido de nuevo, '.$request->user()->name.'!');
    }

    public function showRegister(): View
    {
        return view('auth.register', ['carreras' => Profile::CARRERAS]);
    }

    public function register(Request $request): RedirectResponse
    {
        $data = $request->validate(User::nameRules() + [
            'email' => ['required', 'string', 'email', 'max:150', 'unique:users,email'],
            'carrera' => ['required', Rule::in(Profile::CARRERAS)],
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()],
        ]);

        $parts = User::cleanNameParts($data);
        $fullName = User::fullName($parts);

        $user = DB::transaction(function () use ($data, $parts, $fullName) {
            $user = new User($parts + [
                'name' => $fullName,
                'email' => Str::lower($data['email']),
                'password' => $data['password'],
            ]);
            $user->role = User::ROLE_STUDENT;
            $user->is_active = true;
            $user->save();

            $user->profile()->create([
                'slug' => Profile::uniqueSlug($fullName),
                'carrera' => $data['carrera'],
                'headline' => 'Estudiante de '.$data['carrera'],
                'is_public' => true,
                'available' => true,
            ]);

            return $user;
        });

        Auth::login($user);
        $request->session()->regenerate();
        ActivityLog::record('registro', $user);

        return redirect()->route('dashboard')
            ->with('success', 'Tu cuenta fue creada. Completa tu perfil para que destaque.');
    }

    public function logout(Request $request): RedirectResponse
    {
        ActivityLog::record('logout', $request->user());

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Sesión cerrada correctamente.');
    }
}
