<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Disciplinary extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $dates = [
        'issued_date',
        'review_date',
    ];

    public function employee()
    {
        return $this->belongsTo('App\Employee');
    }
}
