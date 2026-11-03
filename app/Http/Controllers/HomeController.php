<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Project;
use App\Models\Skill;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $visibleIds = Profile::visible()->pluck('id');

        $stats = [
            'estudiantes' => $visibleIds->count(),
            'proyectos' => Project::whereIn('profile_id', $visibleIds)->count(),
            'habilidades' => Skill::whereIn('profile_id', $visibleIds)->distinct()->count('name'),
            'disponibles' => Profile::visible()->where('available', true)->count(),
        ];

        $featured = Profile::visible()
            ->with(['user', 'skills'])
            ->withCount('projects')
            ->latest('updated_at')
            ->take(6)
            ->get();

        $topSkills = Skill::whereIn('profile_id', $visibleIds)
            ->select('name', DB::raw('COUNT(*) as total'))
            ->groupBy('name')
            ->orderByDesc('total')
            ->take(12)
            ->get();

        return view('home', compact('stats', 'featured', 'topSkills'));
    }
}
