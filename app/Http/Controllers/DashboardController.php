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
        $rejected = 0;
        $drafted  = 0;
        $payments = 0;
        $total_vouchers = 0;
        $employees = [];
        if(request()->ajax()){
            $from = request()->from;
            $to = request()->to;

            if(auth()->user()->is_admin == 1){
                $approval = Voucher::where('status', 1)->where('is_manager_approved', 1)->whereBetween('created_at', [$from, $to])->count();
                $approved = Voucher::where('status', 2)->where('is_manager_approved', 1)->whereBetween('created_at', [$from, $to])->count();
            }else{
                $approval = Voucher::where('status', 1)->where('is_manager_approved', 0)->whereBetween('created_at', [$from, $to])->count();
                $approved = Voucher::where('status', 2)->whereBetween('created_at', [$from, $to])->count();
            }
            $rejected = Voucher::where('status', 2)->whereBetween('created_at', [$from, $to])->count();
            $payments = Payment::whereBetween('created_at', [$from, $to])->sum('amount');
            if(!auth()->user()->is_admin){
                $total_vouchers = auth()->user()->employee->vouchers()->whereBetween('created_at', [$from, $to])->count();

            }

            return response()->json([
                'approval'          => $approval,
                'approved'          => $approved,
                'payments'          => $payments,
                'total_vouchers'    => $total_vouchers,
                'rejected'          => $rejected,
                'drafted'           => $drafted,
            ]);
        }

        if(auth()->user()->is_admin) {

            if(auth()->user()->is_admin == 1){
                $approval = Voucher::orderBy('id', 'desc')
                ->where('is_manager_approved', 1)
                ->where('status', 1)
                ->whereMonth('created_at', Carbon::now()->month)
                ->count();

                $approved = Voucher::orderBy('id', 'desc')
                ->where('is_manager_approved', 1)
                ->where('status', 2)
                ->whereMonth('created_at', Carbon::now()->month)
                ->count();
            }else{
                $approval = Voucher::orderBy('id', 'desc')
                ->where('is_manager_approved', 0)
                ->where('status', 1)
                ->whereMonth('created_at', Carbon::now()->month)
                ->count();

                $approved = Voucher::orderBy('id', 'desc')
                ->where('status', 2)
                ->whereMonth('created_at', Carbon::now()->month)
                ->count();
            }


            $rejected = Voucher::orderBy('id', 'desc')
            ->where('status', 3)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();

            $employees = Employee::whereDate('expiry_date', '<=', Carbon::now()->addDays(7))->get();

            $payments = Payment::whereMonth('created_at', Carbon::now()->month)
            ->sum('amount');
        }else{
            $drafted = auth()->user()->employee->vouchers()
            ->whereHas('expenses', function($q){
                return $q->havingRaw('sum(amount) > 0')->groupBy('id');
            })
            ->where('status', 0)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();

            $approval = auth()->user()->employee->vouchers()
            ->where('status', 1)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();

            $approved = auth()->user()->employee->vouchers()
            ->where('is_manager_approved', 1)
            ->where('status', 2)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();

            $rejected = auth()->user()->employee->vouchers()
            ->where('status', 3)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();

            $total_vouchers = auth()->user()->employee->vouchers()
            ->whereMonth('created_at', Carbon::now()
            ->month)->count();
        }

        return view('dashboard.index', compact('approval', 'approved', 'drafted', 'rejected', 'payments', 'total_vouchers', 'employees'));
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
