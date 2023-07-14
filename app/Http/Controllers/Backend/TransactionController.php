<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Transaction;
use App\User;
use Auth;
use Carbon\Carbon;

class TransactionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view_transactions', ['only' => ['index', 'show']]);
        $this->middleware('permission:add_transactions', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_transactions', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_transactions', ['only' => 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactions = Transaction::search(request('search-item'))
                      ->deletedItemFilter(request('deleted-items'))
                      ->transactionTypeFilter(request('transaction-type'))
                      ->paymentTypeFilter(request('payment-type'))
                      ->sort(request('criteria'))
                      ->transactionPeriodSearch(request('from_transactionPeriod'), request('till_transactionPeriod'))
                      ->paymentAmountSearch(request('min_paymentAmount'), request('max_paymentAmount'))
                      ->latest()
                      ->paginate(request('show-items') ? request('show-items') : config('pi-academy.table_paginate'));

        $transaction_types = Transaction::TransactionType;
        $payment_types = Transaction::PaymentType;

        $total_transaction = Transaction::count();
               
        return view('backend.transaction.index', compact('transactions', 'transaction_types', 'payment_types', 'total_transaction'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $transaction_types = Transaction::TransactionType;
        $payment_types = Transaction::PaymentType;
        $users = User::whereHas('role', function ($r) {
                                $r->whereIn('name', config('pi-academy.transaction_person'));
                            })->pluck('name', 'id');

        return view('backend.transaction.create', compact('transaction_types', 'payment_types', 'users'));
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
                'transaction_type'         => 'required|integer',
                'english_transaction_date' => 'required|date',
                'nepali_transaction_date'  => 'required|string',
                'transaction_time'         => 'nullable|string',
                'payment_amount'           => 'required|numeric|min:1',
                'payment_type'             => 'required|integer',
                'cheque_number'            => 'nullable|required_if:payment_type,1|integer',
                'expend_by'                => 'nullable|required_if:transaction_type,0|integer',
                'paid_by'                  => 'nullable|required_if:transaction_type,1|min:2|max:100',
                'remarks'                  => 'nullable|min:2|max:65535',
            ],
            [
                'payment_amount.regex'      => 'The payment amount field must be number with or without comma.',
                'expend_by.required_if'     => 'The expend by field is required.',
                'paid_by.required_if'       => 'The paid by field is required.',
                'cheque_number.required_if' => 'The cheque number field is required.'
            ]
        );

        try {
            $transaction = Transaction::create(
                [
                    'transaction_id'           => $this->generateRandomNumber(),
                    'transaction_type'         => request('transaction_type'),
                    'english_transaction_date' => Carbon::parse(request('english_transaction_date'))->format('Y-m-d'),
                    'nepali_transaction_date'  => Carbon::parse(request('nepali_transaction_date'))->format('Y-m-d'),
                    'transaction_time'         => isset($request->transaction_time) ? Carbon::parse(request('transaction_time'))->format('h:i a') : null,
                    'payment_amount'           => str_replace( ',', '', request('payment_amount') ),
                    'payment_type'             => request('payment_type'),
                    'cheque_number'            => request('cheque_number'),
                    'expend_by'                => request('expend_by'),
                    'paid_by'                  => request('paid_by'),
                    'remarks'                  => request('remarks'),
                    'created_by'               => Auth::user()->id,
                    'updated_by'               => Auth::user()->id
                ]
            );
            flash('Transaction added successfully.')->success();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while adding the transaction .')->error();
        }

        return redirect(route('transactions.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $transaction = Transaction::withTrashed()->find($id);

        return view('backend.transaction.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $transaction = Transaction::withTrashed()->find($id);

        $transaction_types = Transaction::TransactionType;
        $payment_types = Transaction::PaymentType;
        $users = User::whereHas('role', function ($r) {
                                $r->whereIn('name', config('pi-academy.transaction_person'));
                            })->pluck('name', 'id');

        return view('backend.transaction.edit', compact('transaction', 'transaction_types', 'payment_types', 'users'));
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
        $transaction = Transaction::withTrashed()->find($id);

        $this->validate($request,
            [
                'transaction_type'         => 'required|integer',
                'english_transaction_date' => 'required|date',
                'nepali_transaction_date'  => 'required|string',
                'transaction_time'         => 'nullable|string',
                'payment_amount'           => 'required|numeric|min:1',
                'payment_type'             => 'required|integer',
                'cheque_number'            => 'nullable|required_if:payment_type,1|integer',
                'expend_by'                => 'nullable|required_if:transaction_type,0|integer',
                'paid_by'                  => 'nullable|required_if:transaction_type,1|min:2|max:100',
                'remarks'                  => 'nullable|min:2|max:65535',
            ],
            [
                'payment_amount.regex'      => 'The payment amount field must be number with or without comma.',
                'expend_by.required_if'     => 'The expend by field is required.',
                'paid_by.required_if'       => 'The paid by field is required.',
                'cheque_number.required_if' => 'The cheque number field is required.'
            ]
        );

        try {
            $transaction->update([
                'transaction_type'         => request('transaction_type'),
                'english_transaction_date' => Carbon::parse(request('english_transaction_date'))->format('Y-m-d'),
                'nepali_transaction_date'  => Carbon::parse(request('nepali_transaction_date'))->format('Y-m-d'),
                'transaction_time'         => isset($request->transaction_time) ? Carbon::parse(request('transaction_time'))->format('h:i a') : null,
                'payment_amount'           => request('payment_amount'),
                'payment_type'             => request('payment_type'),
                'cheque_number'            => request('cheque_number'),
                'expend_by'                => request('expend_by'),
                'paid_by'                  => request('paid_by'),
                'remarks'                  => request('remarks'),
                'updated_by'               => Auth::user()->id
            ]);
            flash('Transaction updated successfully.')->info();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while updating the transaction .')->error();
        }

        return redirect(route('transactions.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $transaction = Transaction::find($id);

        try {
            $transaction->delete();
            flash('Transaction deleted successfully.')->error();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while deleting the transaction .')->error();
        }

        return redirect(route('transactions.index'));
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
        $transaction = Transaction::withTrashed()->find($id);

        try {
            $transaction->restore();
            flash('Transaction restored successfully.')->info();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while restoring the transaction .')->error();
        }

        return redirect(route('transactions.index', ['filter_by' => 'deleted-items', 'deleted-items' => 'Only Deleted']));
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
        $transaction = Transaction::withTrashed()->find($id);

        try {
            $transaction->forcedelete();
            flash('Transaction deleted permanently.')->error();
        } catch (\Exception $exception) {
            logger()->error($exception->getMessage());
            flash('There was some intenal error while deleting the transaction  permanently.')->error();
        }

        return redirect(route('transactions.index', ['filter_by' => 'deleted-items', 'deleted-items' => 'Only Deleted']));
    }

    /**
     * Generate Random Number.
     *
    */
    private function generateRandomNumber() {
        $number = mt_rand(10000, mt_getrandmax());

        if ($this->randomNumberExists($number) && $number > $number + 23) {
            return generateRandomNumber();
        }

        return $number;
    }

    private function randomNumberExists($number) {
        return Transaction::where('transaction_id', $number)->exists();
    }
}
