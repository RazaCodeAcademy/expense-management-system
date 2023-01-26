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
        <label for="name">Category Name</label>
        <input type="text" class="form-control" id="name" name="name"
        value="<?php if(isset($expensecategory)): ?><?php echo e($expensecategory->name); ?><?php else: ?><?php echo e(old('name')); ?><?php endif; ?>" required>
    </div>
</div>

<div class="form-group">
    <input type="submit" class="btn btn-success" value="<?php if(isset($expensecategory)): ?> Update <?php else: ?> Create <?php endif; ?>">
    <input type="button" class="btn btn-danger ml-3" value="Cancel" onclick="window.history.back()">
</div>
<?php /**PATH C:\xampp\htdocs\freelancing\employee-expense-management-system\resources\views/expensecategories/form.blade.php ENDPATH**/ ?>