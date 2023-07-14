<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;
use Carbon\Carbon;

class StudentRegistration extends BaseModel
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
        //Documents
		'submitted_documents',
        'student_image_1',
        'student_image_2',
        'character_certificate',
        'scholarship_recommendation',
        'marksheet',

        //Fee
        'total_fee',
        'scholarship',
        'fee_after_scholarship',
        'english_due_clearance_date',
        'nepali_due_clearance_date',

        'registration_number',
        'interested_course',
        'shift',
        'interested_stream',
        'english_final_admission_date',
        'nepali_final_admission_date',
        'approved_by',
        'known_from',
        'known_from_other',
        'books_taken',
        'active',

        'created_by',
        'updated_by',
    ];

    const SubmittedDocuments = [
        'Photo 1',
        'Photo 2',
        'Character Certificate',
        'Scholarship Supporting Recommendation',
        'Marksheet'
    ];

    const KnownFrom = [
        'Seniors',
        'Sign-board',
        'Advertisement',
        'Friends',
        'Others'
    ];

    const Books = [
        'ID Card',
        'Mathematics',
        'English',
        'Physics',
        'Chemistry',
        'Aptitude',
        'Question Collection Vol. 1',
        'Question Collection Vol. 2',
        'Question Collection Vol. 3'
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
            return $query->where('gender', array_flip(\App\ScholarshipTest::Gender)[$filter]);
        }

        return $query;
    }

    public function scopeEducationLevelFilter($query, $filter)
    {
        if ($filter) {
            return $query->where('education_level', array_flip(\App\ScholarshipTest::EducationLevel)[$filter]);
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

    public function scopeShiftFilter($query, $filter)
    {
        if ($filter) {
            return $query->where('shift', array_flip(\App\ScholarshipTest::Shift)[$filter]);           
        }

        return $query;
    }

    public function image1()
    {
        return $this->belongsTo(Media::class, 'student_image_1');
    }

    public function image2()
    {
        return $this->belongsTo(Media::class, 'student_image_2');
    }

    public function characterCertificate()
    {
        return $this->belongsTo(Media::class, 'character_certificate');
    }

    public function scholarshipRecommendation()
    {
        return $this->belongsTo(Media::class, 'scholarship_recommendation');
    }

    public function marksheetData()
    {
        return $this->belongsTo(Media::class, 'marksheet');
    }

    public function paymentHistories()
    {
        return $this->hasMany(StudentPaymentHistory::class, 'student_id')->withTrashed();
    }

    public function examinationCredential()
    {
        return $this->hasOne(OnlineExaminationCredential::class, 'student_id')->withTrashed();
    }

    public function examinationRecords()
    {
        return $this->hasMany(ExaminationResult::class, 'student_id');
    }

    /**
     * Delete the associated relation
    */
    protected static function boot() {
        parent::boot();
        
        static::deleting(function($student_registration) {
            if ($student_registration->isForceDeleting()) {
                $student_registration->paymentHistories()->withTrashed()->forceDelete();
                $student_registration->examinationCredential()->withTrashed()->forceDelete();
            } else {
                $student_registration->paymentHistories()->delete();
                $student_registration->examinationCredential()->delete();
                $student_registration->examinationRecords()->delete();
            }
        });

        static::restoring(function ($student_registration) {
            $student_registration->paymentHistories()->withTrashed()->restore();
            $student_registration->examinationCredential()->withTrashed()->restore();
        });
    }
}