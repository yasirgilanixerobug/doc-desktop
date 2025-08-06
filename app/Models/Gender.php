<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{
    use HasFactory;

    
    const MALE = 1;
    const FEMALE = 2;
    const OTHER = 3;
}
