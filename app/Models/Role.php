<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    const ADMIN = 1;
    const OWNER = 2;
    const PROVIDER = 3;
    const OFFICE = 4;
    const RECEPTIONIST = 5;
    const OTHER_STAFF = 6;
    const PATIENT = 7;
}
