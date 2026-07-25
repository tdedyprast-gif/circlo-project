<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'gender',
        'birth_date',
        'province_id',
        'regency_id',
        'district_id',
        'address_detail',
        'economic_status',
        'primary_occupation',
        'is_disabled',
        'disability_type',
    ];

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
            'is_disabled' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
