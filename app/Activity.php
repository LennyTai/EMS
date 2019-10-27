<?php
 
namespace App;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Activity extends Model
{
    use SoftDeletes;
	protected $table = 'activity_log';
	protected $fillable = ['*'];
    protected $guarded = [];

	public function getUser()
	{
		return $this->hasOne('App\User','id','causer_id');
	}

	public function getSubject()
	{
		return $this->hasOne('App\User','id','subject_id');
	}

	public function getName()
	{
		if (substr($this->subject_type, 4, ) === 'Employee') {
			$emp_id = $this->subject_id;
			$name = Employee::where('id', $emp_id)->first();
			return $name->name;
		} else {
			$table = str_plural(substr($this->subject_type, 4, ));
			$table_id = $this->subject_id;
			if ($table === 'Departments') {
				$name = DB::table($table)->select('dpt_name')->where('id', $table_id)->first();
				print_r(isset($name) ? $name->dpt_name : $table);
			} elseif ($table === 'Grants') {
				$name = DB::table($table)->select('program', 'employee_id')->where('id', $table_id)->first();
				if (isset($name)) {
					$emp_name = Employee::where('id', $name->employee_id)->first();
					print_r($emp_name->name .' - '.$name->program);
				} else {
					return $table;
				}
			} elseif ($table === 'UploadFiles') {
				$tables = 'upload_files';
				$emp_id = DB::table($tables)->select('employee_id')->where('id', $table_id)->first();
				$name = Employee::where('id', $emp_id->employee_id)->first();
				print_r(isset($name) ? $name->name : $table);
			} elseif ($table === 'GrantPayments') {
				$tables = 'grant_payments';
				$name = DB::table('grants')
					->leftJoin($tables, 'grant_id', '=', 'grants.id')
					->leftJoin('employees', 'employee_id', '=', 'employees.id')
					->select('name')
					->where('grants.id', $table_id)
					->first();
				print_r(isset($name) ? $name->name : $table);
			} elseif ($table === 'Equipment') {
				$tables = 'equipments';
				$emp_id = DB::table($tables)->select('employee_id')->where('id', $table_id)->first();
				$name = Employee::where('id', $emp_id->employee_id)->first();
				print_r(isset($name) ? $name->name : $table);
			} else {
				$tables = strtolower($table);
				$emp_id = DB::table($tables)->select('employee_id')->where('id', $table_id)->first();
				$name = Employee::where('id', $emp_id->employee_id)->first();
				print_r(isset($name) ? $name->name : $table);
			}
		}
	}

	public function getModule()
	{
		return substr($this->subject_type, 4, );
	}
}