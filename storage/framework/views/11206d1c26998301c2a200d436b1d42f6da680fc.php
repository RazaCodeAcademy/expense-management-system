

<?php $__env->startSection('title', 'Employee Master - Edit Employee'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1>Edit Employee</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="card px-3 py-1">

    <form method="POST" action="<?php echo e(route('employees.update', ['id' => $employee->id])); ?>" enctype="multipart/form-data">
        <?php echo $__env->make('employees.form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </form>

</div>

<?php $__env->stopSection(); ?>




<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\freelancing\employee-expense-management-system\resources\views/employees/edit.blade.php ENDPATH**/ ?>