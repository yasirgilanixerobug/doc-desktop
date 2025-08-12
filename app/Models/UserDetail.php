<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'user_id',
        'phone',
        'home',
        'office',
        'fax',
        'about',
        'gender_id',
        'image',
        'state',
        'city',
        'address',
        'zip_code',
        'dob',
        'location_id',
    ];

    /**
     * @param $value
     * @return string
     */
    public function getImageAttribute($value): string
    {
        $placeholderImageName = ($this->gender_id === Gender::FEMALE) ? config('custom.provider_female_placeholder') : config('custom.provider_male_placeholder');
        //$placeholderImageName = '/clinic-assets/dist/img/user1-128x128.jpg';
        $image = ($value) ?? $placeholderImageName;

        return "{$image}";
    }

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getFullAddressAttribute(): string
    {
        return "{$this->address} {$this->city} {$this->state} {$this->zip_code}";
    }

    /**
     * @param $value
     * @return string
     */
    public function getPhoneAttribute($value): string
    {
        $number = explode('+1', $value);
        $number = ($number[1]) ?? null;
        return "{$number}";
    }

    /**
     * @param $value
     * @return string
     */
    public function getHomeAttribute($value): string
    {
        $number = explode('+1', $value);
        $number = ($number[1]) ?? null;
        return "{$number}";
    }

    /**
     * @param $value
     * @return string
     */
    public function getOfficeAttribute($value): string
    {
        $number = explode('+1', $value);
        $number = ($number[1]) ?? null;
        return "{$number}";
    }

    /**
     * @param $value
     * @return string
     */
    public function getFaxAttribute($value): string
    {
        $number = explode('+1', $value);
        $number = ($number[1]) ?? null;
        return "{$number}";
    }
}
