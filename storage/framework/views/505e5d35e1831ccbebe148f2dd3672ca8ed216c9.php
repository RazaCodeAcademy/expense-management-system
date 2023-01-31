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
        <label for="name">Admin Name</label>
        <input type="text" class="form-control" id="name" name="name"
        value="<?php if(isset($user)): ?><?php echo e($user->name); ?><?php else: ?><?php echo e(old('name')); ?><?php endif; ?>" required>
    </div>
    <div class="form-group col-sm-4">
        <label for="email">Admin Email</label>
        <input type="email" class="form-control" id="email" name="email"
        value="<?php if(isset($user)): ?><?php echo e($user->email); ?><?php else: ?><?php echo e(old('email')); ?><?php endif; ?>">
    </div>
</div>

<div class="row">
    <div class="form-group col-sm-4">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" name="password" <?php if(!isset($user)): ?> required <?php endif; ?>>
    </div>
    <div class="form-group col-sm-4">
        <label for="password_confirmation">Confirm Password</label>
        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" <?php if(!isset($user)): ?> required <?php endif; ?>>
    </div>
</div>

<div class="form-group">
    <input type="submit" class="btn btn-success" value="<?php if(isset($user)): ?> Update <?php else: ?> Create <?php endif; ?>">
    <input type="button" class="btn btn-danger ml-3" value="Cancel" onclick="window.history.back()">
</div>

<?php /**PATH C:\xampp\htdocs\freelancing\employee-expense-management-system\resources\views/auth/form.blade.php ENDPATH**/ ?>