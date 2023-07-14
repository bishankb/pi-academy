<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;
use Carbon\Carbon;

class Meeting extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'topic',
		'english_meeting_date',
		'nepali_meeting_date',
		'meeting_start_time',
		'meeting_end_time',
		'discussed',
        'meeting_file_id',
        'created_by',
        'updated_by'
    ];

    public function scopeSort($query, $filter)
    {
        if ($filter) {
           if($filter == "meetingDate-low-high") {
                return $query->orderBy('nepali_meeting_date', 'asc')->orderBy('meeting_start_time', 'asc');
            } elseif ($filter == "meetingDate-high-low") {
                return $query->orderBy('nepali_meeting_date', 'desc')->orderBy('meeting_start_time', 'desc');
            }
        }

        return $query;
    }

    public function scopeMeetingDateToFromSearch($query, $from_meetingDate, $till_meetingDate)
    {   
        if($from_meetingDate && $till_meetingDate) {
             $query->whereBetween('nepali_meeting_date', [Carbon::parse($from_meetingDate) , Carbon::parse($till_meetingDate)]);
        } elseif ($from_meetingDate && !$till_meetingDate) {
            $query = $query->where('nepali_meeting_date', '>=', Carbon::parse($from_meetingDate));
        } elseif (!$from_meetingDate && $till_meetingDate) {
            $query = $query->where('nepali_meeting_date', '<=', Carbon::parse($till_meetingDate));
        }
        return $query;
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('topic', 'like', '%' . $search . '%');
    }

    public function file()
    {
        return $this->belongsTo(Media::class, 'meeting_file_id');
    }
}
