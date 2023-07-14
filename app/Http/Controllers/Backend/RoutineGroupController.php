<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\RoutineGroup;
use Auth;
use Carbon\Carbon;

class RoutineGroupController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view_routine_groups', ['only' => ['index', 'show']]);
        $this->middleware('permission:add_routine_groups', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_routine_groups', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_routine_groups', ['only' => 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $routine_groups = RoutineGroup::search(request('search-item'))
                      ->deletedItemFilter(request('deleted-items'))
                      ->sort(request('criteria'))
                      ->orderBy('order')
                      ->paginate(request('show-items') ? request('show-items') : config('pi-academy.table_paginate'));


        $shifts = RoutineGroup::Shift;
        $total_routine_group = RoutineGroup::count();
               
        return view('backend.routine-group.index', compact('routine_groups', 'shifts', 'total_routine_group'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $shifts = RoutineGroup::Shift;

        return view('backend.routine-group.create', compact('shifts'));
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
                'name'        => 'required|string|max:255|unique:routine_groups,name',
                'shift'       => 'required|integer',
                'order'       => 'required|integer|unique:routine_groups,order',
                'description' => 'nullable|min:1|max:65535',
            ]
        );

        try {
            $routine_group = RoutineGroup::create(
                [
                    'name'        => request('name'),
                    'shift'       => request('shift'),
                    'order'       => request('order'),
                    'description' => request('description'),
                    'created_by'  => Auth::user()->id,
                    'updated_by'  => Auth::user()->id
                ]
            );
            flash('Routine group added successfully.')->success();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while adding the routine group.')->error();
        }

        return redirect(route('routine-groups.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $routine_group = RoutineGroup::withTrashed()->find($id);
        $shifts = RoutineGroup::Shift;

        return view('backend.routine-group.show', compact('routine_group', 'shifts'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $routine_group = RoutineGroup::withTrashed()->find($id);
        $shifts = RoutineGroup::Shift;

        return view('backend.routine-group.edit', compact('routine_group', 'shifts'));
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
        $routine_group = RoutineGroup::withTrashed()->find($id);

        $this->validate($request,
            [
                'name'        => 'required|string|max:255|unique:routine_groups,name,'.$routine_group->id,
                'shift'       => 'required|integer',
                'order'       => 'required|integer|unique:routine_groups,order,'.$routine_group->id,
                'order'       => 'required|integer|unique:routine_groups,order,'.$id.',id'.$routine_group->group_id,
                'description' => 'nullable|min:1|max:65535'
            ]
        );

        try {
            $routine_group->update([
                'name'        => request('name'),
                'shift'       => request('shift'),
                'order'       => request('order'),
                'description' => request('description'),
                'created_by'  => Auth::user()->id,
                'updated_by'  => Auth::user()->id
            ]);
            flash('Routine group updated successfully.')->info();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while updating the routine group.')->error();
        }

        return redirect(route('routine-groups.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $routine_group = RoutineGroup::find($id);

        try {
            $routine_group->delete();
            flash('Routine group deleted successfully.')->error();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while deleting the routine group.')->error();
        }

        return redirect(route('routine-groups.index'));
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
        $routine_group = RoutineGroup::withTrashed()->find($id);

        try {
            $routine_group->restore();
            flash('Routine group restored successfully.')->info();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while restoring the routine group.')->error();
        }

        return redirect(route('routine-groups.index', ['filter_by' => 'deleted-items', 'deleted-items' => 'Only Deleted']));
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
        $routine_group = RoutineGroup::withTrashed()->find($id);

        try {
            $routine_group->forcedelete();
            flash('Routine group deleted permanently.')->error();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while deleting the routine group permanently.')->error();
        }

        return redirect(route('routine-groups.index', ['filter_by' => 'deleted-items', 'deleted-items' => 'Only Deleted']));
    }
}
