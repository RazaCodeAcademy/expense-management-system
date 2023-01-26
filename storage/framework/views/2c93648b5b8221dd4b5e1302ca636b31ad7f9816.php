

<?php $__env->startSection('title', 'Expense Category Master - Create New Expense Category'); ?>

<?php $__env->startSection('content_header'); ?>
<h1>Create New Expense Category</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="card px-3 py-1">

    <form method="POST" action="<?php echo e(route('expensecategories.store')); ?>">
        <?php echo $__env->make('expensecategories.form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </form>

</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<link rel="stylesheet" href="/css/admin_custom.css">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script>
    console.log('Hi!');

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\freelancing\employee-expense-management-system\resources\views/expensecategories/create.blade.php ENDPATH**/ ?>