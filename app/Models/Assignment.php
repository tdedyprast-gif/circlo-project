<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_session_id',
        'title',
        'description',
        'due_date',
        'max_score',
        'allow_offline_submission',
    ];

    protected function casts(): array
    {
        return [
            'due_date' => 'datetime',
            'max_score' => 'integer',
            'allow_offline_submission' => 'boolean',
        ];
    }

    public function courseSession(): BelongsTo
    {
        return $this->belongsTo(CourseSession::class, 'course_sessions_id');
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(AssignmentSubmission::class);
    }
}