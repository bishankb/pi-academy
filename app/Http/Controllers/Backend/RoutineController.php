<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Routine;
use App\RoutineClass;
use App\RoutineClassTime;
use App\User;
use App\ExaminationQuestion;
use App\RoutineGroup;
use Auth;
use Carbon\Carbon;

class RoutineController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view_routines', ['only' => ['index', 'show']]);
        $this->middleware('permission:add_routines', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_routines', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_routines', ['only' => 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($group_id)
    {
        $routine_group = RoutineGroup::find($group_id);

        if(count($routine_group->routineClassTimes) == 0) {
            abort(404);
        }

        $routines = Routine::where('group_id', $group_id)
                            ->with(['routineClass' => function($routine){
                                $routine->with(['teacher']);
                            }])
                            ->search(request('search-item'))
                            ->deletedItemFilter(request('deleted-items'))
                            ->routineDateSearch(request('routine_date'))
                            ->routineDateToFromSearch(request('from_routineDate'), request('till_routineDate'))
                            ->sort(request('criteria'))
                            ->orderBy('nepali_routine_date', 'desc')
                            ->paginate(request('show-items') ? request('show-items') : config('pi-academy.table_paginate'));
        
        $total_routine = Routine::count();
               
        return view('backend.routine-group.routine.index', compact('routines', 'routine_group', 'total_routine'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($group_id)
    {
        $routine_group = RoutineGroup::find($group_id);

        $routine_class_times = RoutineClassTime::where('group_id', $group_id)
                                                ->orderBy('order')
                                                ->get();

        $teachers = User::whereHas('role', function ($r) {
                                $r->whereIn('name', config('pi-academy.teacher'));
                            })->pluck('name', 'id');
        $subjects = ExaminationQuestion::Subjects;

        return view('backend.routine-group.routine.create', compact('routine_class_times', 'routine_group', 'teachers', 'subjects'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $group_id)
    {
        $this->validate($request,
            [
                'english_routine_date' => 'required|date',
                'nepali_routine_date'  => 'required|string',
                'teacher_id.*'         => 'required|numeric',
                'subject.*'            => 'required|numeric',
                'topic_taught.*'       => 'required|min:2|max:6555356',
            ]
        );

        try {
            $routine = Routine::create(
                [
                    'group_id'             => $group_id,
                    'english_routine_date' => request('english_routine_date'),
                    'nepali_routine_date'  => request('nepali_routine_date'),
                    'created_by'           => Auth::user()->id,
                    'updated_by'           => Auth::user()->id
                ]
            );

            $classTimeIds = request('class_time_id');
            foreach ($classTimeIds as $key => $classTimeId) {
                $routine_class = RoutineClass::create(
                    [
                        'class_time_id' => $classTimeId,
                        'routine_id'    => $routine->id,
                        'teacher_id'    => request('teacher_id')[$key],
                        'subject'       => request('subject')[$key],
                        'topic_taught'  => request('topic_taught')[$key],
                        'created_by'    => Auth::user()->id,
                        'updated_by'    => Auth::user()->id,
                    ]
                );
            }

            flash('Routine added successfully.')->success();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while adding the routine.')->error();
        }

        return redirect(route('routines.index', $group_id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($group_id, $id)
    {
        $routine = Routine::withTrashed()->where('group_id', $group_id)->find($id);
        $routine_group = RoutineGroup::find($group_id);
        $routine_class_times = RoutineClassTime::where('group_id', $group_id)
                                                ->orderBy('order')
                                                ->get();
        $subjects = ExaminationQuestion::Subjects;

        return view('backend.routine-group.routine.show', compact('routine', 'routine_group', 'routine_class_times', 'subjects'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($group_id, $id)
    {
        $routine = Routine::withTrashed()->where('group_id', $group_id)->find($id);
        $routine_group = RoutineGroup::find($group_id);

        $routine_class_times = RoutineClassTime::where('group_id', $group_id)
                                                ->orderBy('order')
                                                ->get();

        $teachers = User::whereHas('role', function ($r) {
                                $r->whereIn('name', config('pi-academy.teacher'));
                            })->pluck('name', 'id');
        $subjects = ExaminationQuestion::Subjects;

        return view('backend.routine-group.routine.edit', compact('routine', 'routine_class_times', 'routine_group', 'teachers', 'subjects'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $group_id, $id)
    {
        $routine = Routine::withTrashed()->where('group_id', $group_id)->find($id);
        $routine_group = RoutineGroup::find($group_id);

        $this->validate($request,
            [
                'english_routine_date' => 'required|date',
                'nepali_routine_date'  => 'required|string',
                'teacher_id.*'         => 'required|numeric',
                'subject.*'            => 'required|numeric',
                'topic_taught.*'       => 'required|min:2|max:6555356',
            ]
        );

        try {
            $routine->update([
                'english_routine_date' => request('english_routine_date'),
                'nepali_routine_date'  => request('nepali_routine_date'),
                'updated_by'           => Auth::user()->id
            ]);

            $classTimeIds = request('class_time_id');
            foreach ($classTimeIds as $key => $classTimeId) {
                $routine->routineClass->where('class_time_id', $classTimeId)->first()->update(
                    [
                        'teacher_id'    => request('teacher_id')[$key],
                        'subject'       => request('subject')[$key],
                        'topic_taught'  => request('topic_taught')[$key],
                        'updated_by'    => Auth::user()->id,
                    ]
                );
            }

            flash('Routine updated successfully.')->info();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while updating the routine.')->error();
        }

        return redirect(route('routines.index', $group_id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($group_id, $id)
    {
        $routine = Routine::where('group_id', $group_id)->find($id);

        try {
            $routine->delete();
            flash('Routine deleted successfully.')->error();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while deleting the routine.')->error();
        }

        return redirect(route('routines.index', $group_id));
    }

    /**
     * Restore the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($group_id, $id)
    {
        $routine = Routine::where('group_id', $group_id)->withTrashed()->find($id);

        try {
            $routine->restore();
            flash('Routine restored successfully.')->info();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while restoring the routine.')->error();
        }

        return redirect(route('routines.index', ['group_id' => $group_id, 'filter_by' => 'deleted-items', 'deleted-items' => 'Only Deleted']));
    }

    /**
     * Force remove the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function forceDestroy($group_id, $id)
    {
        $routine = Routine::where('group_id', $group_id)->withTrashed()->find($id);

        try {
            $routine->forcedelete();
            flash('Routine deleted permanently.')->error();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while deleting the routine permanently.')->error();
        }

        return redirect(route('routines.index', ['group_id' => $group_id, 'filter_by' => 'deleted-items', 'deleted-items' => 'Only Deleted']));
    }
}
