<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Carbon;

class GuestUser extends Model
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
        'email',
        'dob',
        'phone',
        'home',
        'office',
        'fax',
        'state',
        'city',
        'address',
        'zip_code',
        'clinic_id',
    ];

    /**
     * @param $query
     * @param null $queryParam
     * @return mixed
     */
    public function scopeFilter($query, $queryParam = null)
    {
         $query->where(function ($query) use($queryParam) {
            $query->orWhereRaw("concat(first_name, ' ', last_name) like '" .$queryParam. "%' ")
                ->orWhere('email', 'LIKE', "{$queryParam}%")
                ->orWhere('phone', 'LIKE', "%{$queryParam}%");
        });
    }

    /**
     * @return MorphOne
     */
    public function pastAppointment(): MorphOne
    {
        return $this->morphOne(Appointment::class, 'userable')
            ->whereDate('date', '<',Carbon::today())
            ->orderBy('id', 'desc')
            ->with(['clinic', 'provider.userDetail', 'status', 'location']);
    }

    /**
     * @return MorphOne
     */
    public function upComingAppointment(): MorphOne
    {
        return $this->morphOne(Appointment::class, 'userable')
            ->whereDate('date', '>=',Carbon::today())
            ->with(['clinic', 'provider.userDetail', 'status', 'location']);
    }

    /**
     * @return MorphMany
     */
    public function pastAppointments(): MorphMany
    {
        return $this->morphMany(Appointment::class, 'userable')
            ->whereDate('date', '<',Carbon::today())
            ->orderBy('id', 'desc');
    }

    /**
     * @return MorphMany
     */
    public function upComingAppointments(): MorphMany
    {
        return $this->morphMany(Appointment::class, 'userable')
            ->whereDate('date', '>=',Carbon::today());
    }

    /**
     * @return MorphMany
     */
    public function patientAppointments(): MorphMany
    {
        return $this->morphMany(Appointment::class, 'userable');
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
     * Get the user's full name.
     *
     * @return string
     */
    public function getShortNameAttribute(): string
    {
        $fullName = trim($this->first_name. ' '. $this->last_name);
        $fullName = explode(" ",$fullName);
        $totalString = count($fullName);
        $name = '';

        if ($totalString <= 2)
        {
            $firstName = ($this->last_name == ' ' || $this->last_name == null) ? ucwords($this->first_name) :  ucfirst(substr($this->first_name, 0, 1));
            $lastName = ($this->last_name != ' ' || $this->last_name != null) ? ucwords($this->last_name) : ' ' ;
            $name = $firstName. ' '. $lastName;
        } else {
            $lastIndex = $totalString - 1;
            foreach ($fullName as $key => $value) {
                if ($lastIndex === $key) {
                    $name .= ' '.ucfirst($value);
                } else {
                    $name .= ucfirst(substr($value, 0, 1));
                }
            }
        }

        return "{$name}";
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
     * @return string
     */
    public function getPhoneAttribute($value)
    {
        $number = explode('+1', $value);
        $number = ($number[1]) ?? null;
        return "{$number}";
    }

    /**
     * @return string
     */
    public function getHomeAttribute($value)
    {
        $number = explode('+1', $value);
        $number = ($number[1]) ?? null;
        return "{$number}";
    }

    /**
     * @return string
     */
    public function getOfficeAttribute($value)
    {
        $number = explode('+1', $value);
        $number = ($number[1]) ?? null;
        return "{$number}";
    }

    /**
     * @return string
     */
    public function getFaxAttribute($value)
    {
        $number = explode('+1', $value);
        $number = ($number[1]) ?? null;
        return "{$number}";
    }

    /**
     * @return string
     */
    public function getImageAttribute(): string
    {
        $placeholderImageName = '/clinic-assets/dist/img/user1-128x128.jpg';

        return "{$placeholderImageName}";
    }

    /**
     * Get the post's image.
     */
    public function appointment(): MorphOne
    {
        return $this->morphOne(Appointment::class, 'userable');
    }

    /**
     * Get the post that owns the comment.
     */
    public function clinic(): HasOne
    {
        return $this->hasOne(Clinic::class, 'id', 'clinic_id');
    }
}
