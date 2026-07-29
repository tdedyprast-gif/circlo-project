<?php

use App\Models\Assignment;
use App\Models\Course;
use App\Models\CourseSession;
use App\Models\Material;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;

uses(RefreshDatabase::class);

it('can create a material record from filament form', function () {
    $user = User::factory()->create();

    $course = Course::create([
        'grant_id' => null,
        'title' => 'Course Laravel',
        'slug' => 'course-laravel-' . uniqid(),
        'description' => 'Deskripsi course',
        'is_low_bandwidth_optimized' => true,
    ]);

    $session = CourseSession::create([
        'course_id' => $course->id,
        'title' => 'Session 1',
        'description' => 'Deskripsi sesi',
        'order' => 1,
        'is_active' => true,
    ]);

    actingAs($user);

    Livewire::test(\App\Filament\Resources\Materials\Pages\CreateMaterial::class)
        ->fillForm([
            'course_session_id' => $session->id,
            'title' => 'Pengenalan Laravel',
            'content_type' => 'TEXT',
            'body_text' => '<p>Isi materi pengenalan.</p>',
            'is_required' => true,
            'order' => 1,
            'has_assignment' => true,
            'assignment_title' => 'Tugas Minggu 1',
            'assignment_description' => 'Deskripsi tugas minggu 1',
            'due_date' => now()->addDay()->toDateTimeString(),
            'max_score' => 100,
            'allow_offline_submission' => true,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    assertDatabaseHas(Material::class, [
        'course_session_id' => $session->id,
        'title' => 'Pengenalan Laravel',
        'content_type' => 'TEXT',
        'is_required' => true,
        'order' => 1,
    ]);

    assertDatabaseHas(Assignment::class, [
        'course_sessions_id' => $session->id,
        'title' => 'Tugas Minggu 1',
        'description' => 'Deskripsi tugas minggu 1',
        'max_score' => 100,
        'allow_offline_submission' => true,
    ]);
});
