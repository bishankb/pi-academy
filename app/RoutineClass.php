<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;
use Carbon\Carbon;

class RoutineClass extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'class_time_id',
        'routine_id',
        'teacher_id',
		'subject',
		'topic_taught',
		'is_empty',
		'created_by',
		'updated_by'
    ];

    public function routineClassTime()
    {
        return $this->belongsTo(RoutineClassTime::class, 'class_time_id');
    }

    public function routine()
    {
        return $this->belongsTo(Routine::class, 'routine_id');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function scopeGroupFilter($query, $filter)
    {
        if ($filter) {
            return $query->whereHas('routineClassTime', function ($q) use ($filter) {
                        $q->whereHas('routineGroup', function ($r) use ($filter) {
                            $r->where('name', $filter);
                        });
                    });
        }

        return $query;
    }

    public function scopeSubjectFilter($query, $filter)
    {
        if ($filter) {
            return $query->where('subject', array_flip(\App\ExaminationQuestion::Subjects)[$filter]);
        }

        return $query;
    }

    public function scopeSearch($query, $search)
    {
        return $query->whereHas('routineClassTime', function ($r) use ($search) {
                        $r->whereHas('routineGroup', function ($s) use ($search) {
                            $s->where('name', 'like', '%' . $search . '%');
                        });
                    });
    }

    public function scopeRoutineDateSearch($query, $routine_date)
    {   
        if($routine_date) {
            $query->whereHas('routine', function($q) use ($routine_date) {
                $q->where('nepali_routine_date', $routine_date);
            });
        }
        return $query;
    }

    public function scopeRoutineDateToFromSearch($query, $from_routineDate, $till_routineDate)
    {   
        if($from_routineDate && $till_routineDate) {
            $query->whereHas('routine', function($q) use($from_routineDate, $till_routineDate) {
                $q->whereBetween('nepali_routine_date', [Carbon::parse($from_routineDate) , Carbon::parse($till_routineDate)]);
            });
        } elseif ($from_routineDate && !$till_routineDate) {
            $query->whereHas('routine', function($q) use($from_routineDate, $till_routineDate) {
                $q->where('nepali_routine_date', '>=', Carbon::parse($from_routineDate));
            });
        } elseif (!$from_routineDate && $till_routineDate) {
            $query->whereHas('routine', function($q) use($from_routineDate, $till_routineDate) {
                $q->where('nepali_routine_date', '<=', Carbon::parse($till_routineDate));
            });
        }
        return $query;
    }
}