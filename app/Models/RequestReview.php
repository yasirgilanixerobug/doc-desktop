<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class RequestReview extends Model
{
    public const NOT_SEND = 0;
    public const SEND = 1;
    public const COMPLAIN = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'clinic_id',
        'patient',
        'dob',
        'mobile_phone',
        'appointment_date',
        'provider',
        'location',
        'review_url',
        'sms_status',
        'sms_status_message',
        'slug',
    ];

    use HasFactory;

    /**
     * Get the post that owns the comment.
     */
    public function clinic(): HasOne
    {
        return $this->hasOne(Clinic::class, 'id', 'clinic_id');
    }
}
