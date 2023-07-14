<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\RoutineGroup;
use Auth;
use Carbon\Carbon;
use App\User;
use App\RoutineClass;
use App\ExaminationQuestion;

class RoutineTeacherController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view_teacher_routines');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function teacherList()
    {
        $teachers = User::whereHas('role', function ($r) {
                          $r->whereIn('name', config('pi-academy.teacher'));
                        })
                        ->whereHas('routineClass')
                        ->statusFilter(request('status'))
                        ->search(request('search-item'))
                        ->deletedItemFilter(request('deleted-items'))
                        ->sort(request('criteria'))
                        ->paginate(request('show-items') ? request('show-items') : config('pi-academy.table_paginate'));

        $total_teacher = User::whereHas('role', function ($r) {
                          $r->whereIn('name', config('pi-academy.teacher'));
                        })->count();
               
        return view('backend.routine-teacher.index', compact('teachers', 'total_teacher'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function teacherShow($id)
    {
        $teacher = User::whereHas('role', function ($r) {
                          $r->whereIn('name', config('pi-academy.teacher'));
                        })->whereHas('routineClass')
                        ->withTrashed()
                        ->find($id);

        return $teacher;

        return view('backend.routine-teacher.show', compact('teacher'));
    }

    public function index($teacher_id)
    {
        $routine_classes = RoutineClass::where('teacher_id', $teacher_id)
                                        ->search(request('search-item'))
                                        ->deletedItemFilter(request('deleted-items'))
                                        ->subjectFilter(request('subject'))
                                        ->groupFilter(request('routine-group'))
                                        ->routineDateSearch(request('routine_date'))
                                        ->routineDateToFromSearch(request('from_routineDate'), request('till_routineDate'))
                                        ->paginate(request('show-items') ? request('show-items') : config('pi-academy.table_paginate'));

        $teacher = User::find($teacher_id);
        $subjects = ExaminationQuestion::Subjects;
        $routine_groups = RoutineGroup::get();
        $total_routine_class = RoutineClass::where('teacher_id', $teacher_id)->count();
               
        return view('backend.routine-teacher.routine-class.index', compact('routine_classes', 'teacher', 'subjects', 'routine_groups', 'total_routine_class'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($teacher_id, $id)
    {
        $teacher = User::find($teacher_id);
        $routine_class = RoutineClass::where('teacher_id', $teacher_id)->find($id);
        $subjects = ExaminationQuestion::Subjects;

        return view('backend.routine-teacher.routine-class.show', compact('routine_class', 'teacher', 'subjects'));
    }
}
