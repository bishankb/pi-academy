<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;
use Carbon\Carbon;

class Routine extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'group_id',
        'english_routine_date',
		'nepali_routine_date',
		'created_by',
		'updated_by'
    ];

    public function routineGroup()
    {
        return $this->belongsTo(RoutineGroup::class, 'group_id');
    }

    public function routineClass()
    {
        return $this->hasMany(RoutineClass::class, 'routine_id')->withTrashed();
    }

    public function scopeSort($query, $filter)
    {
        if ($filter) {
           if($filter == "routineDate-low-high") {
                return $query->orderBy('nepali_routine_date', 'asc');
            } elseif ($filter == "routineDate-high-low") {
                return $query->orderBy('nepali_routine_date', 'desc');
            }
        }

        return $query;
    }

    public function scopeSearch($query, $search)
    {
        return $query->whereHas('routineClass', function ($r) use ($search) {
                        $r->whereHas('teacher', function ($s) use ($search) {
                            $s->where('name', 'like', '%' . $search . '%');
                        });
                    });
    }

    public function scopeRoutineDateSearch($query, $routine_date)
    {   
        if($routine_date) {
             $query->where('nepali_routine_date', $routine_date);
        }
        return $query;
    }

    public function scopeRoutineDateToFromSearch($query, $from_routineDate, $till_routineDate)
    {   
        if($from_routineDate && $till_routineDate) {
             $query->whereBetween('nepali_routine_date', [Carbon::parse($from_routineDate) , Carbon::parse($till_routineDate)]);
        } elseif ($from_routineDate && !$till_routineDate) {
            $query = $query->where('nepali_routine_date', '>=', Carbon::parse($from_routineDate));
        } elseif (!$from_routineDate && $till_routineDate) {
            $query = $query->where('nepali_routine_date', '<=', Carbon::parse($till_routineDate));
        }
        return $query;
    }

   /* public function scopeGroupFilter($query, $filter)
    {
        if ($filter) {
            return $query->whereHas('routineGroup', function ($q) use ($filter) {
                        $q->where('name', $filter);
                    });
        }

        return $query;
    }*/

    /**
     * Delete the associated relation
    */
    protected static function boot() {
        parent::boot();
        
        static::deleting(function($routine) {
            if ($routine->isForceDeleting()) {
                $routine->routineClass()->withTrashed()->forceDelete();
            } else {
                $routine->routineClass()->delete();
            }
        });

        static::restoring(function ($routine) {
            $routine->routineClass()->withTrashed()->restore();
        });
    }
}
