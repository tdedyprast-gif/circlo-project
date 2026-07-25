<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use App\Models\Enrollment;
use App\Models\CourseSession;

class StudentLmsWidget extends Widget
{
    protected string $view = 'filament.widgets.student-lms-widget';

    // Agar widget memenuhi lebar layar dashboard
    protected int | string | array $columnSpan = 'full';

    public array $sessionData = [];

    public function mount(): void
    {
        $enrollment = Enrollment::where('user_id', auth()->id())->first();

        if (!$enrollment) return;

        // Ambil sesi aktif/terakhir yang belum diselesaikan student
        $session = CourseSession::where('course_id', $enrollment->course_id)
            ->with([
                'materials.progressRecords' => fn($q) => $q->where('enrollment_id', $enrollment->id),
                'assignments.submissions' => fn($q) => $q->where('enrollment_id', $enrollment->id),
            ])
            ->first();

        if ($session) {
            $this->sessionData = [
                'id' => $session->id,
                'title' => $session->title,
                'materials' => $session->materials->map(fn($m) => [
                    'id' => $m->id,
                    'title' => $m->title,
                    'type' => $m->type?->value ?? 'text',
                    'content' => $m->content,
                    'body_text' => $m->body_text,
                    'is_completed' => $m->progressRecords->first()?->is_completed ?? false,
                ]),
                'assignments' => $session->assignments->map(fn($a) => [
                    'id' => $a->id,
                    'title' => $a->title,
                    'description' => $a->description,
                    'due_date' => $a->due_date?->format('d M Y, H:i'),
                    'max_score' => $a->max_score,
                    'submission' => $a->submissions->first() ? [
                        'file_path' => $a->submissions->first()->file_path,
                        'notes' => $a->submissions->first()->notes,
                        'submitted_at' => $a->submissions->first()->submitted_at?->format('d M Y H:i'),
                        'grade' => $a->submissions->first()->grade,
                        'feedback' => $a->submissions->first()->feedback,
                    ] : null,
                ]),
            ];
        }
    }
}
