<?php $__env->startSection('title', 'Edit User - Abacus N Brain'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1>Edit User</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="card px-3 py-1">
    <div class="card px-3 py-1">
        <form method="POST" action="<?php echo e(route('managers.update', ['id' => $user->id])); ?>">
            <?php echo $__env->make('managers.form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </form>

    </div>
</div>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('css'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script type="text/javascript" src="<?php echo e(asset('js/forms.js')); ?>"></script>
    <script type="text/javascript">
        $("#per_session_amount_div").hide();
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\freelancing\employee-expense-management-system\resources\views/managers/edit.blade.php ENDPATH**/ ?>