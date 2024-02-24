<?php

// app/Models/Step.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Step extends Model
{
    protected $fillable = [
        'title', 'campaign_id', 'order_num', 'fileName',
    ];

    public function campaign(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    public function fields(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(StepField::class);
    }
}

