<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1>Expense Categories</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php $__env->startPush('css'); ?>
    <link href="<?php echo e(asset('/toast/toastr1.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('/toast/toastr2.css')); ?>" rel="stylesheet">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?php echo e(asset('/plugins/fontawesome-free/css/all.min.css')); ?>">
        <!-- DataTables -->
        <link rel="stylesheet" href="<?php echo e(asset('/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')); ?>">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?php echo e(asset('/dist/css/adminlte.min.css')); ?>">
    <?php $__env->stopPush(); ?>
    <p>List of all expense categories is visible here.</p>

    <div class="card px-3 py-1">
        <div class="my-3">
            <a class="btn btn-success float-right" href="<?php echo e(route('expensecategories.create')); ?>">+ Create New Category</a>
        </div>
        <br>
        <div class="card-body">
            
            <table id="example1" class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Category Name</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $expensecategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expensecategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($expensecategory->name); ?></td>
                            <td>
                                <div class="dropdown">
                                    <a class="btn btn-secondary dropdown-toggle" href="#" role="button"
                                        id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        ACTIONS
                                    </a>

                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <a class="dropdown-item text-primary"
                                            href="<?php echo e(route('expensecategories.edit', ['id' => $expensecategory->id])); ?>">Edit</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item text-danger deleteBtn"
                                            href="<?php echo e(route('expensecategories.destroy', ['id' => $expensecategory->id])); ?>">Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

    </div>


    <?php $__env->startPush('js'); ?>
        <!-- DataTables  & Plugins -->
        <script src="<?php echo e(asset('/plugins/datatables/jquery.dataTables.min.js')); ?>"></script>
        <script src="<?php echo e(asset('/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')); ?>"></script>
        <script src="<?php echo e(asset('/plugins/datatables-responsive/js/dataTables.responsive.min.js')); ?>"></script>
        <script src="<?php echo e(asset('/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')); ?>"></script>
        <script src="<?php echo e(asset('/plugins/datatables-buttons/js/dataTables.buttons.min.js')); ?>"></script>
        <script src="<?php echo e(asset('/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')); ?>"></script>
        <script src="<?php echo e(asset('/plugins/jszip/jszip.min.js')); ?>"></script>
        <script src="<?php echo e(asset('/plugins/pdfmake/pdfmake.min.js')); ?>"></script>
        <script src="<?php echo e(asset('/plugins/pdfmake/vfs_fonts.js')); ?>"></script>
        <script src="<?php echo e(asset('/plugins/datatables-buttons/js/buttons.html5.min.js')); ?>"></script>
        <script src="<?php echo e(asset('/plugins/datatables-buttons/js/buttons.print.min.js')); ?>"></script>
        <script src="<?php echo e(asset('/plugins/datatables-buttons/js/buttons.colVis.min.js')); ?>"></script>
        <!-- AdminLTE App -->
        
        <script>
            $(function() {
                $("#example1").DataTable({
                    "order": [
                        [1, 'desc']
                    ],
                    "responsive": true,
                    "lengthChange": false,
                    "autoWidth": false,
                    "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
                }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
                $('#example2').DataTable({
                    "paging": true,
                    "lengthChange": false,
                    "searching": false,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false,
                    "responsive": true,
                });

                $.fn.dataTable.ext.search.push(
                    function(settings, data, dataIndex) {
                        $('input[type="search"]').val('').keyup();
                        var FilterStart = $('#min').val();
                        var FilterEnd = $('#max').val();
                        var DataTableStart = data[1].trim();
                        var DataTableEnd = data[1].trim();
                        if (FilterStart == '' || FilterEnd == '') {
                            return true;
                        }
                        if (DataTableStart >= FilterStart && DataTableEnd <= FilterEnd) {
                            return true;
                        } else {
                            return false;
                        }

                    });
                // --------------------------
                $('#min').change(function(e) {
                    var Table = $("#example1").DataTable();
                    Table.draw();

                });
                $('#max').change(function(e) {
                    var Table = $("#example1").DataTable();
                    Table.draw();

                });
            });
        </script>
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

<?php $__env->stopSection(); ?>



<?php $__env->startSection('js'); ?>
    <script src="<?php echo e(asset('js/delete.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\freelancing\employee-expense-management-system\resources\views/expensecategories/index.blade.php ENDPATH**/ ?>