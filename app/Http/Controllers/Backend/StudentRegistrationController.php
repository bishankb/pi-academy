<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\StudentRegistration;
use App\ScholarshipTest;
use App\OnlineExaminationCredential;
use Auth;
use DB;
use Carbon\Carbon;

class StudentRegistrationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view_student_registrations', ['only' => ['index', 'show']]);
        $this->middleware('permission:add_student_registrations', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_student_registrations', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_student_registrations', ['only' => 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $student_registrations = StudentRegistration::search(request('search-item'))
                      ->deletedItemFilter(request('deleted-items'))
                      ->genderFilter(request('gender'))
                      ->educationLevelFilter(request('education-level'))
                      ->interestedCourseFilter(request('interested-course'))
                      ->shiftFilter(request('shift'))
                      ->sort(request('criteria'))
                      ->latest()
                      ->paginate(request('show-items') ? request('show-items') : config('pi-academy.table_paginate'));

        $education_levels = ScholarshipTest::EducationLevel;
        $interested_courses = ScholarshipTest::InterestedCourse;
        $total_student_registration = StudentRegistration::count();

        return view('backend.student-registration.index', compact('student_registrations', 'education_levels', 'interested_courses', 'total_student_registration'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $education_levels = ScholarshipTest::EducationLevel;
        $interested_courses = ScholarshipTest::InterestedCourse;
        $known_froms = StudentRegistration::KnownFrom;
        $submitted_documents = StudentRegistration::SubmittedDocuments;
        $books = StudentRegistration::Books;

        return view('backend.student-registration.create', compact('education_levels', 'interested_courses', 'known_froms', 'submitted_documents', 'books'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,
            [
                //Personal Detail
                'first_name'                   => 'required|string|min:2|max:255',
                'middle_name'                  => 'nullable|string|min:1|max:255',
                'last_name'                    => 'required|string|min:2|max:255',
                'gender'                       => 'required|numeric',
                'english_dob'                  => 'nullable|date',
                'nepali_dob'                   => 'nullable|string',
                'landline_number'              => 'nullable|min:5|max:10',
                'cell_number'                  => 'nullable|min:5|max:20',
                'email'                        => 'nullable|string|email|max:255|unique:student_registrations,email,NULL,id,deleted_at,NULL',
                'permanent_address'            => 'nullable|string|min:2|max:255',
                'district'                     => 'nullable|string|min:2|max:255',
                'municipality'                 => 'nullable|string|min:2|max:255',

                //Contact Address(If different from honme address)
                'current_address'              => 'nullable|string|min:2|max:255',
                'guardian_name'                => 'nullable|string|min:2|max:255',
                'guardian_landline_number'     => 'nullable|min:5|max:10',
                'guardian_cell_number'         => 'nullable|min:5|max:20',

                //Academic Qualification
                //College        
                'education_level'              => 'nullable|numeric',
                'college_name'                 => 'nullable|string|min:2|max:255',
                'college_address'              => 'nullable|string|min:2|max:255',
                'college_marks_obtained'       => 'nullable|string|min:1|max:5',

                //School
                'school_name'                  => 'nullable|string|min:2|max:255',
                'school_address'               => 'nullable|string|min:2|max:255',
                'school_marks_obtained'        => 'nullable|string|max:5',

                //PI Academic Reference
                //Documents
                'student_image_1'              => 'nullable|image|mimes:jpg,png,jpeg|max:10240',
                'student_image_2'              => 'nullable|image|mimes:jpg,png,jpeg|max:10240',
                'character_certificate'        => 'nullable|image|mimes:jpg,png,jpeg|max:10240',
                'scholarship_recommendation'   => 'nullable|image|mimes:jpg,png,jpeg|max:10240',
                'marksheet'                    => 'nullable|image|mimes:jpg,png,jpeg|max:10240',

                //Fee
                'total_fee'                    => ['required', 'numeric'],
                'scholarship'                  => 'nullable|numeric|max:100',
                'fee_after_scholarship'        => ['required', 'numeric'],
                'english_due_clearance_date'   => 'nullable|date',
                'nepali_due_clearance_date'    => 'nullable|string',

                'registration_number'          => 'nullable|string|min:2|max:255',
                'interested_course'            => 'required|numeric',
                'shift'                        => 'nullable|numeric',
                'interested_stream'            => 'nullable|string|min:2|max:255',
                'english_final_admission_date' => 'nullable|date',
                'nepali_final_admission_date'  => 'nullable|string',
                'approved_by'                  => 'nullable|string|min:2|max:255',
                'known_from'                   => 'nullable|numeric',
                'known_from_other'             => 'nullable|string|min:2|max:255',
                
            ]
        );

        DB::beginTransaction();
        try {
            if(request('books_taken')) {
                $books_taken = implode(",", $request->get('books_taken'));
            } else {
                $books_taken = null;
            }

            if(request('submitted_documents')) {
                $submitted_documents = implode(",", $request->get('submitted_documents'));
            } else {
                $submitted_documents = null;
            }

            $student_registration = StudentRegistration::create(
                [
                    //Personal Detail
                    'first_name'                       => request('first_name'),
                    'middle_name'                      => request('middle_name'),
                    'last_name'                        => request('last_name'),
                    'gender'                           => request('gender'),
                    'english_dob'                      => isset($request->english_dob) ? Carbon::parse(request('english_dob'))->format('Y-m-d') : null,
                    'nepali_dob'                       => isset($request->nepali_dob) ? Carbon::parse(request('nepali_dob'))->format('Y-m-d') : null,
                    'landline_number'                  => request('landline_number'),
                    'cell_number'                      => request('cell_number'),
                    'email'                            => request('email'),
                    'permanent_address'                => request('permanent_address'),
                    'district'                         => request('district'),
                    'municipality'                     => request('municipality'),

                    //Contact Address(If different from honme address)
                    'current_address'                  => request('current_address'),
                    'guardian_name'                    => request('guardian_name'),
                    'guardian_landline_number'         => request('guardian_landline_number'),
                    'guardian_cell_number'             => request('guardian_cell_number'),

                    //Academic Qualification
                    //College        
                    'education_level'                  => request('education_level'),
                    'college_name'                     => request('college_name'),
                    'college_address'                  => request('college_address'),
                    'college_marks_obtained'           => request('college_marks_obtained'),

                    //School
                    'school_name'                      => request('school_name'),
                    'school_address'                   => request('school_address'),
                    'school_marks_obtained'            => request('school_marks_obtained'),

                    //PI Academic Reference
                    //Documents
                    'submitted_documents'              => $submitted_documents,
                    
                    //Fee
                    'total_fee'                        => request('total_fee'),
                    'scholarship'                      => request('scholarship'),
                    'fee_after_scholarship'            => request('fee_after_scholarship'),
                    'english_due_clearance_date'       => isset($request->english_due_clearance_date) ? Carbon::parse(request('english_due_clearance_date'))->format('Y-m-d') : null,
                    'nepali_due_clearance_date'        => isset($request->nepali_due_clearance_date) ? Carbon::parse(request('nepali_due_clearance_date'))->format('Y-m-d') : null,

                    'registration_number'              => request('registration_number'),
                    'interested_course'                => request('interested_course'),
                    'shift'                            => request('shift'),
                    'interested_stream'                => request('interested_stream'),
                    'english_final_admission_date'       => isset($request->english_final_admission_date) ? Carbon::parse(request('english_final_admission_date'))->format('Y-m-d') : null,
                    'nepali_final_admission_date'        => isset($request->nepali_final_admission_date) ? Carbon::parse(request('nepali_final_admission_date'))->format('Y-m-d') : null,
                    'approved_by'                      => request('approved_by'),
                    'known_from'                       => request('known_from'),
                    'known_from_other'                 => request('known_from_other'),
                    'books_taken'                      => $books_taken,

                    'created_by'                       => Auth::user()->id,
                    'updated_by'                       => Auth::user()->id,
                ]
            );

            if(isset($request->middle_name)) {
                $username = request('first_name') . ' ' . request('middle_name') . ' ' . request('last_name');
            } else {
                $username = request('first_name') . ' ' .request('last_name');
            }

            OnlineExaminationCredential::create([
                'student_id'          => $student_registration->id,
                'email'               => !empty(request('email')) ? request('email') : null,
                'username'            => $username,
                'password'            => bcrypt('PIAcademy'),
                'registration_number' => !empty(request('registration_number')) ? request('registration_number') : null,
                'verified'       => 1
            ]);

            if ($request->file('student_image_1')) {
                $fileImage1 = $request->file('student_image_1');
                $student_image_1 = saveImage($fileImage1, 'student-registration-image1', $student_registration->id);
            }

            if ($request->file('student_image_2')) {
                $fileImage2 = $request->file('student_image_2');
                $student_image_2 = saveImage($fileImage2, 'student-registration-image2', $student_registration->id);
            }

            if ($request->file('character_certificate')) {
                $fileCharacterCertificate = $request->file('character_certificate');
                $character_certificate = saveImage($fileCharacterCertificate, 'student-registration-characterCertificate', $student_registration->id);
            }

            if ($request->file('scholarship_recommendation')) {
                $fileScholarshipRecommendation = $request->file('scholarship_recommendation');
                $scholarship_recommendation = saveImage($fileScholarshipRecommendation, 'student-registration-scholarshipRecommendation', $student_registration->id);
            }

            if ($request->file('marksheet')) {
                $fileMarksheet = $request->file('marksheet');
                $marksheet = saveImage($fileMarksheet, 'student-registration-marksheet', $student_registration->id);
            }

            $student_registration->update([
                'student_image_1'            => isset($student_image_1->id) ? $student_image_1->id : null,
                'student_image_2'            => isset($student_image_2->id) ? $student_image_2->id : null,
                'character_certificate'      => isset($character_certificate->id) ? $character_certificate->id : null,
                'scholarship_recommendation' => isset($scholarship_recommendation->id) ? $scholarship_recommendation->id : null,
                'marksheet'                  => isset($marksheet->id) ? $marksheet->id : null
            ]);

            flash('Student added successfully.')->success();

            DB::commit();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            DB::rollback();
            flash('There was some intenal error while adding the student .')->error();
        }

        return redirect(route('student-registration.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $student_registration = StudentRegistration::withTrashed()->find($id);

        return view('backend.student-registration.show', compact('student_registration'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $student_registration = StudentRegistration::withTrashed()->find($id);

        $education_levels = ScholarshipTest::EducationLevel;
        $interested_courses = ScholarshipTest::InterestedCourse;
        $known_froms = StudentRegistration::KnownFrom;
        $submitted_documents = StudentRegistration::SubmittedDocuments;
        $books = StudentRegistration::Books;


        return view('backend.student-registration.edit', compact('student_registration', 'education_levels', 'interested_courses', 'known_froms', 'submitted_documents', 'books'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $student_registration = StudentRegistration::withTrashed()->find($id);

        $this->validate($request,
            [
                //Personal Detail
                'first_name'                   => 'required|string|min:2|max:255',
                'middle_name'                  => 'nullable|string|min:1|max:255',
                'last_name'                    => 'required|string|min:2|max:255',
                'gender'                       => 'required|numeric',
                'english_dob'                  => 'nullable|date',
                'nepali_dob'                   => 'nullable|string',
                'landline_number'              => 'nullable|min:5|max:10',
                'cell_number'                  => 'nullable|min:5|max:20',
                'email'                        => 'nullable|string|email|max:255|unique:student_registrations,email,'.$id.',id,deleted_at,NULL',
                'permanent_address'            => 'nullable|string|min:2|max:255',
                'district'                     => 'nullable|string|min:2|max:255',
                'municipality'                 => 'nullable|string|min:2|max:255',

                //Contact Address(If different from honme address)
                'current_address'              => 'nullable|string|min:2|max:255',
                'guardian_name'                => 'nullable|string|min:2|max:255',
                'guardian_landline_number'     => 'nullable|min:5|max:10',
                'guardian_cell_number'         => 'nullable|min:5|max:20',

                //Academic Qualification
                //College        
                'education_level'              => 'nullable|numeric',
                'college_name'                 => 'nullable|string|min:2|max:255',
                'college_address'              => 'nullable|string|min:2|max:255',
                'college_marks_obtained'       => 'nullable|string|min:1|max:5',

                //School
                'school_name'                  => 'nullable|string|min:2|max:255',
                'school_address'               => 'nullable|string|min:2|max:255',
                'school_marks_obtained'        => 'nullable|string|min:1|max:5',

                //PI Academic Reference
                //Documents
                'student_image_1'              => 'nullable|image|mimes:jpg,png,jpeg|max:10240',
                'student_image_2'              => 'nullable|image|mimes:jpg,png,jpeg|max:10240',
                'character_certificate'        => 'nullable|image|mimes:jpg,png,jpeg|max:10240',
                'scholarship_recommendation'   => 'nullable|image|mimes:jpg,png,jpeg|max:10240',
                'marksheet'                    => 'nullable|image|mimes:jpg,png,jpeg|max:10240',

                //Fee
                'total_fee'                    => ['required', 'numeric'],
                'scholarship'                  => 'nullable|numeric|max:100',
                'fee_after_scholarship'        => ['required', 'numeric'],
                'english_due_clearance_date'   => 'nullable|date',
                'nepali_due_clearance_date'    => 'nullable|string',

                'registration_number'          => 'nullable|string|min:2|max:255',
                'interested_course'            => 'required|numeric',
                'shift'                        => 'nullable|numeric',
                'interested_stream'            => 'nullable|string|min:2|max:255',
                'english_final_admission_date' => 'nullable|date',
                'nepali_final_admission_date'  => 'nullable|string',
                'approved_by'                  => 'nullable|string|min:2|max:255',
                'known_from'                   => 'nullable|numeric',
                'known_from_other'             => 'nullable|string|min:2|max:255',
            ]
        );

        DB::beginTransaction();
        try {
            if ($request->file('student_image_1')) {
                $fileImage1 = $request->file('student_image_1');
                $student_image_1 = saveImage($fileImage1, 'student-registration-image1', $student_registration->id);
            }

            if(isset($student_image_1->id) && !empty($student_registration->student_image_1)) {
                removeFile($student_registration->student_image_1);
            }

            if (isset($student_image_1->id)) {
                $student_registration->update(['student_image_1' => $student_image_1->id]);
            }

            if ($request->file('student_image_2')) {
                $fileImage2 = $request->file('student_image_2');
                $student_image_2 = saveImage($fileImage2, 'student-registration-image2', $student_registration->id);
            }

            if(isset($student_image_2->id) && !empty($student_registration->student_image_2)) {
                removeFile($student_registration->student_image_2);
            }

            if (isset($student_image_2->id)) {
                $student_registration->update(['student_image_2' => $student_image_2->id]);
            }

            if ($request->file('character_certificate')) {
                $fileCharacterCertificate = $request->file('character_certificate');
                $character_certificate = saveImage($fileCharacterCertificate, 'student-registration-characterCertificate', $student_registration->id);
            }

            if(isset($character_certificate->id) && !empty($student_registration->character_certificate)) {
                removeFile($student_registration->character_certificate);
            }

            if (isset($character_certificate->id)) {
                $student_registration->update(['character_certificate' => $character_certificate->id]);
            }

            if ($request->file('scholarship_recommendation')) {
                $fileScholarshipRecommendation = $request->file('scholarship_recommendation');
                $scholarship_recommendation = saveImage($fileScholarshipRecommendation, 'student-registration-scholarshipRecommendation', $student_registration->id);
            }

            if(isset($scholarship_recommendation->id) && !empty($student_registration->scholarship_recommendation)) {
                removeFile($student_registration->scholarship_recommendation);
            }

            if (isset($scholarship_recommendation->id)) {
                $student_registration->update(['scholarship_recommendation' => $scholarship_recommendation->id]);
            }

            if ($request->file('marksheet')) {
                $fileMarksheet = $request->file('marksheet');
                $marksheet = saveImage($fileMarksheet, 'student-registration-marksheet', $student_registration->id);
            }

            if(isset($marksheet->id) && !empty($student_registration->marksheet)) {
                removeFile($student_registration->marksheet);
            }

            if (isset($marksheet->id)) {
                $student_registration->update(['marksheet' => $marksheet->id]);
            }


            if(request('books_taken')) {
                $books_taken = implode(",", $request->get('books_taken'));
            } else {
                $books_taken = null;
            }

            if(request('submitted_documents')) {
                $submitted_documents = implode(",", $request->get('submitted_documents'));
            } else {
                $submitted_documents = null;
            }

            $student_registration->update([
                //Personal Detail
                    'first_name'                       => request('first_name'),
                    'middle_name'                      => request('middle_name'),
                    'last_name'                        => request('last_name'),
                    'gender'                           => request('gender'),
                    'english_dob'                      => isset($request->english_dob) ? Carbon::parse(request('english_dob'))->format('Y-m-d') : null,
                    'nepali_dob'                       => isset($request->nepali_dob) ? Carbon::parse(request('nepali_dob'))->format('Y-m-d') : null,
                    'landline_number'                  => request('landline_number'),
                    'cell_number'                      => request('cell_number'),
                    'email'                            => request('email'),
                    'permanent_address'                => request('permanent_address'),
                    'district'                         => request('district'),
                    'municipality'                     => request('municipality'),

                    //Contact Address(If different from honme address)
                    'current_address'                  => request('current_address'),
                    'guardian_name'                    => request('guardian_name'),
                    'guardian_landline_number'         => request('guardian_landline_number'),
                    'guardian_cell_number'             => request('guardian_cell_number'),

                    //Academic Qualification
                    //College        
                    'education_level'                  => request('education_level'),
                    'college_name'                     => request('college_name'),
                    'college_address'                  => request('college_address'),
                    'college_marks_obtained'           => request('college_marks_obtained'),

                    //School
                    'school_name'                      => request('school_name'),
                    'school_address'                   => request('school_address'),
                    'school_marks_obtained'            => request('school_marks_obtained'),

                    //PI Academic Reference
                    //Documents
                    'submitted_documents'              => $submitted_documents,

                    'total_fee'                        => request('total_fee'),
                    'scholarship'                      => request('scholarship'),
                    'fee_after_scholarship'            => request('fee_after_scholarship'),
                    'english_due_clearance_date'       => isset($request->english_due_clearance_date) ? Carbon::parse(request('english_due_clearance_date'))->format('Y-m-d') : null,
                    'nepali_due_clearance_date'        => isset($request->nepali_due_clearance_date) ? Carbon::parse(request('nepali_due_clearance_date'))->format('Y-m-d') : null,

                    'registration_number'              => request('registration_number'),
                    'interested_course'                => request('interested_course'),
                    'shift'                            => request('shift'),
                    'interested_stream'                => request('interested_stream'),
                    'english_final_admission_date'       => isset($request->english_final_admission_date) ? Carbon::parse(request('english_final_admission_date'))->format('Y-m-d') : null,
                    'nepali_final_admission_date'        => isset($request->nepali_final_admission_date) ? Carbon::parse(request('nepali_final_admission_date'))->format('Y-m-d') : null,
                    'approved_by'                      => request('approved_by'),
                    'known_from'                       => request('known_from'),
                    'known_from_other'                 => request('known_from_other'),
                    'books_taken'                      => $books_taken,

                    'updated_by'                       => Auth::user()->id,
            ]);

            if(isset($request->middle_name)) {
                $username = request('first_name') . ' ' . request('middle_name') . ' ' . request('last_name');
            } else {
                $username = request('first_name') . ' ' .request('last_name');
            }

            $student_registration->examinationCredential->update([
                'email'               => !empty(request('email')) ? request('email') : null,
                'username'            => $username,
                'registration_number' => !empty(request('registration_number')) ? request('registration_number') : null,
            ]);

            flash('Student updated successfully.')->info();

            DB::commit();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            DB::rollback();
            flash('There was some intenal error while updating the student .')->error();
        }

        return redirect(route('student-registration.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $student_registration = StudentRegistration::find($id);

        try {
            $student_registration->delete();
            flash('Student deleted successfully.')->error();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while deleting the student .')->error();
        }

        return redirect(route('student-registration.index'));
    }

    /**
     * Restore the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $student_registration = StudentRegistration::withTrashed()->find($id);

        $student_registrations = StudentRegistration::withTrashed()->where('email', $student_registration->email)->get();

        try {
            if(count($student_registrations) > 1) {
                flash('Email with '. $student_registration->email . 'already exists. Please rename the email before restoring.')->error();
                return redirect(route('student-registration.index', ['filter_by' => 'deleted-items', 'deleted-items' => 'Only Deleted']));
            }

            $student_registration->restore();
            flash('Student restored successfully.')->info();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while restoring the student .')->error();
        }

        return redirect(route('student-registration.index', ['filter_by' => 'deleted-items', 'deleted-items' => 'Only Deleted']));
    }

    /**
     * Force remove the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function forceDestroy($id)
    {
        $student_registration = StudentRegistration::withTrashed()->find($id);

        try {
            $student_registration->forcedelete();
            flash('Student deleted permanently.')->error();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while deleting the student permanently.')->error();
        }

        return redirect(route('student-registration.index', ['filter_by' => 'deleted-items', 'deleted-items' => 'Only Deleted']));
    }

     /**
     * Remove the specified image in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyImage(Request $request, $fileId)
    {
        try {
            removeFile($fileId);
            switch ($request->fileType) {
                case 'student_image_1':
                    $student_registration = StudentRegistration::withTrashed()->where('student_image_1', $fileId)->first();
                    $student_registration->update(['student_image_1' => null]);
                    break;
                
                case 'student_image_2':
                    $student_registration = StudentRegistration::withTrashed()->where('student_image_2', $fileId)->first();
                    $student_registration->update(['student_image_2' => null]);
                    break;

                case 'character_certificate':
                    $student_registration = StudentRegistration::withTrashed()->where('character_certificate', $fileId)->first();
                    $student_registration->update(['character_certificate' => null]);
                    break;

                case 'scholarship_recommendation':
                    $student_registration = StudentRegistration::withTrashed()->where('scholarship_recommendation', $fileId)->first();
                    $student_registration->update(['scholarship_recommendation' => null]);
                    break;                   
                case 'marksheet':
                    $student_registration = StudentRegistration::withTrashed()->where('marksheet', $fileId)->first();
                    $student_registration->update(['marksheet' => null]);
                    break;
            }           

            return response()->json(['success' => true]);
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());    
        }
    }

    public function editExaminationCredential($student_id, $id)
    {
        $examination_credential = OnlineExaminationCredential::withTrashed()->where('student_id', $student_id)->find($id);

        return view('backend.student-registration.examination-credential.edit', compact('examination_credential'));
    }

    public function updateExaminationCredential(Request $request, $student_id, $id)
    {
        $examination_credential = OnlineExaminationCredential::withTrashed()->where('student_id', $student_id)->find($id);

        $this->validate($request,
            [
                'email'               => 'required|string|email|max:255|unique:student_registrations,email,'.$id.',id,deleted_at,NULL',
                'username'            => 'required|string|min:1|max:255',
                'registration_number' => 'required|string|min:1|max:255'
            ]
        );

        if(isset($request->password)) {
            $this->validate($request,
                [
                    'password' => 'required|string|min:6||max:255'
                ]
            );
        }

        try {
            $examination_credential->update([
                'email'               => request('email'),
                'username'            => request('username'),
                'registration_number' => request('registration_number'),
                'active'              => request('active') ? 1 : 0,
            ]);

            if(isset($request->password)) {
                $examination_credential->update([
                    'password' => bcrypt(request('password')),
                ]);
            }

            $examination_credential->student->update([
                'email'               => request('email'),
                'registration_number' => request('registration_number')
            ]);

            flash('Exmaination credential updated successfully.')->success();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while updating the exmaination credential.')->error();
        }

        return redirect(route('student-registration.index'));
    }

    /**
     * Change the status of specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changeStatus(Request $request, $student_id, $id)
    {
        $examination_credential = OnlineExaminationCredential::withTrashed()->where('student_id', $student_id)->find($id);

        try {
            $examination_credential->update(
                [
                    'active'=> request('status')
                ]
            );
            return response()->json(['success' => true]);
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
        }
    }
}
