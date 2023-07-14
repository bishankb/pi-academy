<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Attendence;
use App\User;
use Auth;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use App\Traits\DateConversionTrait;

class AttendenceController extends Controller
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
        $this->middleware('permission:view_staff_attendences', ['only' => ['staffList']]);
        $this->middleware('permission:view_attendences', ['only' => ['index', 'show']]);
        $this->middleware('permission:add_attendences', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_attendences', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_attendences', ['only' => 'destroy']);
    }

    public function staffList()
    {
        $staffs = User::whereHas('role', function ($r) {
                          $r->whereIn('name', config('pi-academy.attendence_designation'));
                        })
                        ->statusFilter(request('status'))
                        ->search(request('search-item'))
                        ->roleFilter(request('role'))
                        ->deletedItemFilter(request('deleted-items'))
                        ->roleFilter(request('role'))
                        ->sort(request('criteria'))
                        ->paginate(request('show-items') ? request('show-items') : config('pi-academy.table_paginate'));

        $roles = Role::select('name', 'display_name')->get();
        $total_staff = User::whereHas('role', function ($r) {
                          $r->whereIn('name', config('pi-academy.attendence_designation'));
                        })
                        ->count();
        $current_nepali_date = $this->currentNepaliDate();

        return view('backend.attendence.staff-list', compact('staffs', 'roles', 'total_staff', 'current_nepali_date'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($staff_id)
    {
        $attendences = Attendence::where('staff_id', $staff_id)
                      ->deletedItemFilter(request('deleted-items'))
                      ->attendenceStatusFilter(request('attendence-status'))
                      ->attendenceDateSearch(request('from_attendenceDate'), request('till_attendenceDate'))
                      ->sort(request('criteria'))
                      ->orderBy('nepali_attendence_date', 'desc')
                      ->paginate(request('show-items') ? request('show-items') : config('pi-academy.table_paginate'));

        $total_attendence = Attendence::where('staff_id', $staff_id)->count();
        $staff = User::find($staff_id);

        return view('backend.attendence.attendence-record.index', compact('attendences', 'staff', 'total_attendence'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($staff_id)
    {
        $staff = User::find($staff_id);
       
        return view('backend.attendence.attendence-record.create', compact('staff'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $staff_id)
    {

        if(isset($request->has_taken_leave)) {
            $this->validate($request,
                [
                    'english_attendence_date' => 'required|date',
                    'nepali_attendence_date'  => 'required|string',
                    'leave_reason'            => 'required|string|min:2|max:255',

                ]
            );
        } elseif(isset($request->is_holiday)) {
            $this->validate($request,
                [
                    'english_attendence_date' => 'required|date',
                    'nepali_attendence_date'  => 'required|string',
                    'holiday_reason'          => 'required|string|min:2|max:255',
                ]
            );
        } elseif(empty($request->has_taken_leave) && empty($request->is_holiday)) {
            $this->validate($request,
                [
                    'english_attendence_date' => 'required|date',
                    'nepali_attendence_date'  => 'required|string',
                    'arrival_time'            => 'required|string',
                    'departure_time'          => 'required|after:arrival_time|string',
                    'gap_departure_time'      => 'nullable|required_if:has_taken_gap,on|after:arrival_time|before:departure_time|string',
                    'gap_arrival_time'        => 'nullable|required_if:has_taken_gap,on|required_with:gap_departure_time|after:gap_departure_time|before:departure_time|string',
                    'gap_reason'              => 'nullable|string|min:2|max:255'
                ],
                [
                  'gap_departure_time.required_if' => 'The gap departure time field is required',
                  'gap_arrival_time.required_if' => 'The gap arrival time field is required'
                ]
            );
        }

        try {
            if(empty($request->has_taken_leave) && empty($request->is_holiday)) {
              $arrival_time = Carbon::parse(request('arrival_time'))->format('h:i a');
              $departure_time = Carbon::parse(request('departure_time'))->format('h:i a');
              $worked_hour = Carbon::parse($departure_time)->diffInHours(Carbon::parse($arrival_time));
              if(isset($request->gap_departure_time) && isset($request->gap_arrival_time)) {
                $gap_hour = Carbon::parse($request->gap_arrival_time)->diffInHours(Carbon::parse($request->gap_departure_time));
                $worked_hour = $worked_hour - $gap_hour;
              } else {
                $gap_departure_time = null;
                $gap_arrival_time = null;
              }
            } else {
              $arrival_time = null;
              $departure_time = null;
              $gap_departure_time = null;
              $gap_arrival_time = null;
              $worked_hour = 0;
            }

            $attendence = Attendence::create(
                [
                    'staff_id'                => $staff_id,
                    'english_attendence_date' => Carbon::parse(request('english_attendence_date'))->format('Y-m-d'),
                    'nepali_attendence_date'  => Carbon::parse(request('nepali_attendence_date'))->format('Y-m-d'),
                    'has_taken_leave'         => request('has_taken_leave') ? 1 : 0,
                    'leave_reason'            => request('leave_reason'),
                    'is_holiday'              => request('is_holiday') ? 1 : 0,
                    'holiday_reason'          => request('holiday_reason'),
                    'arrival_time'            => $arrival_time,
                    'departure_time'          => $departure_time,
                    'has_taken_gap'           => request('has_taken_gap') ? 1 : 0,
                    'gap_departure_time'      => isset($request->gap_departure_time) ? Carbon::parse(request('gap_departure_time'))->format('h:i a') : null,
                    'gap_arrival_time'        => isset($request->gap_arrival_time) ? Carbon::parse(request('gap_arrival_time'))->format('h:i a') : null,
                    'gap_reason'              => request('gap_reason'),
                    'worked_hour'             => $worked_hour,
                    'created_by'              => Auth::user()->id,
                    'updated_by'              => Auth::user()->id,
                ]
            );

            flash('Attendence detail added successfully.')->success();

        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while adding the attendence detail .')->error();
        }

        return redirect(route('attendence.index', $staff_id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($staff_id, $id)
    {
        $attendence = Attendence::withTrashed()->where('staff_id', $staff_id)->find($id);
        $staff = User::find($staff_id);

        return view('backend.attendence.attendence-record.show', compact('attendence', 'staff'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit( $staff_id, $id)
    {
        $attendence = Attendence::withTrashed()->where('staff_id', $staff_id)->find($id);
        $staff = User::find($staff_id);
       
        return view('backend.attendence.attendence-record.edit', compact('attendence', 'staff'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $staff_id, $id)
    {
        $attendence = Attendence::withTrashed()->where('staff_id', $staff_id)->find($id);

        if(isset($request->has_taken_leave)) {
            $this->validate($request,
                [
                    'english_attendence_date' => 'required|date',
                    'nepali_attendence_date'  => 'required|string',
                    'leave_reason'            => 'required|string|min:2|max:255',

                ]
            );
        } elseif(isset($request->is_holiday)) {
            $this->validate($request,
                [
                    'english_attendence_date' => 'required|date',
                    'nepali_attendence_date'  => 'required|string',
                    'holiday_reason'          => 'required|string|min:2|max:255',
                ]
            );
        } elseif(empty($request->has_taken_leave) && empty($request->is_holiday)) {
            $this->validate($request,
                [
                    'english_attendence_date' => 'required|date',
                    'nepali_attendence_date'  => 'required|string',
                    'arrival_time'            => 'required|string',
                    'departure_time'          => 'required|after:arrival_time|string',
                    'gap_departure_time'      => 'nullable|required_if:has_taken_gap,on|after:arrival_time|string',
                    'gap_arrival_time'        => 'nullable|required_if:has_taken_gap,on|required_with:gap_departure_time|after:gap_departure_time|before:departure_time|string',
                    'gap_reason'              => 'nullable|string|min:2|max:255'
                ],
                [
                  'gap_departure_time.required_if' => 'The gap departure time field is required',
                  'gap_arrival_time.required_if' => 'The gap arrival time field is required'
                ]
            );
        }

        try {
            if(empty($request->has_taken_leave) && empty($request->is_holiday)) {
              $arrival_time = Carbon::parse(request('arrival_time'))->format('h:i a');
              $departure_time = Carbon::parse(request('departure_time'))->format('h:i a');
              $worked_hour = Carbon::parse($departure_time)->diffInHours(Carbon::parse($arrival_time));
              if(isset($request->gap_departure_time) && isset($request->gap_arrival_time)) {
                $gap_hour = Carbon::parse($request->gap_arrival_time)->diffInHours(Carbon::parse($request->gap_departure_time));
                $worked_hour = $worked_hour - $gap_hour;
              } else {
                $gap_departure_time = null;
                $gap_arrival_time = null;
              }
            } else {
              $arrival_time = null;
              $departure_time = null;
              $gap_departure_time = null;
              $gap_arrival_time = null;
              $worked_hour = 0;
            }

          
            $attendence->update([
                'english_attendence_date' => Carbon::parse(request('english_attendence_date'))->format('Y-m-d'),
                'nepali_attendence_date'  => Carbon::parse(request('nepali_attendence_date'))->format('Y-m-d'),
                'has_taken_leave'         => request('has_taken_leave') ? 1 : 0,
                'leave_reason'            => request('leave_reason'),
                'is_holiday'              => request('is_holiday') ? 1 : 0,
                'holiday_reason'          => request('holiday_reason'),
                'arrival_time'            => $arrival_time,
                'departure_time'          => $departure_time,
                'has_taken_gap'           => request('has_taken_gap') ? 1 : 0,
                'gap_departure_time'      => isset($request->gap_departure_time) ? Carbon::parse(request('gap_departure_time'))->format('h:i a') : null,
                    'gap_arrival_time'    => isset($request->gap_arrival_time) ? Carbon::parse(request('gap_arrival_time'))->format('h:i a') : null,
                'gap_reason'              => request('gap_reason'),
                'worked_hour'             => $worked_hour,
                'updated_by'              => Auth::user()->id,
            ]);

            flash('Attendence detail updated successfully.')->info();

        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while updating the attendence detail.')->error();
        }

        return redirect(route('attendence.index', $staff_id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($staff_id, $id)
    {
        $attendence = Attendence::withTrashed()->where('staff_id', $staff_id)->find($id);

        try {
            $attendence->delete();
            flash('Attendence detail deleted successfully.')->error();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while deleting the attendence detail.')->error();
        }

        return redirect(route('attendence.index', $staff_id));
    }

    /**
     * Restore the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($staff_id, $id)
    {
        $attendence = Attendence::withTrashed()->where('staff_id', $staff_id)->find($id);

        try {
            $attendence->restore();
            flash('Attendence detail restored successfully.')->info();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while restoring the attendence detail.')->error();
        }

        return redirect(route('attendence.index', ['staff_id' => $staff_id, 'filter_by' => 'deleted-items', 'deleted-items' => 'Only Deleted']));
    }

    /**
     * Force remove the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function forceDestroy($staff_id, $id)
    {
        $attendence = Attendence::withTrashed()->where('staff_id', $staff_id)->find($id);

        try {
            $attendence->forcedelete();
            flash('Attendence detail deleted permanently.')->error();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while deleting the attendence detail permanently.')->error();
        }

        return redirect(route('attendence.index', ['staff_id' => $staff_id, 'filter_by' => 'deleted-items', 'deleted-items' => 'Only Deleted']));
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
