<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class UserOrgan extends Pivot
{
    use HasFactory;

    protected $table = 'user_organs';

    protected $fillable = [
        'user_id',
        'organ_id',
        'hospital_id',
        'type',
        'status',
        'matched_at',
        'completed_at',
    ];

    /**
     * User associated with this organ relationship.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Organ associated with this relationship.
     */
    public function organ()
    {
        return $this->belongsTo(Organ::class);
    }

    /**
     * Hospital associated with this organ relationship.
     */
    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }
}
