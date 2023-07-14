<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{  
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'filename', 'original_filename', 'extension', 'mime', 'type', 'file_size'
    ];

}
