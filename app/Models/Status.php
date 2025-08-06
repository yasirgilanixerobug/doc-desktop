<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    public const ACTIVE = 1;
    public const BLOCK = 2;
    public const TEMPORARY_BLOCK = 3;
}
