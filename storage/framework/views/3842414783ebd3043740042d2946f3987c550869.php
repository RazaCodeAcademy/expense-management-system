<?php if($errors->any()): ?>
    <div class="border border-danger text-danger">
        <ul>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
<?php endif; ?>

<?php echo csrf_field(); ?>

<div class="row">
    <div class="form-group col-sm-4">
        <label for="name">Employee Name</label>
        <input type="text" class="form-control" id="name" name="name"
            value="<?php if(isset($employee)): ?> <?php echo e($employee->name); ?><?php else: ?><?php echo e(old('name')); ?> <?php endif; ?>" required>
    </div>
    <div class="form-group col-sm-4">
        <label for="code">Employee Code</label>
        <input type="text" class="form-control" id="code" name="code"
            value="<?php if(isset($employee)): ?> <?php echo e($employee->code); ?><?php else: ?><?php echo e(old('code')); ?> <?php endif; ?>" required>
    </div>
    <div class="form-group col-sm-4">
        <label for="number">Employee Number</label>
        <input type="number" class="form-control" id="number" name="number"
            value="<?php if(isset($employee)): ?> <?php echo e($employee->number); ?><?php else: ?><?php echo e(old('number')); ?> <?php endif; ?>" required>
    </div>
</div>

<div class="row">
    <div class="form-group col-sm-4">
        <label for="email">Employee Email</label>
        <input type="email" class="form-control" id="email" name="email"
            value="<?php if(isset($employee)): ?> <?php echo e($employee->email); ?><?php else: ?><?php echo e(old('email')); ?> <?php endif; ?>" required>
    </div>
    <div class="form-group col-sm-4">
        <label for="password">Employee Password</label>
        <input type="password" class="form-control" id="password" name="password"
            <?php if(!isset($employee)): ?> required <?php endif; ?>>
    </div>
    <div class="form-group col-sm-4">
        <label for="password_confirmation">Employee Confirm Password</label>
        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
            <?php if(!isset($employee)): ?> required <?php endif; ?>>
    </div>
</div>

<?php if(!isset($employee)): ?>
    <div class="row">
        <div class="form-group col-sm-4">
            <label for="wallet_balance">Employee Wallet Balance</label>
            <input type="number" class="form-control" id="wallet_balance" name="wallet_balance" value="0"
                required>
        </div>
        <div class="col-sm-4" id="paymentModeDiv" hidden>
            <label for="paymentModes">Payment Mode:</label>
            <select class="form-control" id="paymentModes" name="payment_mode">
                <option value="0"><?php echo e(App\Accunity\Utils::PAYMENT_MODES[0]); ?></option>
                <option value="1"><?php echo e(App\Accunity\Utils::PAYMENT_MODES[1]); ?></option>
                <option value="2"><?php echo e(App\Accunity\Utils::PAYMENT_MODES[2]); ?></option>
                <option value="3"><?php echo e(App\Accunity\Utils::PAYMENT_MODES[3]); ?></option>
            </select>
        </div>
        <div class="form-group col-sm-4" id="dateDiv" hidden>
            <label for="date">Date</label>
            <input type="date" class="form-control" id="date" name="date"
                value="<?php echo e(Carbon\Carbon::now()->format('Y-m-d')); ?>" required>
        </div>
    </div>
    <div class="row" id="remarkDiv" hidden>
        <div class="form-group col-sm-4">
            <label for="remark">Remark</label>
            <input type="text" class="form-control" id="remark" name="remark">
        </div>
    </div>
<?php endif; ?>

<div class="row">
    <div class="form-group col-sm-4">
        <label for="photo">Employee's Photo</label>
        <input type="file" class="form-control" id="photo" name="photo">
    </div>
    <?php if(isset($employee)): ?>
        <?php if($employee->photo): ?>
            <div class="form-group col-sm-1">
                <span>
                    <img width="60" height="60" src="<?php echo e(asset('storage/employee/' . $employee->photo)); ?>"
                        class="img-thumbnail" alt="Employee photo">
                </span>
            </div>
        <?php endif; ?>
    <?php endif; ?>
    <div class="form-group col-sm-4">
        <label for="aadhar_photo">Id Card Photo</label>
        <input type="file" class="form-control" id="aadhar_photo" name="aadhar_photo">
    </div>
    <?php if(isset($employee)): ?>
        <?php if($employee->photo): ?>
            <div class="form-group col-sm-1">
                <span>
                    <img width="60" height="60" src="<?php echo e(asset('storage/employee/' . $employee->aadhar_photo)); ?>"
                        class="img-thumbnail" alt="Employee Id Card Photo">
                </span>
            </div>
        <?php endif; ?>
    <?php endif; ?>
    <div class="form-group col-sm-4">
        <label for="license_no">License No</label>
        <input type="text" class="form-control" id="license_no" value="<?php if(isset($employee)): ?> <?php echo e($employee->license_no); ?><?php else: ?><?php echo e(old('license_no')); ?> <?php endif; ?>" required name="license_no">
    </div>
    
    <div class="form-group col-sm-4">
        <label for="expiry_date">Expiry Date</label>
        <input type="date" class="form-control" value="<?php echo e(isset($employee) ? date('Y-m-d', strtotime($employee->expiry_date)) : date('Y-m-d')); ?>" id="expiry_date" required name="expiry_date">
    </div>

    <div class="form-group col-sm-4">
        <label for="front_license">Front License Photo</label>
        <input type="file" class="form-control" id="front_license" name="front_license">
    </div>
    <?php if(isset($employee)): ?>
        <?php if($employee->front_license): ?>
            <div class="form-group col-sm-1">
                <span>
                    <img width="60" height="60"
                        src="<?php echo e(asset('storage/employee/' . $employee->front_license)); ?>" class="img-thumbnail"
                        alt="Employee Front License Photo">
                </span>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <div class="form-group col-sm-4">
        <label for="back_license">Back License Photo</label>
        <input type="file" class="form-control" id="back_license" name="back_license">
    </div>
    <?php if(isset($employee)): ?>
        <?php if($employee->back_license): ?>
            <div class="form-group col-sm-1">
                <span>
                    <img width="60" height="60"
                        src="<?php echo e(asset('storage/employee/' . $employee->back_license)); ?>" class="img-thumbnail"
                        alt="Employee Front License Photo">
                </span>
            </div>
        <?php endif; ?>
    <?php endif; ?>


</div>
<hr>
<div class="row">


    <div class="col-md-12">
        <h2>Vehicle Detail</h2>
    </div>

    <div class="form-group col-sm-4">
        <label for="make">Make</label>
        <input type="text" class="form-control" id="make" required value="<?php echo e(isset($employee->vehicle) ? $employee->vehicle->make : ''); ?>" name="make">
    </div>
    <div class="form-group col-sm-4">
        <label for="model">Model</label>
        <input type="text" class="form-control" value="<?php echo e(isset($employee->vehicle) ? $employee->vehicle->model : ''); ?>" id="model" required name="model">
    </div>
    <div class="form-group col-sm-4">
        <label for="vehicle_number">Vehicle Number</label>
        <input type="text" value="<?php echo e(isset($employee->vehicle) ? $employee->vehicle->vehicle_number : ''); ?>" class="form-control" id="vehicle_number" required name="vehicle_number">
    </div>
    <div class="form-group col-sm-4">
        <label for="color">Vehicle Color</label>
        <input type="text" class="form-control" id="color" value="<?php echo e(isset($employee->vehicle) ? $employee->vehicle->color : ''); ?>" required name="color">
    </div>
    <div class="form-group col-sm-4">
        <label for="engine_number">Engine Number</label>
        <input type="text" class="form-control" id="engine_number" value="<?php echo e(isset($employee->vehicle) ? $employee->vehicle->engine_number : ''); ?>" required name="engine_number">
    </div>
    <div class="form-group col-sm-4">
        <label for="fuel_type">Fuel Type</label>
        <input type="text" class="form-control" id="fuel_type" value="<?php echo e(isset($employee->vehicle) ? $employee->vehicle->fuel_type : ''); ?>" required name="fuel_type">
    </div>


</div>
<div class="form-group mt-3">
    <input type="submit" class="btn btn-success"
        value="<?php if(isset($employee)): ?> Update <?php else: ?> Create <?php endif; ?>">
    <input type="button" class="btn btn-danger ml-3" value="Cancel" onclick="window.history.back()">
</div>
<?php /**PATH C:\xampp\htdocs\freelancing\employee-expense-management-system\resources\views/employees/form.blade.php ENDPATH**/ ?>