<?php

namespace App;

use App\BaseModel;
use Carbon\Carbon;

class StudentPaymentHistory extends BaseModel
{   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'student_id',
		'payment_amount',
        'english_payment_date',
        'nepali_payment_date',
        'payment_time',
		'receipt_number',
		'received_by',
		'remarks',
		'created_by',
        'updated_by'
    ];

    public function student()
    {
        return $this->belongsTo(StudentRegistration::class, 'student_id')->withTrashed();
    }

    public function receivedBy()
    {
        return $this->belongsTo(User::class, 'received_by');
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('receipt_number', 'like', '%' . $search . '%')
                    ->OrWhereHas('receivedBy', function ($r) use ($search) {
                        $r->where('name', 'like', '%' . $search . '%');
                    });
    }

    public function scopeSort($query, $filter)
    {
        if ($filter) {
            if($filter == "paymentAmount-low-high") {
                return $query->orderBy('payment_amount', 'asc');
            } elseif ($filter == "paymentAmount-high-low") {
                return $query->orderBy('payment_amount', 'desc');
            } elseif($filter == "paymentDate-low-high") {
                return $query->orderBy('nepali_payment_date', 'asc')->orderBy('payment_time', 'asc');
            } elseif ($filter == "paymentDate-high-low") {
                return $query->orderBy('nepali_payment_date', 'desc')->orderBy('payment_time', 'desc');
            } elseif ($filter == "receiptNumber-low-high") {
                return $query->orderBy('receipt_number', 'asc');
            } elseif($filter == "receiptNumber-high-low") {
                return $query->orderBy('receipt_number', 'desc');
            }
        }

        return $query;
    }

    public function scopePaymentDateSearch($query, $from_paymentDate, $till_paymentDate)
    {   
        if($from_paymentDate && $till_paymentDate) {
             $query->whereBetween('nepali_payment_date', [Carbon::parse($from_paymentDate) , Carbon::parse($till_paymentDate)]);
        } elseif ($from_paymentDate && !$till_paymentDate) {
            $query = $query->where('nepali_payment_date', '>=', Carbon::parse($from_paymentDate));
        } elseif (!$from_paymentDate && $till_paymentDate) {
            $query = $query->where('nepali_payment_date', '<=', Carbon::parse($till_paymentDate));
        }
        return $query;
    }
}
