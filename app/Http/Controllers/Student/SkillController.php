<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Skill;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SkillController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $profile = $request->user()->profile;

        if ($profile->skills()->count() >= 20) {
            return back()->with('error', 'Puedes registrar un máximo de 20 habilidades.');
        }

        $data = $request->validate([
            'name' => [
                'required', 'string', 'max:50',
                Rule::unique('skills', 'name')->where('profile_id', $profile->id),
            ],
            'level' => ['required', 'integer', Rule::in(array_keys(Skill::LEVELS))],
        ], [
            'name.unique' => 'Ya tienes registrada esa habilidad.',
        ]);

        $profile->skills()->create([
            'name' => trim($data['name']),
            'level' => $data['level'],
        ]);

        ActivityLog::record('habilidad_agregada', $request->user(), $data['name']);

        return back()->with('success', 'Habilidad agregada.');
    }

    public function destroy(Request $request, Skill $skill): RedirectResponse
    {
        abort_unless($skill->profile_id === $request->user()->profile->id, 403);

        ActivityLog::record('habilidad_eliminada', $request->user(), $skill->name);
        $skill->delete();

        return back()->with('success', 'Habilidad eliminada.');
    }
}
