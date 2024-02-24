<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $fillable = [
        'title', 'end_date', 'uuid',
    ];

    protected $casts = [
        'end_date' => 'date',
    ];

    public function steps(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Step::class);
    }

    public function participations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Participation::class);
    }
}
