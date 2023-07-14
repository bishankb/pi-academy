<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\StudentPaymentHistory;
use App\StudentRegistration;
use App\User;
use Auth;
use Carbon\Carbon;

class StudentPaymentHistoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view_student_payment_histories', ['only' => ['index', 'show']]);
        $this->middleware('permission:add_student_payment_histories', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_student_payment_histories', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_student_payment_histories', ['only' => 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($student_id)
    {
        $payment_histories = StudentPaymentHistory::where('student_id', $student_id)
                      ->search(request('search-item'))
                      ->deletedItemFilter(request('deleted-items'))
                      ->sort(request('criteria'))
                      ->paymentDateSearch(request('from_paymentDate'), request('till_paymentDate'))
                      ->latest()
                      ->paginate(request('show-items') ? request('show-items') : config('pi-academy.table_paginate'));

        $student_registration = StudentRegistration::find($student_id);
        $total_payment_history = StudentPaymentHistory::where('student_id', $student_id)->count();

        $total_paid = StudentPaymentHistory::where('student_id', $student_id)->sum('payment_amount');
        $due = $student_registration->fee_after_scholarship - $total_paid;

        return view('backend.student-registration.payment-history.index', compact('payment_histories', 'student_registration', 'total_payment_history', 'total_paid', 'due'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($student_id)
    {
        $student_registration = StudentRegistration::find($student_id);
        $users = User::whereHas('role', function ($r) {
                                $r->whereIn('name', config('pi-academy.student_fee_receiver'));
                            })->pluck('name', 'id');

        return view('backend.student-registration.payment-history.create', compact('student_registration', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $student_id)
    {
        $student_registration = StudentRegistration::find($student_id);
        $total_paid = $student_registration->paymentHistories->sum('payment_amount');
        $due = $student_registration->fee_after_scholarship - $total_paid;

        $this->validate($request,
            [
                'payment_amount'       => 'required|numeric|max:'.$due,
                'english_payment_date' => 'required|date',
                'nepali_payment_date'  => 'required|string',
                'payment_time'         => 'nullable|string',
                'receipt_number'       => 'required|string|min:2|max:255',
                'received_by'          => 'nullable|numeric',
                'remarks'              => 'nullable|min:2|max:65535',
            ]
        );

        try {
            $payment_history = StudentPaymentHistory::create(
                [
                    'student_id'           => $student_id,
                    'payment_amount'       => request('payment_amount'),
                    'english_payment_date' => Carbon::parse(request('english_payment_date'))->format('Y-m-d'),
                    'nepali_payment_date'  => Carbon::parse(request('nepali_payment_date'))->format('Y-m-d'),
                    'payment_time'         => isset($request->payment_time) ? Carbon::parse(request('payment_time'))->format('h:i a') : null,
                    'receipt_number'       => request('receipt_number'),
                    'received_by'          => request('received_by'),
                    'remarks'              => request('remarks'),
                    'created_by'           => Auth::user()->id,
                    'updated_by'           => Auth::user()->id,
                ]
            );

            flash('Payment added successfully.')->success();

        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while adding the payment .')->error();
        }

        return redirect(route('student-payment-history.index', $student_id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($student_id, $id)
    {
        $payment_history = StudentPaymentHistory::withTrashed()->where('student_id', $student_id)->find($id);
        $student_registration = StudentRegistration::find($student_id);

        return view('backend.student-registration.payment-history.show', compact('payment_history', 'student_registration'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($student_id, $id)
    {
        $payment_history = StudentPaymentHistory::withTrashed()->where('student_id', $student_id)->find($id);
        $users = User::whereHas('role', function ($r) {
                            $r->whereIn('name', config('pi-academy.student_fee_receiver'));
                        })->pluck('name', 'id');
        $student_registration = StudentRegistration::find($student_id);

        return view('backend.student-registration.payment-history.edit', compact('student_registration', 'payment_history', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $student_id, $id)
    {
        $payment_history = StudentPaymentHistory::withTrashed()->where('student_id', $student_id)->find($id);

        $student_registration = StudentRegistration::find($student_id);

        $this->validate($request,
             [
                'payment_amount'       => 'required|numeric',
                'english_payment_date' => 'required|date',
                'nepali_payment_date'  => 'required|string',
                'payment_time'         => 'nullable|string',
                'receipt_number'       => 'required|string|min:2|max:255',
                'received_by'          => 'nullable|numeric',
                'remarks'              => 'nullable|min:2|max:65535',
            ]
        );

        try {
            $payment_history->update([
                'payment_amount'       => request('payment_amount'),
                'english_payment_date' => Carbon::parse(request('english_payment_date'))->format('Y-m-d'),
                'nepali_payment_date'  => Carbon::parse(request('nepali_payment_date'))->format('Y-m-d'),
                'payment_time'         => isset($request->payment_time) ? Carbon::parse(request('payment_time'))->format('h:i a') : null,
                'receipt_number'       => request('receipt_number'),
                'received_by'          => request('received_by'),
                'remarks'              => request('remarks'),
                'updated_by'           => Auth::user()->id
            ]);
            flash('Payment updated successfully.')->info();

        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while updating the payment .')->error();
        }

        return redirect(route('student-payment-history.index', $student_id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($student_id, $id)
    {
        $payment_history = StudentPaymentHistory::where('student_id', $student_id)->find($id);

        try {
            $payment_history->delete();
            flash('Payment deleted successfully.')->error();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while deleting the payment .')->error();
        }

        return redirect(route('student-payment-history.index', $student_id));
    }

    /**
     * Restore the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($student_id, $id)
    {
        $payment_history = StudentPaymentHistory::where('student_id', $student_id)->withTrashed()->find($id);

        try {
            $payment_history->restore();
            flash('Payment restored successfully.')->info();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while restoring the payment .')->error();
        }

        return redirect(route('student-payment-history.index', ['student_id' => $student_id, 'filter_by' => 'deleted-items', 'deleted-items' => 'Only Deleted']));
    }

    /**
     * Force remove the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function forceDestroy($student_id, $id)
    {
        $payment_history = StudentPaymentHistory::where('student_id', $student_id)->withTrashed()->find($id);

        try {
            $payment_history->forcedelete();
            flash('Payment deleted permanently.')->error();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while deleting the payment permanently.')->error();
        }

        return redirect(route('student-payment-history.index', ['student_id' => $student_id, 'filter_by' => 'deleted-items', 'deleted-items' => 'Only Deleted']));
    }
}
