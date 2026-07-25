<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ImpactLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'impact_indicator_id',
        'user_id',
        'verified_by_facilitator_id',
        'pre_program_value',
        'post_program_value',
        'evidence_file_path',
        'verified_at',
    ];

    protected function casts(): array
    {
        return [
            'pre_program_value' => 'decimal:2',
            'post_program_value' => 'decimal:2',
            'verified_at' => 'datetime',
        ];
    }

    public function indicator(): BelongsTo
    {
        return $this->belongsTo(ImpactIndicator::class, 'impact_indicator_id');
    }

    public function beneficiary(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function facilitator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by_facilitator_id');
    }
}
