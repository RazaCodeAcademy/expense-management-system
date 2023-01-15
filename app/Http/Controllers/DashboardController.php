<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Accunity\Utils;
use App\Models\Bill;
use App\Models\Employee;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\Job;
use App\Models\Payment;
use App\Models\ReceivedDoc;
use App\Models\ReturnableListDoc;
use App\Models\SiteCompletionDoc;
use App\Models\SubmittedDoc;
use App\Models\Voucher;
use App\Models\Logbook;
use Carbon\Carbon;
use Exception;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $approval = 0;
        $approved = 0;
        $payments = 0;
        $total_vouchers = 0;
        $employees = [];
        if(request()->ajax()){
            $from = request()->from;
            $to = request()->to;

            $approval = Voucher::where('status', 1)->whereBetween('created_at', [$from, $to])->count();
            $approved = Voucher::where('status', 2)->whereBetween('created_at', [$from, $to])->count();
            $payments = Payment::whereBetween('created_at', [$from, $to])->sum('amount');
            if(!auth()->user()->is_admin){
                $total_vouchers = auth()->user()->employee->vouchers()->whereBetween('created_at', [$from, $to])->count();

            }

            return response()->json([
                'approval'          => $approval,
                'approved'          => $approved,
                'payments'          => $payments,
                'total_vouchers'    => $total_vouchers,
            ]);
        }

        if(auth()->user()->is_admin) {
            $approval = Voucher::orderBy('id', 'desc')
            ->where('status', 1)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();

            $approved = Voucher::orderBy('id', 'desc')
            ->where('status', 2)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();

            $employees = Employee::whereMonth('expiry_date', Carbon::now()->month)->get();

            $payments = Payment::whereMonth('created_at', Carbon::now()->month)
            ->sum('amount');
        }else{
            $total_vouchers = auth()->user()->employee->vouchers()->whereMonth('created_at', Carbon::now()->month)
            ->count();
        }

        return view('dashboard.index', compact('approval', 'approved', 'payments', 'total_vouchers', 'employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
