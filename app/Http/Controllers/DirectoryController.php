<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DirectoryController extends Controller
{
    public function index(Request $request): View
    {
        $query = Profile::visible()
            ->with(['user', 'skills'])
            ->withCount('projects');

        $q = trim((string) $request->input('q'));

        if ($q !== '') {
            $query->where(function (Builder $w) use ($q) {
                $w->whereHas('user', fn (Builder $u) => $u->where('name', 'like', "%{$q}%"))
                    ->orWhere('headline', 'like', "%{$q}%")
                    ->orWhereHas('skills', fn (Builder $s) => $s->where('name', 'like', "%{$q}%"))
                    ->orWhereHas('projects', fn (Builder $p) => $p->where('technologies', 'like', "%{$q}%"));
            });
        }

        if ($request->filled('carrera') && in_array($request->input('carrera'), Profile::CARRERAS, true)) {
            $query->where('carrera', $request->input('carrera'));
        }

        if ($request->filled('sede') && in_array($request->input('sede'), Profile::SEDES, true)) {
            $query->where('sede', $request->input('sede'));
        }

        if ($request->boolean('disponible')) {
            $query->where('available', true);
        }

        $profiles = $query->latest('updated_at')->paginate(9)->withQueryString();

        return view('directory.index', [
            'profiles' => $profiles,
            'carreras' => Profile::CARRERAS,
            'sedes' => Profile::SEDES,
        ]);
    }

    public function show(Request $request, Profile $profile): View
    {
        $profile->load(['user', 'skills', 'projects']);

        $viewer = $request->user();
        $isOwner = $viewer && $viewer->id === $profile->user_id;
        $canSee = $profile->isVisible() || $isOwner || ($viewer && $viewer->isAdmin());

        abort_unless($canSee, 404);

        return view('directory.show', compact('profile', 'isOwner'));
    }
}
