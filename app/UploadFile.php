<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UploadFile extends Model
{
    // Mass Assign
    protected $guarded = [];

    // One to Many Inverse
    public function employee()
    {
        return $this->belongsTo('App\Employee');
    }
}
