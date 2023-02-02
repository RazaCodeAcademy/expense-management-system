<?php

namespace App\Http\Controllers;

use App\Accunity\Utils;
use App\Models\Employee;
use App\Models\Payment;
use App\Models\Vehicle;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::all();

        return view('employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('employees.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $request->flashExcept(['password', 'password_confirmation', 'photo', 'aadhar_photo']);

        $this->validate($request, [
            'name' => 'required',
            'code' => 'required',
            'number' => 'required',
            'email' => 'required|unique:employees,email,except,id',
            'password' => 'required|confirmed',
            'wallet_balance' => 'required',
        ]);

        // ! Note: The employee passsword is knowingly unhashed at client's request
        // ! TODO: Change this back to hashed password for github version of project
        $employee = Employee::create([
            'code' => $request->input('code'),
            'name' => $request->input('name'),
            'number' => $request->input('number'),
            'email' => $request->input('email'),
            'license_no' => $request->input('license_no'),
            'expiry_date' => $request->input('expiry_date'),
            'password' => $request->input('password'),
            'wallet_balance' => $request->input('wallet_balance'),
        ]);

        $vehicle = Vehicle::create([
            'user_id'           => $employee->id,
            'make'              => $request->make,
            'model'             => $request->model,
            'vehicle_number'    => $request->vehicle_number,
            'color'             => $request->color,
            'engine_number'     => $request->engine_number,
            'fuel_type'         => $request->fuel_type,
        ]);

        if($request->input('wallet_balance') > 0) {
            $payment = Payment::create([
                'date' => $request->input('date'),
                'payment_mode' => $request->input('payment_mode'),
                'amount' => $request->input('wallet_balance'),
            ]);

            if ($request->input('remark') == null) {
                $payment->remark = 'Balance Added';
            } else {
                $payment->remark = 'Balance Added - ' . $request->input('remark');
            }
            $payment->employee()->associate($employee);
            $payment->save();
        }

        if ($request->hasFile('photo')) {
            // Save the photo file
            $fileName = $request->file('photo')->getClientOriginalName();
            $fileExtension = $request->file('photo')->getClientOriginalExtension();
            $fileName = chop($fileName, '.' . $fileExtension);
            $fileNameToStore = $fileName . '_' . $employee->id . '_' . time() . '.' . $fileExtension;
            $path = $request->file('photo')->storeAs('public/employee', $fileNameToStore);
            $employee->photo = $fileNameToStore;
            $employee->save();
        }

        if ($request->hasFile('aadhar_photo')) {
            // Save the Id Card photo file
            $fileName = $request->file('aadhar_photo')->getClientOriginalName();
            $fileExtension = $request->file('aadhar_photo')->getClientOriginalExtension();
            $fileName = chop($fileName, $fileExtension);
            $fileNameToStore = $fileName . '_' . $employee->id . '_' . time() . '.' . $fileExtension;
            $path = $request->file('aadhar_photo')->storeAs('public/employee', $fileNameToStore);
            $employee->aadhar_photo = $fileNameToStore;
            $employee->save();
        }

        if ($request->hasFile('front_license')) {
            // Save the Id Card photo file
            $fileName = $request->file('front_license')->getClientOriginalName();
            $fileExtension = $request->file('front_license')->getClientOriginalExtension();
            $fileName = chop($fileName, $fileExtension);
            $fileNameToStore = $fileName . '_' . $employee->id . '_' . time() . '.' . $fileExtension;
            $path = $request->file('front_license')->storeAs('public/employee', $fileNameToStore);
            $employee->front_license = $fileNameToStore;
            $employee->save();
        }

        if ($request->hasFile('back_license')) {
            // Save the Id Card photo file
            $fileName = $request->file('back_license')->getClientOriginalName();
            $fileExtension = $request->file('back_license')->getClientOriginalExtension();
            $fileName = chop($fileName, $fileExtension);
            $fileNameToStore = $fileName . '_' . $employee->id . '_' . time() . '.' . $fileExtension;
            $path = $request->file('back_license')->storeAs('public/employee', $fileNameToStore);
            $employee->back_license = $fileNameToStore;
            $employee->save();
        }

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);
        $user->employee()->save($employee);
        $user->save();

        if($user){
            return redirect(route('employees.index'))->with('success', 'Employee created successfuly');
        }

        return redirect(route('employees.index'))>with('error', 'Employee note created');
    }

    public function addbalance(Request $request, $id)
    {
        if($request->isMethod('post'))
        {
            $this->validate($request, [
                'wallet_balance' => 'required',
            ]);

            DB::beginTransaction();
            $balance = $request->input('wallet_balance');
            // add balance to employee's account
            $employee = Employee::findorfail($id);
            $wallet_balance = $employee->wallet_balance + $balance;
            $employee->wallet_balance = $wallet_balance;
            $employee->save();

            try {
                $payment = Payment::create([
                    'date' => $request->input('date'),
                    'payment_mode' => $request->input('payment_mode'),
                    'amount' => $balance,
                ]);

                if ($request->input('remark') == null) {
                    $payment->remark = 'Balance Added';
                } else {
                    $payment->remark = 'Balance Added - ' . $request->input('remark');
                }
                $payment->employee()->associate($employee);
                $payment->save();
            } catch (Exception $e) {
                DB::rollBack();

                return redirect(route('employees.addbalance', ['id' => $id]))->withErrors([
                    'wallet_balance' => 'Payment for '.$balance.' was already done today for this employee.
                    Please select another amount.',
                ]);
            }
            DB::commit();

            // Send email to employee regarding balance update
            $data = [
                'employee' => $employee,
                'balance' => $balance,
            ];
            $email = $employee->email;
            $sender_email = env('MAIL_USERNAME');

            Mail::send('emails.addbalancemail', $data, function($message) use ($email, $sender_email)  {
                $message->to($email, 'Balance added to your account')->subject
                   ('Laravel Basic Testing Mail');
             });

            return redirect(route('employees.index'));
        }

        $employee = Employee::findorfail($id);

        return view('employees.addbalance', compact('employee'));
    }

    public function payamount(Request $request, $id)
    {
        DB::beginTransaction();

        // add balance to employee's account
        $employee = Employee::findorfail($id);
        $wallet_balance = $employee->wallet_balance + abs($employee->wallet_balance);
        // dd('sadfa');
        if($employee->wallet_balance < 0){

            $employee->wallet_balance = $wallet_balance;
            $employee->save();

            $balance = abs($employee->wallet_balance);

            try {
                $payment = Payment::create([
                    'date' => date('Y-m-d'),
                    'payment_mode' => 0,
                    'amount' => $balance,
                ]);

                if ($request->input('remark') == null) {
                    $payment->remark = 'Balance Added';
                } else {
                    $payment->remark = 'Balance Added - ' . $request->input('remark');
                }
                $payment->employee()->associate($employee);
                $payment->save();
            } catch (Exception $e) {
                DB::rollBack();

                return redirect(route('employees.addbalance', ['id' => $id]))->withErrors([
                    'wallet_balance' => 'Payment for '.$balance.' was already done today for this employee.
                    Please select another amount.',
                ]);
            }
            DB::commit();

            // Send email to employee regarding balance update
            $data = [
                'employee' => $employee,
                'balance' => $balance,
            ];
            $email = $employee->email;
            $sender_email = env('MAIL_USERNAME');

            Mail::send('emails.addbalancemail', $data, function($message) use ($email, $sender_email)  {
                $message->to($email, 'Balance added to your account')->subject
                   ('Laravel Basic Testing Mail');
             });
        }

        if(request()->ajax()){
            return response()->json([
                'success'=>true,
            ]);
        }

        return redirect(route('employees.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee = Employee::findorfail($id);

        return view('employees.edit', compact('employee'));
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
        $this->validate($request, [
            'name' => 'required',
            'code' => 'required',
            'number' => 'required',
            'email' => 'required',
        ]);

        $employee = Employee::findorfail($id);

        $employee->update([
            'code' => $request->input('code'),
            'name' => $request->input('name'),
            'number' => $request->input('number'),
            'email' => $request->input('email'),
            'license_no' => $request->input('license_no'),
            'expiry_date' => $request->input('expiry_date'),
        ]);

        $vehicle = Vehicle::where('user_id', $id)->first();

        if($vehicle){
            $vehicle = Vehicle::where('user_id', $id)->first()->update([
                'make'              => $request->make,
                'model'             => $request->model,
                'vehicle_number'    => $request->vehicle_number,
                'color'             => $request->color,
                'engine_number'     => $request->engine_number,
                'fuel_type'         => $request->fuel_type,
            ]);

        }else{
            $vehicle = Vehicle::create([
                'user_id'           => $id,
                'make'              => $request->make,
                'model'             => $request->model,
                'vehicle_number'    => $request->vehicle_number,
                'color'             => $request->color,
                'engine_number'     => $request->engine_number,
                'fuel_type'         => $request->fuel_type,
            ]);

        }


        if ($request->hasFile('photo')) {
            // delete the old photo
            if ($employee->photo !== null) {
                // Delete old photo file
                $file_path = public_path('storage/employee/' . $employee->photo);
                @unlink($file_path);
            }

            // Save the photo file
            $fileName = $request->file('photo')->getClientOriginalName();
            $fileExtension = $request->file('photo')->getClientOriginalExtension();
            $fileName = chop($fileName, $fileExtension);
            $fileNameToStore = $fileName . '_' . $employee->id . '_' . time() . '.' . $fileExtension;
            $path = $request->file('photo')->storeAs('public/employee', $fileNameToStore);
            $employee->photo = $fileNameToStore;
            $employee->save();
        }

        if ($request->hasFile('aadhar_photo')) {
            // delete the old aadhar photo
            if ($employee->aadhar_photo !== null) {
                // Delete old photo file
                $file_path = public_path('storage/employee/' . $employee->aadhar_photo);
                @unlink($file_path);
            }

            // Save the Id Card photo file
            $fileName = $request->file('aadhar_photo')->getClientOriginalName();
            $fileExtension = $request->file('aadhar_photo')->getClientOriginalExtension();
            $fileName = chop($fileName, $fileExtension);
            $fileNameToStore = $fileName . '_' . $employee->id . '_' . time() . '.' . $fileExtension;
            $path = $request->file('aadhar_photo')->storeAs('public/employee', $fileNameToStore);
            $employee->aadhar_photo = $fileNameToStore;
            $employee->save();
        }

        if ($request->hasFile('front_license')) {
            // Save the Id Card photo file
            $fileName = $request->file('front_license')->getClientOriginalName();
            $fileExtension = $request->file('front_license')->getClientOriginalExtension();
            $fileName = chop($fileName, $fileExtension);
            $fileNameToStore = $fileName . '_' . $employee->id . '_' . time() . '.' . $fileExtension;
            $path = $request->file('front_license')->storeAs('public/employee', $fileNameToStore);
            $employee->front_license = $fileNameToStore;
            $employee->save();
        }

        if ($request->hasFile('back_license')) {
            // Save the Id Card photo file
            $fileName = $request->file('back_license')->getClientOriginalName();
            $fileExtension = $request->file('back_license')->getClientOriginalExtension();
            $fileName = chop($fileName, $fileExtension);
            $fileNameToStore = $fileName . '_' . $employee->id . '_' . time() . '.' . $fileExtension;
            $path = $request->file('back_license')->storeAs('public/employee', $fileNameToStore);
            $employee->back_license = $fileNameToStore;
            $employee->save();
        }

        $user = $employee->user;

        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ]);
        $user->employee()->save($employee);
        $user->save();

        if($request->input('password') != null) {
            $this->validate($request, [
                'password' => 'required|confirmed',
            ]);

            $employee->update([
                'password' => $request->input('password'),
            ]);

            $user->update([
                'password' => Hash::make($request->input('password')),
            ]);
        }

        if($user){
            return redirect(route('employees.index'))->with('success', 'Employee updated successfuly');
        }

        return redirect(route('employees.index'))>with('error', 'Employee note updated');
    }

    public function wallet()
    {
        $payments = auth()->user()->employee->payments->sortByDesc('date');

        return view('wallet.index', compact('payments'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = Employee::findorfail($id);
        $user = $employee->user;
        $user->active = false;
        $user->save();

        return response()->json([
            'process' => 'success',
        ]);
    }

    public function activate($id)
    {
        $employee = Employee::findorfail($id);
        $user = $employee->user;
        $user->active = true;
        $user->save();

        return response()->json([
            'process' => 'success',
        ]);
    }
}
