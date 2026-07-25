<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'deleted_at' => 'datetime',
        ];
    }

    public function grant(): BelongsTo
    {
        return $this->belongsTo(Grant::class);
    }

    public function sessions(): HasMany
    {
        return $this->hasMany(CourseSession::class)->orderBy('sort_order');
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    // Mengambil seluruh materi dalam satu course lewat session
    public function materials(): HasManyThrough
    {
        return $this->hasManyThrough(Material::class, CourseSession::class);
    }
}
