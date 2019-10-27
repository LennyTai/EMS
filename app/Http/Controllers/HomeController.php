<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\EmpChart;
use App\Employee;
use DB;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $employee = new Employee;
        $horizontalBar = new EmpChart;
        $bar = new EmpChart;

        $employees = Employee::where('job_status', 'PROBATION')
            ->where('confirmed_date', '<', Carbon::now()->subDays(-21))
            ->get();

        $nationality = Employee::select(DB::raw('count(nationality) as tot_emp'), 'nationality')
            ->where('job_status', 'JOINED')->orWhere('job_status', 'PROBATION')
            ->groupBy('nationality')->orderBy('tot_emp', 'DESC')
            ->get()->toArray();
        $nationality_tot = array_column($nationality, 'tot_emp');
        $nationality_label = array_column($nationality, 'nationality');

        $horizontalBar->title('Employee by Country')->labels($nationality_label);
        $dataset = $horizontalBar->dataset('Employees', 'horizontalBar', $nationality_tot)
            ->backgroundColor('rgba(90, 76, 88, 0.5)');

        $gender = Employee::select(DB::raw('count(gender) as tot_emp'), 'gender')
            ->where('job_status', 'JOINED')->orWhere('job_status', 'PROBATION')
            ->groupBy('gender')->orderBy('tot_emp', 'DESC')
            ->get()->toArray();
        $gender_tot = array_column($gender, 'tot_emp');
        $gender_label = array_column($gender, 'gender');

        $bar->title('Employee by gender')->labels($gender_label);
        $dataset = $bar->dataset('Employee by Gender', 'bar', $gender_tot)
            ->backgroundColor(['rgba(255, 0, 0, 0.5)', 'rgba(0, 224, 230, 0.5)']);

        return view('home', compact('employees', 'employee', 'horizontalBar', 'bar'));
    }
}
