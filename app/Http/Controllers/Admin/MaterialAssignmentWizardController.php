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
            // Step 1: Material
            'course_session_id' => 'required|exists:course_sessions,id',
            'material_title' => 'required|string|max:255',
            'material_type' => ['required', new Enum(MaterialType::class)],
            'content' => 'nullable|string',
            'body_text' => 'nullable|string',
            'sort_order' => 'required|integer',
            'is_optional' => 'nullable|boolean',

            // Step 2: Assignment Toggle & Fields
            'has_assignment' => 'nullable|boolean',
            'assignment_title' => 'required_if:has_assignment,1|nullable|string|max:255',
            'assignment_description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'max_score' => 'nullable|integer|min:1',
            'allow_offline_submission' => 'nullable|boolean',
        ]);

        DB::transaction(function () use ($validated, $request) {
            // 1. Simpan Material
            Material::create([
                'course_session_id' => $validated['course_session_id'],
                'title' => $validated['material_title'],
                'content_type' => $validated['material_type'],
                'content' => $validated['content'] ?? null,
                'body_text' => $validated['body_text'] ?? null,
                'sort_order' => $validated['sort_order'],
                'is_optional' => $request->has('is_optional'),
            ]);

            // 2. Simpan Assignment jika dicentang
            if ($request->has('has_assignment') && $request->input('has_assignment') == '1') {
                Assignment::create([
                    'course_session_id' => $validated['course_session_id'],
                    'title' => $validated['assignment_title'],
                    'description' => $validated['assignment_description'] ?? null,
                    'due_date' => $validated['due_date'] ?? null,
                    'max_score' => $validated['max_score'] ?? 100,
                    'allow_offline_submission' => $request->has('allow_offline_submission'),
                ]);
            }
        });

        return redirect()->to('/philanthropy/materials')
            ->with('success', "Materi '{$validated['material_title']}' dan Tugas berhasil ditambahkan!");
    }
}
