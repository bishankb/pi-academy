<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;
use Carbon\Carbon;

class RoutineClassTime extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'group_id',
		'class_start_time',
		'class_end_time',
		'order',
		'created_by',
		'updated_by'
    ];

    public function routineGroup()
    {
        return $this->belongsTo(RoutineGroup::class, 'group_id')->withTrashed();
    }

    public function routineClass()
    {
        return $this->hasOne(RoutineClass::class, 'class_time_id')->withTrashed();
    }

    /**
     * Delete the associated relation
    */
    protected static function boot() {
        parent::boot();
        
        static::deleting(function($routine_class_time) {
            if ($routine_class_time->isForceDeleting()) {
                $routine_class_time->routineClass()->withTrashed()->forceDelete();
            } else {
                $routine_class_time->routineClass()->delete();
            }
        });

        static::restoring(function ($routine_class_time) {
            $routine_class_time->routineClass()->withTrashed()->restore();
        });
    }
}
