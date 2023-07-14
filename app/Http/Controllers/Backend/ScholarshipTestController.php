<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ScholarshipTest;
use Auth;
use DB;
use Carbon\Carbon;
use App\Traits\DateConversionTrait;

class ScholarshipTestController extends Controller
{
    use DateConversionTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view_scholarship_tests', ['only' => ['index', 'show']]);
        $this->middleware('permission:add_scholarship_tests', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_scholarship_tests', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_scholarship_tests', ['only' => 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $scholarship_tests = ScholarshipTest::search(request('search-item'))
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
        $total_scholarship_test = ScholarshipTest::count();

        return view('backend.scholarship-test.index', compact('scholarship_tests', 'education_levels', 'interested_courses', 'total_scholarship_test'));
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

        return view('backend.scholarship-test.create', compact('education_levels', 'interested_courses'));
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
                'first_name'               => 'required|string|min:2|max:255',
                'middle_name'              => 'nullable|string|min:1|max:255',
                'last_name'                => 'required|string|min:2|max:255',
                'gender'                   => 'required|numeric',
                'english_dob'              => 'nullable|date',
                'nepali_dob'               => 'nullable|string',
                'landline_number'          => 'nullable|min:5|max:10',
                'cell_number'              => 'nullable|min:5|max:20',
                'email'                    => 'nullable|string|email|max:255',
                'permanent_address'        => 'nullable|string|min:2|max:255',
                'district'                 => 'nullable|string|min:2|max:255',
                'municipality'             => 'nullable|string|min:2|max:255',
                'student_image_id'         => 'nullable|image|mimes:jpg,png,jpeg|max:10240',

                //Contact Address(If different from honme address)
                'current_address'          => 'nullable|string|min:2|max:255',
                'guardian_name'            => 'nullable|string|min:2|max:255',
                'guardian_landline_number' => 'nullable|min:5|max:10',
                'guardian_cell_number'     => 'nullable|min:5|max:20',

                //Academic Qualification
                //College        
                'education_level'          => 'nullable|numeric',
                'college_name'             => 'nullable|string|min:2|max:255',
                'college_address'          => 'nullable|string|min:2|max:255',
                'college_marks_obtained'   => 'nullable|string|min:1|max:5',

                //School
                'school_name'              => 'nullable|string|min:2|max:255',
                'school_address'           => 'nullable|string|min:2|max:255',
                'school_marks_obtained'    => 'nullable|string|min:1|max:5',

                //PI Academic Reference
                'registration_number'      => 'nullable|string|min:2|max:255',
                'interested_course'        => 'required|numeric',
                'shift'                    => 'nullable|numeric',
            ]
        );

        DB::beginTransaction();
        try {
            $scholarship_test = ScholarshipTest::create(
                [
                    //Personal Detail
                    'first_name'              => request('first_name'),
                    'middle_name'             => request('middle_name'),
                    'last_name'               => request('last_name'),
                    'gender'                  => request('gender'),
                    'english_dob'             => request('english_dob'),
                    'nepali_dob'              => request('nepali_dob'),
                    'landline_number'         => request('landline_number'),
                    'cell_number'             => request('cell_number'),
                    'email'                   => request('email'),
                    'permanent_address'       => request('permanent_address'),
                    'district'                => request('district'),
                    'municipality'            => request('municipality'),

                    //Contact Address(If different from honme address)
                    'current_address'          => request('current_address'),
                    'guardian_name'            => request('guardian_name'),
                    'guardian_landline_number' => request('guardian_landline_number'),
                    'guardian_cell_number'     => request('guardian_cell_number'),

                    //Academic Qualification
                    //College        
                    'education_level'          => request('education_level'),
                    'college_name'             => request('college_name'),
                    'college_address'          => request('college_address'),
                    'college_marks_obtained'   => request('college_marks_obtained'),

                    //School
                    'school_name'              => request('school_name'),
                    'school_address'           => request('school_address'),
                    'school_marks_obtained'    => request('school_marks_obtained'),

                    //PI Academic Reference
                    'registration_number'      => request('registration_number'),
                    'interested_course'        => request('interested_course'),
                    'shift'                    => request('shift'),

                    'created_by'               => Auth::user()->id,
                    'updated_by'               => Auth::user()->id,
                ]
            );

            if ($request->file('student_image_id')) {
                $fileImage = $request->file('student_image_id');
                $student_image = saveImage($fileImage, 'scholarship-test', $scholarship_test->id);
            }

            $scholarship_test->update([
                'student_image_id' => isset($student_image->id) ? $student_image->id : null
            ]);

            flash('Scholarship test student added successfully.')->success();

            DB::commit();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            DB::rollback();
            flash('There was some intenal error while adding the scholarship test student .')->error();
        }

        return redirect(route('scholarship-test.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $scholarship_test = ScholarshipTest::withTrashed()->find($id);

        return view('backend.scholarship-test.show', compact('scholarship_test'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $scholarship_test = ScholarshipTest::withTrashed()->find($id);

        $education_levels = ScholarshipTest::EducationLevel;
        $interested_courses = ScholarshipTest::InterestedCourse;

        return view('backend.scholarship-test.edit', compact('scholarship_test', 'education_levels', 'interested_courses'));
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
        $scholarship_test = ScholarshipTest::withTrashed()->find($id);

        $this->validate($request,
            [
                //Personal Detail
                'first_name'               => 'required|string|min:2|max:255',
                'middle_name'              => 'nullable|string|min:1|max:255',
                'last_name'                => 'required|string|min:2|max:255',
                'gender'                   => 'required|numeric',
                'english_dob'              => 'nullable|date',
                'nepali_dob'               => 'nullable|string',
                'landline_number'          => 'nullable|min:5|max:10',
                'cell_number'              => 'nullable|min:5|max:20',
                'email'                    => 'nullable|string|email|max:255',
                'permanent_address'        => 'nullable|string|min:2|max:255',
                'district'                 => 'nullable|string|min:2|max:255',
                'municipality'             => 'nullable|string|min:2|max:255',
                'student_image_id'         => 'nullable|image|mimes:jpg,png,jpeg|max:10240',

                //Contact Address(If different from honme address)
                'current_address'          => 'nullable|string|min:2|max:255',
                'guardian_name'            => 'nullable|string|min:2|max:255',
                'guardian_landline_number' => 'nullable|min:5|max:10',
                'guardian_cell_number'     => 'nullable|min:5|max:20',

                //Academic Qualification
                //College        
                'education_level'          => 'nullable|numeric',
                'college_name'             => 'nullable|string|min:2|max:255',
                'college_address'          => 'nullable|string|min:2|max:255',
                'college_marks_obtained'   => 'nullable|string|min:1|max:5',

                //School
                'school_name'              => 'nullable|string|min:2|max:255',
                'school_address'           => 'nullable|string|min:2|max:255',
                'school_marks_obtained'    => 'nullable|string|min:1|max:5',

                //PI Academic Reference
                'registration_number'      => 'nullable|string|min:2|max:255',
                'interested_course'        => 'required|numeric',
                'shift'                    => 'nullable|numeric',
            ]
        );

        DB::beginTransaction();
        try {
            if ($request->file('student_image_id')) {
                $fileImage = $request->file('student_image_id');
                $student_image = saveImage($fileImage, 'scholarship-test', $scholarship_test->id);
            }

            if(isset($student_image->id) && !empty($scholarship_test->student_image_id)) {
                removeFile($scholarship_test->student_image_id);
            }

            if (isset($student_image->id)) {
                $scholarship_test->update(['student_image_id' => $student_image->id]);
            }

            $scholarship_test->update([
                //Personal Detail
                'first_name'              => request('first_name'),
                'middle_name'             => request('middle_name'),
                'last_name'               => request('last_name'),
                'gender'                  => request('gender'),
                'english_dob'             => request('english_dob'),
                'nepali_dob'              => request('nepali_dob'),
                'landline_number'         => request('landline_number'),
                'cell_number'             => request('cell_number'),
                'email'                   => request('email'),
                'permanent_address'       => request('permanent_address'),
                'district'                => request('district'),
                'municipality'            => request('municipality'),

                //Contact Address(If different from honme address)
                'current_address'          => request('current_address'),
                'guardian_name'            => request('guardian_name'),
                'guardian_landline_number' => request('guardian_landline_number'),
                'guardian_cell_number'     => request('guardian_cell_number'),

                //Academic Qualification
                //College        
                'education_level'          => request('education_level'),
                'college_name'             => request('college_name'),
                'college_address'          => request('college_address'),
                'college_marks_obtained'   => request('college_marks_obtained'),

                //School
                'school_name'              => request('school_name'),
                'school_address'           => request('school_address'),
                'school_marks_obtained'    => request('school_marks_obtained'),

                ///PI Academic Reference
                'registration_number'      => request('registration_number'),
                'interested_course'        => request('interested_course'),
                'shift'                    => request('shift'),

                'updated_by'               => Auth::user()->id,
            ]);
            flash('Scholarship test student updated successfully.')->info();

            DB::commit();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            DB::rollback();
            flash('There was some intenal error while updating the scholarship test student .')->error();
        }

        return redirect(route('scholarship-test.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $scholarship_test = ScholarshipTest::find($id);

        try {
            $scholarship_test->delete();
            flash('Scholarship test student deleted successfully.')->error();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while deleting the scholarship test student .')->error();
        }

        return redirect(route('scholarship-test.index'));
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
        $scholarship_test = ScholarshipTest::withTrashed()->find($id);

        try {
            $scholarship_test->restore();
            flash('Scholarship test student restored successfully.')->info();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while restoring the scholarship test student .')->error();
        }

        return redirect(route('scholarship-test.index', ['filter_by' => 'deleted-items', 'deleted-items' => 'Only Deleted']));
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
        $scholarship_test = ScholarshipTest::withTrashed()->find($id);

        try {
            $scholarship_test->forcedelete();
            flash('Scholarship test student deleted permanently.')->error();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while deleting the scholarship test student permanently.')->error();
        }

        return redirect(route('scholarship-test.index', ['filter_by' => 'deleted-items', 'deleted-items' => 'Only Deleted']));
    }

    /**
     * Remove the specified image in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyImage($fileId)
    {
        $scholarship_test = ScholarshipTest::withTrashed()->where('student_image_id', $fileId)->first();
        try {
            removeFile($fileId);
            $scholarship_test->update(['student_image_id' => null]);

            return response()->json(['success' => true]);
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());    
        }
    }

    public function getSelectedDate(Request $request, $date)
    {
        $selected_date = explode('-', $date);
        $year = $selected_date[0];
        $month = $selected_date[1];
        $day = $selected_date[2];
        $conversion_type = $request->conversion_type;
        if($request->conversion_type == 'english-nepali') {
            $date_conversion =  $this->eng_to_nep($year, $month, $day);
        } elseif($request->conversion_type == 'nepali-english') {
            $date_conversion =  $this->nep_to_eng($year, $month, $day);
        }
        $converted_year = $date_conversion['year'];
        $converted_month = str_pad($date_conversion['month'], 2, '0', STR_PAD_LEFT);
        $converted_day = str_pad($date_conversion['date'], 2, '0', STR_PAD_LEFT);
        $converted_date = $converted_year.'-'.$converted_month.'-'.$converted_day;

        return response()->json([
            'success' => true,
            'converted_date' => $converted_date
        ]);
    }
}
