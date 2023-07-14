<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;

class RoutineGroup extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'shift',
        'order',
		'description',
		'created_by',
		'updated_by',
    ];

    const Shift = [
        'Morning',
        'Day',
    ];

    public function scopeShiftFilter($query, $filter)
    {
        if ($filter) {
            return $query->where('shift', array_flip(self::Shift)[$filter]);           
        }

        return $query;
    }

    public function scopeSort($query, $filter)
    {
        if ($filter) {
            if($filter == "name-low-high") {
                return $query->orderBy('name', 'asc');
            } elseif ($filter == "name-high-low") {
                return $query->orderBy('name', 'desc');
            } elseif($filter == "order-low-high") {
                return $query->orderBy('order', 'asc');
            } elseif ($filter == "order-high-low") {
                return $query->orderBy('order', 'desc');
            }
        }

        return $query;
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', '%' . $search . '%');
    }

    public function routineClassTimes()
    {
        return $this->hasMany(RoutineClassTime::class, 'group_id');
    }
}
