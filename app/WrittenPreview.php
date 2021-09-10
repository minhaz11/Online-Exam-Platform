<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WrittenPreview extends Model
{
    protected $guarded = [];

    public function exam()
    {
           return $this->belongsTo(Exam::class,'exam_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function writtenQuestion()
    {
        return $this->belongsTo(Questions::class,'question_id');
    }
    
    
}
