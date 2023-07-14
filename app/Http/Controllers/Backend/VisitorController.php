<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Visitor;
use App\ScholarshipTest;
use App\User;
use Auth;
use Carbon\Carbon;
use App\Traits\DateConversionTrait;

class VisitorController extends Controller
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
        $this->middleware('permission:view_visitors', ['only' => ['index', 'show']]);
        $this->middleware('permission:add_visitors', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_visitors', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_visitors', ['only' => 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $visitors = Visitor::search(request('search-item'))
                      ->deletedItemFilter(request('deleted-items'))
                      ->academicStatusFilter(request('academic-status'))
                      ->registerStatusFilter(request('register-status'))
                      ->interestedCourseFilter(request('interested-course'))
                      ->sort(request('criteria'))
                      ->visitedPeriodSearch(request('from_visitedPeriod'), request('till_visitedPeriod'))
                      ->latest()
                      ->paginate(request('show-items') ? request('show-items') : config('pi-academy.table_paginate'));

        $interested_courses = ScholarshipTest::InterestedCourse;
        $total_visitor = Visitor::count();

        return view('backend.visitor.index', compact('visitors', 'interested_courses', 'total_visitor'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $interested_courses = ScholarshipTest::InterestedCourse;
        $academic_statuses = Visitor::AcademicStatus;
        $counsellers = User::whereHas('role', function ($r) {
                                $r->whereIn('name', config('pi-academy.counsellor'));
                            })->pluck('name', 'id');
        $current_nepali_date = $this->currentNepaliDate();

        return view('backend.visitor.create', compact('interested_courses', 'academic_statuses', 'counsellers', 'current_nepali_date'));
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
                'name'                 => 'required|string|min:2|max:255',
                'college_name'         => 'nullable|string|min:2|max:255',
                'marks_obtained'       => 'nullable|string|min:1|max:5',
                'academic_status'      => 'nullable|numeric',
                'english_visited_date' => 'nullable|date',
                'nepali_visited_date'  => 'nullable|string',
                'visited_time'         => 'nullable|string',
                'counselled_by'        => 'nullable|numeric',
                'accompanied_by'       => 'nullable|required_if:is_accompanied,on|string|min:2|max:255',
                'interested_course'    => 'nullable|numeric',
                'interested_stream'    => 'nullable|string|min:2|max:255',
            ],
            [
                'accompanied_by.required_if' => 'The accompanied by field is required.'
            ]
        );

        try {
            $visitor = Visitor::create(
                [
                    'name'                 => request('name'),
                    'college_name'         => request('college_name'),
                    'marks_obtained'       => request('marks_obtained'),
                    'academic_status'      => request('academic_status'),
                    'english_visited_date' => isset($request->english_visited_date) ? Carbon::parse(request('english_visited_date'))->format('Y-m-d') : null,
                    'nepali_visited_date'  => isset($request->nepali_visited_date) ? Carbon::parse(request('nepali_visited_date'))->format('Y-m-d') : null,
                    'visited_time'         => isset($request->visited_time) ? Carbon::parse(request('visited_time'))->format('h:i a') : null,
                    'counselled_by'        => request('counselled_by'),
                    'is_registered'        => request('is_registered') ? 1 : 0,
                    'is_accompanied'       => request('is_accompanied') ? 1 : 0,
                    'accompanied_by'       => request('accompanied_by'),
                    'interested_course'    => request('interested_course'),
                    'interested_stream'    => request('interested_stream'),
                    'created_by'           => Auth::user()->id,
                    'updated_by'           => Auth::user()->id,
                ]
            );

            flash('Visitor added successfully.')->success();

        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while adding the visitor .')->error();
        }

        return redirect(route('visitors.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $visitor = Visitor::withTrashed()->find($id);

        return view('backend.visitor.show', compact('visitor'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $visitor = Visitor::withTrashed()->find($id);
        $interested_courses = ScholarshipTest::InterestedCourse;
        $academic_statuses = Visitor::AcademicStatus;
        $counsellers = User::whereHas('role', function ($r) {
                            $r->where('name', 'teacher')
                              ->OrWhere('name', 'counseller');
                        })->pluck('name', 'id');
        $current_nepali_date = $this->currentNepaliDate();

        return view('backend.visitor.edit', compact('visitor', 'interested_courses', 'academic_statuses', 'counsellers', 'current_nepali_date'));
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
        $visitor = Visitor::withTrashed()->find($id);

        $this->validate($request,
            [
                'name'                 => 'required|string|min:2|max:255',
                'college_name'         => 'nullable|string|min:2|max:255',
                'marks_obtained'       => 'nullable|string|min:1|max:5',
                'academic_status'      => 'nullable|numeric',
                'english_visited_date' => 'nullable|date',
                'nepali_visited_date'  => 'nullable|string',
                'visited_time'         => 'nullable|string',
                'counselled_by'        => 'nullable|numeric',
                'accompanied_by'       => 'nullable|required_if:is_accompanied,on|string|min:2|max:255',
                'interested_course'    => 'nullable|numeric',
                'interested_stream'    => 'nullable|string|min:2|max:255',
            ],
            [
                'accompanied_by.required_if' => 'The accompanied by field is required.'
            ]
        );

        try {

            $visitor->update([
                'name'                 => request('name'),
                'college_name'         => request('college_name'),
                'marks_obtained'       => request('marks_obtained'),
                'academic_status'      => request('academic_status'),
                'english_visited_date' => isset($request->english_visited_date) ? Carbon::parse(request('english_visited_date'))->format('Y-m-d') : null,
                'nepali_visited_date'  => isset($request->nepali_visited_date) ? Carbon::parse(request('nepali_visited_date'))->format('Y-m-d') : null,
                'visited_time'         => isset($request->visited_time) ? Carbon::parse(request('visited_time'))->format('h:i a') : null,
                'counselled_by'        => request('counselled_by'),
                'is_registered'        => request('is_registered') ? 1 : 0,
                'is_accompanied'       => request('is_accompanied') ? 1 : 0,
                'accompanied_by'       => request('accompanied_by'),
                'interested_course'    => request('interested_course'),
                'interested_stream'    => request('interested_stream'),
                'updated_by'           => Auth::user()->id,
            ]);
            flash('Visitor updated successfully.')->info();

        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while updating the visitor .')->error();
        }

        return redirect(route('visitors.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $visitor = Visitor::find($id);

        try {
            $visitor->delete();
            flash('Visitor deleted successfully.')->error();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while deleting the visitor .')->error();
        }

        return redirect(route('visitors.index'));
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
        $visitor = Visitor::withTrashed()->find($id);

        try {
            $visitor->restore();
            flash('Visitor restored successfully.')->info();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while restoring the visitor .')->error();
        }

        return redirect(route('visitors.index', ['filter_by' => 'deleted-items', 'deleted-items' => 'Only Deleted']));
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
        $visitor = Visitor::withTrashed()->find($id);

        try {
            $visitor->forcedelete();
            flash('Visitor deleted permanently.')->error();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while deleting the visitor permanently.')->error();
        }

        return redirect(route('visitors.index', ['filter_by' => 'deleted-items', 'deleted-items' => 'Only Deleted']));
    }

    private function currentNepaliDate() {
        $current_english_date = Carbon::now()->format('Y-m-d');
        $selected_date = explode('-', $current_english_date);
        $year = $selected_date[0];
        $month = $selected_date[1];
        $day = $selected_date[2];
        $date_conversion =  $this->eng_to_nep($year, $month, $day);
        $current_nepali_year = $date_conversion['year'];
        $current_nepali_month = str_pad($date_conversion['month'], 2, '0', STR_PAD_LEFT);
        $current_nepali_day = str_pad($date_conversion['date'], 2, '0', STR_PAD_LEFT);
        $current_nepali_date = $current_nepali_year.'-'.$current_nepali_month.'-'.$current_nepali_day;

        return $current_nepali_date;
    }
}
