<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StepField extends Model
{
    use HasFactory;
    protected $fillable = [
        'step_id', 'input',
    ];

    protected array $availableInputs = [
        'salutation',
        'firstname',
        'lastname',
        'email',
        'date_of_birth',
        'phone',
        'street',
        'postal_code',
        'city',
        'country',
    ];
}
