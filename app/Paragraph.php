<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;

class Paragraph extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'question_set_id',
		'paragraph'
    ];
}
