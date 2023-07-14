<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\BaseModel;
use Carbon\Carbon;

class Transaction extends BaseModel
{   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'transaction_id',
        'transaction_type',
        'english_transaction_date',
        'nepali_transaction_date',
        'transaction_time',
        'payment_amount',
        'payment_type',
        'cheque_number',
        'expend_by',
        'paid_by',
        'remarks',        
        'created_by',        
        'updated_by',        
    ];


    const TransactionType = [
        'Expenditure',
        'Income',
    ];

    const PaymentType = [
        'Cash',
        'Cheque',
    ];

    public function expendBy()
    {
        return $this->belongsTo(User::class, 'expend_by');
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('transaction_id', 'like', '%' . $search . '%')
                    ->OrWhere('cheque_number', 'like', '%' . $search . '%')
                    ->OrWhere('paid_by', 'like', '%' . $search . '%')
                    ->OrWhere('cheque_number', 'like', '%' . $search . '%')
                    ->OrWhereHas('expendBy', function ($r) use ($search) {
                        $r->where('name', 'like', '%' . $search . '%');
                    });
    }

    public function scopeTransactionTypeFilter($query, $filter)
    {
        if ($filter) {
            return $query->where('transaction_type', array_flip(self::TransactionType)[$filter]);
        }

        return $query;
    }

    public function scopePaymentTypeFilter($query, $filter)
    {
        if ($filter) {
            return $query->where('payment_type', array_flip(self::PaymentType)[$filter]);
        }

        return $query;
    }

    /**
     *Sort By transaction period, payment amount
     *
     */
    public function scopeSort($query, $filter)
    {
        if ($filter) {
            if ($filter == "transactionPeriod-low-high") {
                return $query->orderBy('nepali_transaction_date', 'asc')->orderBy('transaction_time', 'asc');
            } elseif($filter == "transactionPeriod-high-low") {
                return $query->orderBy('nepali_transaction_date', 'desc')->orderBy('transaction_time', 'desc');
            } elseif ($filter == "paymentAmount-low-high") {
                return $query->orderBy('payment_amount', 'asc');
            } elseif ($filter == "paymentAmount-high-low") {
                return $query->orderBy('payment_amount', 'desc');
            }
        }

        return $query;
    }

    public function scopeTransactionPeriodSearch($query, $from_transactionPeriod, $till_transactionPeriod)
    {   
        if($from_transactionPeriod && $till_transactionPeriod) {
             $query->whereBetween('nepali_transaction_date', [Carbon::parse($from_transactionPeriod) , Carbon::parse($till_transactionPeriod)]);
        } elseif ($from_transactionPeriod && !$till_transactionPeriod) {
            $query = $query->where('nepali_transaction_date', '>=', Carbon::parse($from_transactionPeriod));
        } elseif (!$from_transactionPeriod && $till_transactionPeriod) {
            $query = $query->where('nepali_transaction_date', '<=', Carbon::parse($till_transactionPeriod));
        }
        return $query;
    }

    public function scopePaymentAmountSearch($query, $min_paymentAmount, $max_paymentAmount)
    {   
        if($min_paymentAmount && $max_paymentAmount) {
             $query->whereBetween('payment_amount', [$min_paymentAmount , $max_paymentAmount]);
        } elseif ($min_paymentAmount && !$max_paymentAmount) {
            $query = $query->where('payment_amount', '>=', $min_paymentAmount);
        } elseif (!$min_paymentAmount && $max_paymentAmount) {
            $query = $query->where('payment_amount', '<=', $max_paymentAmount);
        }
        return $query;
    }
}