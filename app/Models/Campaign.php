<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'end_date', 'uuid',
    ];

    protected $casts = [
        'end_date' => 'date',
    ];

    public function steps()
    {
        return $this->hasMany(Step::class);
    }

    public function participations()
    {
        return $this->hasMany(Participation::class);
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }
}
