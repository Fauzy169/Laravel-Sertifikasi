<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'course',
        'duration',
        'date',
        'credential_number',
    ];

    protected $casts = [
        'date' => 'date',
    ];
}
