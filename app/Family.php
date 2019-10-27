<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Family extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $dates = [
        'family_dob',
        'deleted_at'
    ];

    public function employee()
    {
        return $this->belongsTo('App\Employee');
    }

    public function getAge()
    {
        return $this->family_dob->diff(Carbon::now())->format('%y');
    }
}