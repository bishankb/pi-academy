<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\RoutineClassTime;
use App\User;
use App\ExaminationQuestion;
use App\RoutineGroup;
use Auth;
use Carbon\Carbon;

class RoutineClassTimeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view_routine_class_times', ['only' => ['index', 'show']]);
        $this->middleware('permission:add_routine_class_times', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_routine_class_times', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_routine_class_times', ['only' => 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($group_id)
    {
        $routine_group = RoutineGroup::find($group_id);

        $routine_class_times = RoutineClassTime::where('group_id', $group_id)
                                        ->deletedItemFilter(request('deleted-items'))
                                        ->orderBy('order')
                                        ->paginate(request('show-items') ? request('show-items') : config('pi-academy.table_paginate'));
        
        $total_routine_class_time = RoutineClassTime::where('group_id', $group_id)->count();
               
        return view('backend.routine-group.routine-class-time.index', compact('routine_class_times', 'routine_group', 'total_routine_class_time'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($group_id)
    {
        $routine_group = RoutineGroup::find($group_id);

        return view('backend.routine-group.routine-class-time.create', compact('routine_group'));
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
                'class_start_time' => 'required|string',
                'class_end_time'   => 'required|after:class_start_time|string',
                'order'            => 'required|integer|unique:routine_class_times,order,NULL,id,group_id,'.$group_id,
            ]
        );

        try {
            $routine_class_time = RoutineClassTime::create(
                [
                    'group_id'         => request('group_id'),
                    'class_start_time' => request('class_start_time'),
                    'class_end_time'   => request('class_end_time'),
                    'order'            => request('order'),
                    'created_by'       => Auth::user()->id,
                    'updated_by'       => Auth::user()->id
                ]
            );
            flash('Routine class time time added successfully.')->success();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while adding the routine class time time.')->error();
        }

        return redirect(route('routine-class-time.index', $group_id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($group_id, $id)
    {
        $routine_class_time = RoutineClassTime::withTrashed()->where('group_id', $group_id)->find($id);
        $routine_group = RoutineGroup::find($group_id);

        return view('backend.routine-group.routine-class-time.show', compact('routine_class_time', 'routine_group'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($group_id, $id)
    {
        $routine_class_time = RoutineClassTime::withTrashed()->where('group_id', $group_id)->find($id);
        $routine_group = RoutineGroup::find($group_id);

        return view('backend.routine-group.routine-class-time.edit', compact('routine_class_time', 'routine_group'));
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
        $routine_class_time = RoutineClassTime::withTrashed()->where('group_id', $group_id)->find($id);
        $routine_group = RoutineGroup::find($group_id);

        $this->validate($request,
            [
                'class_start_time' => 'required|string',
                'class_end_time'   => 'required|after:class_start_time|string',
                'order'            => 'required|integer|unique:routine_class_times,order,'.$id.',id,group_id,'.$group_id,
            ]
        );

        try {
            $routine_class_time->update([
                'class_start_time' => request('class_start_time'),
                'class_end_time'   => request('class_end_time'),
                'order'            => request('order'),
                'updated_by'       => Auth::user()->id
            ]);
            flash('Routine class time updated successfully.')->info();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while updating the routine class time.')->error();
        }

        return redirect(route('routine-class-time.index', $group_id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($group_id, $id)
    {
        $routine_class_time = RoutineClassTime::where('group_id', $group_id)->find($id);

        try {
            $routine_class_time->delete();
            flash('Routine class time deleted successfully.')->error();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while deleting the routine class time.')->error();
        }

        return redirect(route('routine-class-time.index', $group_id));
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
        $routine_class_time = RoutineClassTime::withTrashed()->where('group_id', $group_id)->find($id);

        try {
            $routine_class_time->restore();
            flash('Routine class time restored successfully.')->info();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while restoring the routine class time.')->error();
        }

        return redirect(route('routine-class-time.index', ['group_id' => $group_id, 'filter_by' => 'deleted-items', 'deleted-items' => 'Only Deleted']));
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
        $routine_class_time = RoutineClassTime::withTrashed()->where('group_id', $group_id)->find($id);

        try {
            $routine_class_time->forcedelete();
            flash('Routine class time deleted permanently.')->error();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while deleting the routine class time permanently.')->error();
        }

        return redirect(route('routine-class-time.index', ['group_id' => $group_id, 'filter_by' => 'deleted-items', 'deleted-items' => 'Only Deleted']));
    }
}
