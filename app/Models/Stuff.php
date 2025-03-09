<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stuff extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'position',
        'start_from',
        'contact_normal',
        'address',
        'salary_wages',
        'benifits',
        'vacation_peroid',
        'training_records',
        'contact_emergency',
        'notes'
    ];
}
