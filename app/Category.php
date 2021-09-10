<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }
}


