<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\BaseModel;
use Carbon\Carbon;

class Attendence extends BaseModel
{
   /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'staff_id',
        'english_attendence_date',
        'nepali_attendence_date',
		'has_taken_leave',
		'leave_reason',
		'is_holiday',
		'holiday_reason',
		'arrival_time',
		'departure_time',
        'has_taken_gap',
        'gap_departure_time',
        'gap_arrival_time',
        'gap_reason',
        'worked_hour',
		'created_by',
		'updated_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    public function scopeSort($query, $filter)
    {
        if ($filter) {
            if($filter == "attendenceDate-low-high") {
                return $query->orderBy('nepali_attendence_date', 'asc')->orderBy('arrival_time', 'asc');
            } elseif ($filter == "attendenceDate-high-low") {
                return $query->orderBy('nepali_attendence_date', 'desc')->orderBy('arrival_time', 'desc');
            }
        }

        return $query;
    }

    public function scopeAttendenceDateSearch($query, $from_attendenceDate, $till_attendenceDate)
    {   
        if($from_attendenceDate && $till_attendenceDate) {
             $query->whereBetween('nepali_attendence_date', [Carbon::parse($from_attendenceDate) , Carbon::parse($till_attendenceDate)]);
        } elseif ($from_attendenceDate && !$till_attendenceDate) {
            $query = $query->where('nepali_attendence_date', '>=', Carbon::parse($from_attendenceDate));
        } elseif (!$from_attendenceDate && $till_attendenceDate) {
            $query = $query->where('nepali_attendence_date', '<=', Carbon::parse($till_attendenceDate));
        }
        return $query;
    }

    public function scopeAttendenceStatusFilter($query, $filter)
    {
        if ($filter == 'Present') {
            return $query->where('has_taken_leave', 0)->where('is_holiday', 0);
        } elseif ($filter == 'On Leave') {
            return $query->where('has_taken_leave', 1);
        } elseif ($filter == 'On Holiday') {
            return $query->where('is_holiday', 1);
        }
        return $query;
    }
}
