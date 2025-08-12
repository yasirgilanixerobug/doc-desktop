<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppBookingChannel extends Model
{
    use HasFactory;


    public const WEBSITE = 1;
    public const APP = 2;
}
