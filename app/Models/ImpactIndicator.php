<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ImpactIndicator extends Model
{
    use HasFactory;

    protected $fillable = [
        'grant_id',
        'metric_name',
        'metric_type',
        'target_value',
    ];

    protected function casts(): array
    {
        return [
            'target_value' => 'decimal:2',
        ];
    }

    public function grant(): BelongsTo
    {
        return $this->belongsTo(Grant::class);
    }

    public function logs(): HasMany
    {
        return $this->hasMany(ImpactLog::class);
    }
}
