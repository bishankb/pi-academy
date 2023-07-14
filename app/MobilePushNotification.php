<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MobilePushNotification extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
		'title',
        'description',
		'message'
    ];

    protected $dates = ['created_at', 'updated_at'];
}
