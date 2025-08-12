<?php

namespace App\Traits;

trait WithWhereHas {

    public function scopeWithWhereHas($query, $relationship, $conditions)
    {
        $query->with($relationship, $conditions)
            ->whereHas($relationship, $conditions);
    }
}
