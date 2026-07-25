<?php

namespace App\Models;

use App\Enums\MaterialType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Material extends Model
{
    protected $guarded = ['id'];

    /**
     * Cast atribut ke tipe data / Enum spesifik
     */
    protected function casts(): array
    {
        return [
            'type' => MaterialType::class,
            'is_optional' => 'boolean',
            'order' => 'integer',
        ];
    }

    public function session(): BelongsTo
    {
        return $this->belongsTo(CourseSession::class, 'course_session_id');
    }

    public function progressRecords(): HasMany
    {
        return $this->hasMany(MaterialProgress::class);
    }

    public function courseSession(): BelongsTo
    {
        return $this->belongsTo(CourseSession::class, 'course_session_id');
    }
}