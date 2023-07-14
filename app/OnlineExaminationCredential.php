<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ExamResetPasswordNotification;

class OnlineExaminationCredential extends Authenticatable
{
  use Notifiable;
  use SoftDeletes;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
     'student_id',
     'email',
     'username',
     'password',
     'registration_number',
     'active',
     'is_client',
     'verification_token',
     'verified'
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
      'remember_token',
  ];

  protected $dates = ['created_at','updated_at', 'deleted_at'];

  public function student()
  {
      return $this->belongsTo(StudentRegistration::class, 'student_id')->withTrashed();
  }

  public function sendPasswordResetNotification($token)
  {
      $this->notify(new ExamResetPasswordNotification($token));
  }

  /**
   *Filter by status.
   *
   */
  public function scopeStatusFilter($query, $filter)
  {
      if ($filter) {
          return $query->where('verified', $filter == 'Active' ? 1 : 0);
      }

      return $query;
  }

  /**
   *Filter by deleted items.
   *
   */
  public function scopeDeletedItemFilter($query, $filter)
  {
    if ($filter) {
        if ($filter == "Only Deleted") {
            return $query->onlyTrashed();
        } else {
            return $query->withTrashed();
        }
        
    }

    return $query;
  }

  public function scopeSearch($query, $search)
    {
      return $query->where('username', 'like', '%' . $search . '%')
                  ->OrWhere('email', 'like', '%' . $search . '%');
    }

    public function scopeSort($query, $filter)
    {
        if ($filter) {
            if ($filter == "username-low-high") {
                return $query->orderBy('username', 'asc');
            } elseif($filter == "username-high-low") {
                return $query->orderBy('username', 'desc');
            }
        }

        return $query;
    }
}
