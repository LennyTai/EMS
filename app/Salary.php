<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use App\Department;

class Salary extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $dates = [
        'date',
        'deleted_at'
    ];

    public function employee()
    {
        return $this->belongsTo('App\Employee');
    }
}