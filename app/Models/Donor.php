<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Donor extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'organization_name',
        'type',
        'contact_person_name',
        'contact_email',
    ];

    /**
     * Relasi ke Model Grant (1 Donor punya Banyak Grant)
     */
    public function grants(): HasMany
    {
        return $this->hasMany(Grant::class);
    }
}
