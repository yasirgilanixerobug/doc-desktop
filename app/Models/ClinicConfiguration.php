<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class ClinicConfiguration extends Model
{
    use HasFactory, LogsActivity;

    /**
     * @return LogOptions
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->setDescriptionForEvent(fn(string $eventName) => "This model has been {$eventName}")
            ->useLogName('clinic configuration')
            ->dontSubmitEmptyLogs()
            ->logOnly(['is_send_email', 'is_send_sms', 'clinic_id']);
        // Chain fluent methods for configuration options
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'clinic_id',
        'is_send_sms',
        'is_send_email',
        'background_color',
        'color',
    ];
}
