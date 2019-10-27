<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Equipment extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $table = 'equipments';

    protected $dates = [
        'issued_date',
        'return_date'
    ];

    public function employee()
    {
        return $this->belongsTo('App\Employee');
    }
}
