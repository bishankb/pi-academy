<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\BaseModel;
use Carbon\Carbon;

class ExaminationQuestion extends BaseModel
{
   /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'question_set_id',
    	'subject',
		'marks',
		'question',
		'option1',
		'option2',
		'option3',
		'option4',
		'correct_answer',
		'solution',
		'created_by',
		'updated_by'
    ];

	const Subjects = [
        'Aptitude',
        'Chemistry',
        'English',
        'Math',
        'Physics'
    ];

    const Marks = [
        '1 Mark',
        '2 Marks'
    ];

    const Options = [
        'Option 1',
        'Option 2',
        'Option 3',
        'Option 4',
    ];

    public function scopeSearch($query, $search)
    {
        return $query->where('question', 'like', '%' . $search . '%');
    }

    public function scopeSubjectFilter($query, $filter)
    {
        if ($filter) {
            return $query->where('subject', array_flip(self::Subjects)[$filter]);
        }

        return $query;
    }

    public function scopeMarksFilter($query, $filter)
    {
        if ($filter) {
            return $query->where('marks', array_flip(self::Marks)[$filter]);
        }

        return $query;
    }

    public function set()
    {
        return $this->belongsTo(QuestionSet::class, 'question_set_id');
    }
}
