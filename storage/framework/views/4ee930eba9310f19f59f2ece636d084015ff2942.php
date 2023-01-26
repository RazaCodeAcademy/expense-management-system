

<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1>Create New Employee</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="card px-3 py-1">

    <form method="POST" action="<?php echo e(route('employees.store')); ?>" enctype="multipart/form-data">
        <?php echo $__env->make('employees.form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </form>

</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script src="<?php echo e(asset('js/addEmployee.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\freelancing\employee-expense-management-system\resources\views/employees/create.blade.php ENDPATH**/ ?>