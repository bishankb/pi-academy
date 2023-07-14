<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExaminationResult extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'student_id',
       'question_set_id',
       'attempted_1_mark',
       'attempted_2_mark',
       'correct_1_mark',
       'correct_2_mark',
       'attempted',
       'score',
       'attempted_questions',
       'choosen_answers',
    ];

    protected $casts = [
      'attempted_questions' => 'array',
      'choosen_answers' => 'array',
    ];

    public function scopeSort($query, $filter)
    {
        if ($filter) {
            if ($filter == "set-low-high") {
                	$query->orderBy('question_set_id', 'asc');
            } elseif($filter == "set-high-low") {
                	$query->orderBy('question_set_id', 'desc');
            } elseif($filter == "attempted-low-high") {
                  $query->orderBy('attempted', 'asc');
            } elseif($filter == "attempted-high-low") {
                  $query->orderBy('attempted', 'desc');
            } elseif($filter == "score-low-high") {
                  $query->orderBy('score', 'asc');
            } elseif($filter == "score-high-low") {
                  $query->orderBy('score', 'desc');
            }
        }

        return $query;
    }

    public function scopeSetFilter($query, $filter)
    {
        if ($filter) {
            return $query->whereHas('set', function ($q) use ($filter) {
                        $q->where('name', $filter);
                    });
        }

        return $query;
    }

    public function set()
    {
        return $this->belongsTo(QuestionSet::class, 'question_set_id');
    }

    public function student()
    {
        return $this->belongsTo(StudentRegistration::class, 'student_id');
    }
}