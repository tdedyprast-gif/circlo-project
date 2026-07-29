<?php

namespace App\Http\Controllers\Admin;

use App\Enums\MaterialType;
use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\CourseSession;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Enum;

class MaterialAssignmentWizardController extends Controller
{
    public function create()
    {
        $sessions = CourseSession::with('course')
            ->get()
            ->sortBy([
                fn($a, $b) => ($a->course->title ?? '') <=> ($b->course->title ?? ''),
                ['sort_order', 'asc'],
            ]);
        $materialTypes = MaterialType::cases();

        return view('admin.wizards.material-assignment', compact('sessions', 'materialTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_session_id' => 'required|exists:course_sessions,id',
            'material_title' => 'required|string|max:255',
            'material_type' => ['required', new Enum(MaterialType::class)],
            'content_url' => 'nullable|url|max:65535',
            'body_text' => 'nullable|string',
            'order' => 'required|integer|min:1',
            'is_required' => 'nullable|boolean',
            'has_assignment' => 'nullable|boolean',
            'assignment_title' => 'required_if:has_assignment,1|nullable|string|max:255',
            'assignment_description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'max_score' => 'nullable|integer|min:1',
            'allow_offline_submission' => 'nullable|boolean',
        ]);

        DB::transaction(function () use ($validated, $request) {
            Material::create([
                'course_session_id' => $validated['course_session_id'],
                'title' => $validated['material_title'],
                'content_type' => strtoupper($validated['material_type']->value),
                'content_url' => $validated['content_url'] ?? null,
                'body_text' => $validated['body_text'] ?? null,
                'is_required' => $request->boolean('is_required', true),
                'order' => $validated['order'],
            ]);

            if ($request->boolean('has_assignment')) {
                Assignment::create([
                    'course_session_id' => $validated['course_session_id'],
                    'title' => $validated['assignment_title'],
                    'description' => $validated['assignment_description'] ?? null,
                    'due_date' => $validated['due_date'] ?? null,
                    'max_score' => $validated['max_score'] ?? 100,
                    'allow_offline_submission' => $request->boolean('allow_offline_submission', true),
                ]);
            }
        });

        return redirect()->to('/philanthropy/materials')
            ->with('success', "Materi '{$validated['material_title']}' dan Tugas berhasil ditambahkan!");
    }
}
