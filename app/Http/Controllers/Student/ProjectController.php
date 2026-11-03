<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function create(): View
    {
        return view('student.project-form', ['project' => new Project()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        $request->user()->profile->projects()->create($data);
        ActivityLog::record('proyecto_creado', $request->user(), $data['title']);

        return redirect()->route('dashboard')->with('success', 'Proyecto publicado.');
    }

    public function edit(Request $request, Project $project): View
    {
        $this->authorizeOwner($request, $project);

        return view('student.project-form', compact('project'));
    }

    public function update(Request $request, Project $project): RedirectResponse
    {
        $this->authorizeOwner($request, $project);

        $data = $this->validated($request);
        $project->update($data);
        ActivityLog::record('proyecto_actualizado', $request->user(), $project->title);

        return redirect()->route('dashboard')->with('success', 'Proyecto actualizado.');
    }

    public function destroy(Request $request, Project $project): RedirectResponse
    {
        $this->authorizeOwner($request, $project);

        ActivityLog::record('proyecto_eliminado', $request->user(), $project->title);
        $project->delete();

        return redirect()->route('dashboard')->with('success', 'Proyecto eliminado.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:120'],
            'description' => ['required', 'string', 'max:2000'],
            'technologies' => ['nullable', 'string', 'max:255'],
            'repo_url' => ['nullable', 'url:http,https', 'max:255'],
            'demo_url' => ['nullable', 'url:http,https', 'max:255'],
            'year' => ['nullable', 'integer', 'between:2000,2100'],
        ]);
    }

    private function authorizeOwner(Request $request, Project $project): void
    {
        abort_unless($project->profile_id === $request->user()->profile->id, 403);
    }
}
