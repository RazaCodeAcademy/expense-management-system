<?php $__env->startSection('title', 'Expense Category Master - Create New Expense Category'); ?>

<?php $__env->startSection('content_header'); ?>
<h1>Create New Expense Category</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php $__env->startPush('css'); ?>
        <link href="<?php echo e(asset('/toast/toastr1.css')); ?>" rel="stylesheet">
        <link href="<?php echo e(asset('/toast/toastr2.css')); ?>" rel="stylesheet">
    <?php $__env->stopPush(); ?>

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
<?php $__env->startPush('js'); ?>
<script src="<?php echo e(asset('/toast/toastr.js')); ?>"></script>
    <script src="<?php echo e(asset('/toast/toastr.min.js')); ?>"></script>
    <?php if(Session::has('success')): ?>
    
        <script>
            toastr.options.positionClass = 'toast-top-right';
            toastr.success('<?php echo e(Session::get('success')); ?>')
        </script>
    <?php endif; ?>

    <?php if(Session::has('error')): ?>
        <script>
            toastr.options.positionClass = 'toast-top-right';
            toastr.error('<?php echo e(Session::get('error')); ?>')
        </script>
    <?php endif; ?>
    <?php $__env->stopPush(); ?>
<script>
    console.log('Hi!');

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\freelancing\employee-expense-management-system\resources\views/expensecategories/create.blade.php ENDPATH**/ ?>