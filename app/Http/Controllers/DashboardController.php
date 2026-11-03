<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Skill;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View|RedirectResponse
    {
        $user = $request->user();

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        $profile = $user->profile ?? $user->profile()->create([
            'slug' => Profile::uniqueSlug($user->name),
            'is_public' => true,
            'available' => true,
        ]);

        $profile->load(['skills', 'projects']);

        return view('student.dashboard', [
            'user' => $user,
            'profile' => $profile,
            'completion' => $profile->completion(),
            'levels' => Skill::LEVELS,
        ]);
    }
}
