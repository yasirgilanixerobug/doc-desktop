<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentStatus extends Model
{
    use HasFactory;

    public const PENDING_APPROVAL = ['id' => 1, 'name' => 'Pending'];
    public const COMPLETE = ['id' => 2, 'name' => 'Complete'];
    public const CANCELLED_BY_PROVIDER = ['id' => 3, 'name' => 'Cancelled By Provider'];
    public const NO_SHOW = ['id' => 4, 'name' => 'No Show'];
    public const CONFIRMED = ['id' => 5, 'name' => 'Confirmed'];
    public const CANCELLED_BY_PATIENT = ['id' => 6, 'name' => 'Cancelled By Patient'];
}
