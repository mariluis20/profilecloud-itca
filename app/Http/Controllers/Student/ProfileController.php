<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('student.profile-edit', [
            'user' => $request->user(),
            'profile' => $request->user()->profile,
            'carreras' => Profile::CARRERAS,
            'sedes' => Profile::SEDES,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();
        $profile = $user->profile;

        $data = $request->validate(User::nameRules() + [
            'headline' => ['nullable', 'string', 'max:150'],
            'bio' => ['nullable', 'string', 'max:2000'],
            'carrera' => ['required', Rule::in(Profile::CARRERAS)],
            'sede' => ['nullable', Rule::in(Profile::SEDES)],
            'ciclo' => ['nullable', 'integer', 'between:1,10'],
            'github_url' => ['nullable', 'url:https', 'max:255'],
            'linkedin_url' => ['nullable', 'url:https', 'max:255'],
            'website_url' => ['nullable', 'url:http,https', 'max:255'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $parts = User::cleanNameParts($data);
        $user->update($parts + ['name' => User::fullName($parts)]);

        if ($request->boolean('remove_photo') && $profile->photo_path) {
            Storage::disk('public')->delete($profile->photo_path);
            $profile->photo_path = null;
        }

        if ($request->hasFile('photo')) {
            if ($profile->photo_path) {
                Storage::disk('public')->delete($profile->photo_path);
            }
            $profile->photo_path = $request->file('photo')->store('profiles', 'public');
        }

        unset($data['first_name'], $data['middle_name'], $data['last_name'], $data['second_last_name'], $data['photo']);

        $profile->fill($data);
        $profile->is_public = $request->boolean('is_public');
        $profile->available = $request->boolean('available');
        $profile->save();

        ActivityLog::record('perfil_actualizado', $user);

        return redirect()->route('dashboard')->with('success', 'Perfil actualizado correctamente.');
    }
}
