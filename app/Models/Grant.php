<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Grant extends Model
{
    use HasFactory;

    protected $fillable = [
        'donor_id',
        'grant_name',
        'code',
        'total_funding_amount',
        'cost_per_beneficiary_target',
        'target_beneficiaries_count',
        'start_date',
        'end_date',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'total_funding_amount' => 'decimal:2',
            'cost_per_beneficiary_target' => 'decimal:2',
        ];
    }

    public function donor(): BelongsTo
    {
        return $this->belongsTo(Donor::class);
    }

    public function cohorts(): HasMany
    {
        return $this->hasMany(Cohort::class);
    }
    
    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }

    public function impactIndicators(): HasMany
    {
        return $this->hasMany(ImpactIndicator::class);
    }


// Di dalam class Grant
protected function fullTitle(): Attribute
{
    return Attribute::make(
        get: function () {
            $donorName = $this->donor?->organization_name ? $this->donor->organization_name . ' - ' : ' ';
            $codeText = $this->code ? " ({$this->code})" : '';

            return "{$this->grant_name} - {$donorName}{$codeText}";
        }
    );
}
}
