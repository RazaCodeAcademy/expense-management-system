<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{
    Logbook,
    Employee
};

use Auth;

class LogbookController extends Controller
{
    public function index(){
        $logbooks = Logbook::orderBy('id', 'desc')->where('user_id', Auth::Id())->get();
        return view('logbooks.index', compact('logbooks'));
    }

    public function employee_logbook(){
        $employees = Employee::orderBy('name', 'asc')->get();
        $logbooks = Logbook::orderBy('id', 'desc')->get();
        return view('logbooks.employee_index', compact('logbooks', 'employees'));
    }

    public function single_employee_logbook($id){
        $employees = Employee::orderBy('name', 'asc')->get();
        $logbooks = Logbook::orderBy('id', 'desc')->where('user_id', $id)->get();
        return view('logbooks.employee_index', compact('logbooks', 'employees'));
    }
}
