<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Activity;

class ActivityController extends Controller
{
    public function index()
    {
		$activities = Activity::all();

       	return view('activities.index', compact('activities'));
    }
}