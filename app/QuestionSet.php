<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;

class QuestionSet extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
		'slug',
        'order',
		'description',
		'created_by',
		'updated_by',
    ];

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

    public function questions()
    {
        return $this->hasMany(ExaminationQuestion::class, 'question_set_id')->withTrashed();
    }

    public function examinationRecords()
    {
        return $this->hasMany(ExaminationResult::class, 'question_set_id');
    }

    public function paragraph()
    {
        return $this->hasOne(Paragraph::class, 'question_set_id')->withTrashed();
    }

    /**
     * Delete the associated relation
    */
    protected static function boot() {
        parent::boot();
        
        static::deleting(function($question_set) {
            if ($question_set->isForceDeleting()) {
                $question_set->questions()->withTrashed()->forceDelete();
                $question_set->paragraph()->withTrashed()->forceDelete();
            } else {
                $question_set->questions()->delete();
                $question_set->examinationRecords()->delete();
                $question_set->paragraph()->delete();
            }
        });

        static::restoring(function ($question_set) {
            $question_set->questions()->withTrashed()->restore();
            $question_set->paragraph()->withTrashed()->restore();
        });
    }
}
        