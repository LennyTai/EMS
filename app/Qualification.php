<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Qualification extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $dates = [
        'graduated_date',
        'deleted_at'
    ];

    public function employee()
    {
        return $this->belongsTo('App\Employee');
    }
}
