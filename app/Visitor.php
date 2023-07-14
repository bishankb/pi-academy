<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\BaseModel;
use Carbon\Carbon;

class Visitor extends BaseModel
{    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
		'college_name',
		'marks_obtained',
		'academic_status',
		'english_visited_date',
        'nepali_visited_date',
        'visited_time',
		'counselled_by',
		'is_registered',
		'is_accompanied',
		'accompanied_by',
		'interested_course',
        'interested_stream',
		'created_by',
		'updated_by'
    ];

    const AcademicStatus = [
    	'+2 Running',
    	'Passed'
    ];

    public function counselledBy () {
    	return $this->belongsTo(User::class, 'counselled_by');
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', '%' . $search . '%')
                    ->OrWhere('college_name', 'like', '%' . $search . '%')
                    ->OrWhereHas('counselledBy', function ($r) use ($search) {
                        $r->where('name', 'like', '%' . $search . '%');
                    });
    }

    public function scopeAcademicStatusFilter($query, $filter)
    {
        if ($filter) {
            return $query->where('academic_status', array_flip(self::AcademicStatus)[$filter]);           
        }

        return $query;
    }

    public function scopeRegisterStatusFilter($query, $filter)
    {
        if ($filter) {
            if ($filter == "Registered") {
                return $query->where('is_registered', 1);
            } else {
                return $query->where('is_registered', 0);
            }
            
        }

        return $query;
    }

    public function scopeInterestedCourseFilter($query, $filter)
    {
        if ($filter) {
            return $query->where('interested_course', array_flip(\App\ScholarshipTest::InterestedCourse)[$filter]);           
        }

        return $query;
    }

    public function scopeSort($query, $filter)
    {
        if ($filter) {
            if ($filter == "name-low-high") {
                return $query->orderBy('name', 'asc');
            } elseif($filter == "name-high-low") {
                return $query->orderBy('name', 'desc');
            } elseif($filter == "visitedPeriod-low-high") {
                return $query->orderBy('nepali_visited_date', 'asc')->orderBy('visited_time', 'asc');
            } elseif ($filter == "visitedPeriod-high-low") {
                return $query->orderBy('nepali_visited_date', 'desc')->orderBy('visited_time', 'desc');
            }
        }

        return $query;
    }

    public function scopeVisitedPeriodSearch($query, $from_visitedPeriod, $till_visitedPeriod)
    {   
        if($from_visitedPeriod && $till_visitedPeriod) {
             $query->whereBetween('nepali_visited_date', [Carbon::parse($from_visitedPeriod) , Carbon::parse($till_visitedPeriod)]);
        } elseif ($from_visitedPeriod && !$till_visitedPeriod) {
            $query = $query->where('nepali_visited_date', '>=', Carbon::parse($from_visitedPeriod));
        } elseif (!$from_visitedPeriod && $till_visitedPeriod) {
            $query = $query->where('nepali_visited_date', '<=', Carbon::parse($till_visitedPeriod));
        }
        return $query;
    }
}