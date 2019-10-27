<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Equitment extends Model
{
    use SoftDeletes;
	// Mass Assign
    protected $guarded = [];

    protected $dates = [
        'issued_date',
        'return_date'
    ];

    // One to Many Inverse
    public function employee()
    {
        return $this->belongsTo('App\Employee');
    }
}
