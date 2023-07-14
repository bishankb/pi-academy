<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\BaseModel;

class ScholarshipTest extends BaseModel
{   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        //Personal Detail
        'first_name',
        'middle_name',
        'last_name',
        'gender',
        'english_dob',
        'nepali_dob',
        'landline_number',
        'cell_number',
        'email',
        'permanent_address',
        'district',
        'municipality',
        'student_image_id',

        //Contact Address(If different from honme address)
        'current_address',
        'guardian_name',
        'guardian_landline_number',
        'guardian_cell_number',

        //Academic Qualification
        'education_level',
        
        //College        
        'college_name',
        'college_address',
        'college_marks_obtained',

        //School
        'school_name',
        'school_address',
        'school_marks_obtained',

        //PI Academic Reference
        'registration_number',
        'interested_course',
        'shift',

        'created_by',
        'updated_by',
    ];

    const Gender = [
        'Male',
        'Female',
    ];

    const EducationLevel = [
        '+2/I.Sc.',
        'A Level',
        'Diploma',
        'Bachelor',
    ];

    const InterestedCourse = [
        'IOE Pulchowk Preparation',
        'KU/PoU/PU',
        'Diploma In Eng Group',
        'B.Sc.CSIT',
        'Pre-Engineering',
        'Loksewa',
        'Indian Embassy/SAT',
        'Enginering'
    ];

    const Shift = [
        'Morning',
        'Day',
        'Evening'
    ];

    public function scopeSearch($query, $search)
    {
        return $query->where('first_name', 'like', '%' . $search . '%')
                    ->OrWhere('middle_name', 'like', '%' . $search . '%')
                    ->OrWhere('last_name', 'like', '%' . $search . '%')
                    ->OrWhere('landline_number', 'like', '%' . $search . '%')
                    ->OrWhere('cell_number', 'like', '%' . $search . '%')
                    ->OrWhere('college_name', 'like', '%' . $search . '%')
                    ->OrWhere('school_name', 'like', '%' . $search . '%')
                    ->OrWhere('registration_number', 'like', '%' . $search . '%');
    }

    public function scopeSort($query, $filter)
    {
        if ($filter) {
            if ($filter == "firstName-low-high") {
                return $query->orderBy('first_name', 'asc');
            } elseif($filter == "firstName-high-low") {
                return $query->orderBy('first_name', 'desc');
            } elseif ($filter == "registrationNumber-low-high") {
                return $query->orderBy('registration_number', 'asc');
            } elseif ($filter == "registrationNumber-high-low") {
                return $query->orderBy('registration_number', 'desc');
            }
        }

        return $query;
    }

    public function scopeGenderFilter($query, $filter)
    {
        if ($filter) {
            return $query->where('gender', array_flip(self::Gender)[$filter]);
        }

        return $query;
    }

    public function scopeEducationLevelFilter($query, $filter)
    {
        if ($filter) {
            return $query->where('education_level', array_flip(self::EducationLevel)[$filter]);
        }

        return $query;
    }

    public function scopeInterestedCourseFilter($query, $filter)
    {
        if ($filter) {
            return $query->where('interested_course', array_flip(self::InterestedCourse)[$filter]);           
        }

        return $query;
    }

    public function scopeShiftFilter($query, $filter)
    {
        if ($filter) {
            return $query->where('shift', array_flip(self::Shift)[$filter]);           
        }

        return $query;
    }

    public function image()
    {
        return $this->belongsTo(Media::class, 'student_image_id');
    }
}