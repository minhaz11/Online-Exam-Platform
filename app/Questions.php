<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Questions extends Model
{
    protected $guarded = [];

    public function exam()
    {
        return $this->belongsTo(Exam::class,'exam_id');
    }

    public function options()
    {
        return $this->hasMany(Options::class,'question_id');
    }

    

    
}
