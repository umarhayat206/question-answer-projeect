<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    //
    
    public function question()
    {
        return $this->belongsTo('App\Question');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }
    public static function boot()
    {
        parent::boot();
        static::created(function($answer){
            $answer->question->increment('answers_count');
            $answer->question->save();
        });
        static::deleted(function($answer){

            $question=$answer->question;
            $question->decrement('answers_count');
            if($question->best_answer_id===$answer->id)
            {
                $question->best_answer_id=NULL;
                $question->save();
            }
            
        });
    }
    public function getstatusAttribute()
    {
        return $this->id===$this->question->best_answer_id ? 'vote-accepted':'';
    }
    
}
