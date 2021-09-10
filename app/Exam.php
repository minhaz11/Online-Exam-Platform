<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Console\Question\Question;

class Exam extends Model
{
    protected $guarded = [];

    public function subject()
    {
        return $this->belongsTo(Subject::class,'subject_id');
    }

    public function questions()
    {
        return $this->hasMany(Questions::class,'exam_id');
    }

    public function results()
    {
        return $this->hasMany(Result::class,'exam_id');
    }

    public function written()
    {
        return $this->hasMany(WrittenPreview::class,'exam_id');
    }

    public function passmark()
    {
        return ($this->totalmark*$this->pass_percentage)/100;
    }
    
    public function totalWrittenMark($userid)
    {
        return WrittenPreview::where('user_id',$userid)->where('exam_id',$this->id)->sum('given_mark');
    }
    
    public function upcomming($examid)
    {
        return $this->where('id',$examid)->where('status',1)->where('start_date','>',\Carbon\Carbon::now()->toDateString())->first();
    }
}
