<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Meeting;
use Auth;
use Carbon\Carbon;

class MeetingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view_meetings', ['only' => ['index', 'show']]);
        $this->middleware('permission:add_meetings', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_meetings', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_meetings', ['only' => 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $meetings = Meeting::search(request('search-item'))
                      ->deletedItemFilter(request('deleted-items'))
                      ->meetingDateToFromSearch(request('from_meetingDate'), request('till_meetingDate'))
                      ->sort(request('criteria'))
                      ->orderBy('nepali_meeting_date', 'desc')
                      ->paginate(request('show-items') ? request('show-items') : config('pi-academy.table_paginate'));


        $total_meeting = Meeting::count();
               
        return view('backend.meeting.index', compact('meetings', 'total_meeting'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.meeting.create');
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
                'topic'                => 'required|string|max:255',
                'english_meeting_date' => 'required|date',
                'nepali_meeting_date'  => 'required|string',
                'meeting_start_time'   => 'required|string',
                'meeting_end_time'     => 'required|after:meeting_start_time|string',
                'discussed'            => 'nullable|min:2|max:65535',
                'meeting_file_id'      => 'nullable|mimes:jpg,png,jpeg,pdf|max:10240',
            ]
        );

        try {
            $meeting = Meeting::create(
                [
                    'topic'                => request('topic'),
                    'english_meeting_date' => request('english_meeting_date'),
                    'nepali_meeting_date'  => request('nepali_meeting_date'),
                    'meeting_start_time'   => request('meeting_start_time'),
                    'meeting_end_time'     => request('meeting_end_time'),
                    'discussed'            => request('discussed'),
                    'created_by'           => Auth::user()->id,
                    'updated_by'           => Auth::user()->id
                ]
            );

            if ($request->file('meeting_file_id')) {
                $file = $request->file('meeting_file_id');
                $meeting_file = saveFile($file, 'meeting', $meeting->id);
            }

            $meeting->update([
                'meeting_file_id' => isset($meeting_file->id) ? $meeting_file->id : null
            ]);

            flash('Meeting added successfully.')->success();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while adding the meeting.')->error();
        }

        return redirect(route('meeting.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $meeting = Meeting::withTrashed()->find($id);

        return view('backend.meeting.show', compact('meeting'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $meeting = Meeting::withTrashed()->find($id);

        return view('backend.meeting.edit', compact('meeting'));
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
        $meeting = Meeting::withTrashed()->find($id);

        $this->validate($request,
            [
                'topic'                => 'required|string|max:255',
                'english_meeting_date' => 'required|date',
                'nepali_meeting_date'  => 'required|string',
                'meeting_start_time'   => 'required|string',
                'meeting_end_time'     => 'required|after:meeting_start_time|string',
                'discussed'            => 'nullable|min:2|max:65535',
                'meeting_file_id'     => 'nullable|mimes:jpg,png,jpeg,pdf|max:10240',
            ]
        );

        try {
            if ($request->file('meeting_file_id')) {
                $file = $request->file('meeting_file_id');
                $meeting_file = saveFile($file, 'meeting', $meeting->id);
            }

            if(isset($meeting_file->id) && !empty($meeting->meeting_file_id)) {
                removeFile($meeting->meeting_file_id);
            }

            if (isset($meeting_file->id)) {
                $meeting->update(['meeting_file_id' => $meeting_file->id]);
            }

            $meeting->update([
                'topic'                => request('topic'),
                'english_meeting_date' => request('english_meeting_date'),
                'nepali_meeting_date'  => request('nepali_meeting_date'),
                'meeting_start_time'   => request('meeting_start_time'),
                'meeting_end_time'     => request('meeting_end_time'),
                'discussed'            => request('discussed'),
                'updated_by'           => Auth::user()->id
            ]);
            flash('Meeting updated successfully.')->info();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while updating the meeting.')->error();
        }

        return redirect(route('meeting.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $meeting = Meeting::find($id);

        try {
            $meeting->delete();
            flash('Meeting deleted successfully.')->error();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while deleting the meeting.')->error();
        }

        return redirect(route('meeting.index'));
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
        $meeting = Meeting::withTrashed()->find($id);

        try {
            $meeting->restore();
            flash('Meeting restored successfully.')->info();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while restoring the meeting.')->error();
        }

        return redirect(route('meeting.index', ['filter_by' => 'deleted-items', 'deleted-items' => 'Only Deleted']));
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
        $meeting = Meeting::withTrashed()->find($id);

        try {
            $meeting->forcedelete();
            flash('Meeting deleted permanently.')->error();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while deleting the meeting permanently.')->error();
        }

        return redirect(route('meeting.index', ['filter_by' => 'deleted-items', 'deleted-items' => 'Only Deleted']));
    }

    /**
     * Remove the specified file in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyFile($fileId)
    {
        $meeting = Meeting::withTrashed()->where('meeting_file_id', $fileId)->first();
        try {
            removeFile($fileId);
            $meeting->update(['meeting_file_id' => null]);

            return response()->json(['success' => true]);
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());    
        }
    }
}
