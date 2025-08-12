<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class StaffLocation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'staff_id',
        'location_id',
        'status_id',
    ];

    /**
     * Get the post that owns the comment.
     */
    public function staff(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'staff_id');
    }

    /**
     * Get the post that owns the comment.
     */
    public function location(): HasOne
    {
        return $this->hasOne(Location::class, 'id', 'location_id');
    }
}
