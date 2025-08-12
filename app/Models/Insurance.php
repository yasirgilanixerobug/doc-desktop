<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insurance extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ins_front',
        'ins_back',
        'ins_document',
        'userable_type',
        'userable_id',
    ];


    public function insurance()
    {
        return $this->morphTo();
    }

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getInsFrontFullPathAttribute(): string
    {
        return public_path().'/'."{$this->ins_front}";
    }

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getInsBackFullPathAttribute(): string
    {
        return public_path().'/'."{$this->ins_back}";
    }

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getInsDocumentFullPathAttribute(): string
    {
        return public_path().'/'."{$this->ins_document}";
    }
}
