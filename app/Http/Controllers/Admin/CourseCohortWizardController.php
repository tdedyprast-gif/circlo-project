<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cohort;
use App\Models\Course;
use App\Models\Grant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CourseCohortWizardController extends Controller
{
    public function create()
    {
        // Tambahkan with('donor') agar data organisasi donor ikut terload efisien
        $grants = Grant::with('donor')
            ->orderBy('grant_name', 'asc')
            ->get();

        $facilitators = User::select('id', 'name')->orderBy('name', 'asc')->get();

        return view('admin.wizards.course-cohort', compact('grants', 'facilitators'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // Validation Step 1: Course
            'grant_id' => 'required|exists:grants,id',
            'course_title' => 'required|string|max:255',
            'course_description' => 'nullable|string',
            'course_status' => 'required|in:draft,published,archived',

            // Validation Step 2: Cohort
            'cohort_name' => 'required|string|max:255',
            'cohort_description' => 'nullable|string',
            'max_capacity' => 'nullable|integer|min:1',
            'facilitator_id' => 'nullable|exists:users,id',
        ]);

        $cohort = DB::transaction(function () use ($validated) {
            // 1. Simpan Course
            $course = Course::create([
                'grant_id' => $validated['grant_id'],
                'title' => $validated['course_title'],
                'slug' => Str::slug($validated['course_title']) . '-' . Str::random(5),
                'description' => $validated['course_description'],
                'status' => $validated['course_status'],
            ]);

            // 2. Simpan Cohort yang terhubung
            Cohort::create([
                'grant_id' => $validated['grant_id'],
                'course_id' => $course->id,
                'cohort_name' => $validated['cohort_name'],
                'description' => $validated['cohort_description'],
                'max_capacity' => $validated['max_capacity'] ?? null,
                'facilitator_id' => $validated['facilitator_id'] ?? null,
            ]);
        });
    return redirect()->to('/philanthropy/cohorts')
        ->with('success', "Master Course dan Cohort '{$validated['cohort_name']}' berhasil dibuat!");
    }
}
