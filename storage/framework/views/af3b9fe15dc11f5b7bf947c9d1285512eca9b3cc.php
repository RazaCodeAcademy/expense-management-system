

<?php $__env->startSection('title', 'Add Balance To Employee\'s Wallet'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1>Add Balance To <?php echo e($employee->name); ?>'s Wallet</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="card px-3 py-1">

    <form id="addBalanceForm" method="POST" action="<?php echo e(route('employees.addbalance', ['id' => $employee->id])); ?>" enctype="multipart/form-data">
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
                <label for="new_wallet_balance">Balance</label>
                <input type="number" class="form-control" id="new_wallet_balance" name="new_wallet_balance"
                value="<?php echo e($employee->wallet_balance); ?>" disabled>
            </div>
            <div class="form-group col-sm-4">
                <label for="wallet_balance">Add Amount</label>
                <input type="number" class="form-control" id="wallet_balance" name="wallet_balance" required>
            </div>
            <div class="form-group col-sm-4">
                <label for="payment_mode">Payment Mode</label>
                <Select class="form-control" id="payment_mode" name="payment_mode">
                    <option value="0"><?php echo e(App\Accunity\Utils::PAYMENT_MODES[0]); ?></option>
                    <option value="1"><?php echo e(App\Accunity\Utils::PAYMENT_MODES[1]); ?></option>
                    <option value="2"><?php echo e(App\Accunity\Utils::PAYMENT_MODES[2]); ?></option>
                    <option value="3"><?php echo e(App\Accunity\Utils::PAYMENT_MODES[3]); ?></option>
                </Select>
            </div>

        </div>
        <div class="row">
            <div class="form-group col-sm-4">
                <label for="date">Date</label>
                <input type="date" class="form-control" id="date" name="date"
                value="<?php echo e(Carbon\Carbon::now()->format('Y-m-d')); ?>" required>
            </div>
            <div class="form-group col-sm-4">
                <label for="remark">Remark</label>
                <input type="text" class="form-control" id="remark" name="remark">
            </div>
        </div>

        <div class="form-group mt-3">
            <input id="addBalanceBtn" type="button" class="btn btn-success" value="Add">
            <input type="button" class="btn btn-danger ml-3" value="Cancel" onclick="window.history.back()">
        </div>

    </form>

</div>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('js'); ?>
    <script src="<?php echo e(asset('js/addbalance.js')); ?>"></script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\freelancing\employee-expense-management-system\resources\views/employees/addbalance.blade.php ENDPATH**/ ?>