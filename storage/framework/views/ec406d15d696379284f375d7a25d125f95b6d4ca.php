<?php $__env->startSection('title', 'List Of Rejected Vouchers'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1>List Of Rejected Vouchers</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php $__env->startPush('css'); ?>
        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?php echo e(asset('/plugins/fontawesome-free/css/all.min.css')); ?>">
        <!-- DataTables -->
        <link rel="stylesheet" href="<?php echo e(asset('/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')); ?>">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?php echo e(asset('/dist/css/adminlte.min.css')); ?>">
    <?php $__env->stopPush(); ?>
    <div class="card px-3 py-1">
        <!-- /.card-header -->
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="min">From :</label>
                        <input type="date" id="min" onfocus="this.showPicker()" value="<?php echo e(date('Y-m-01')); ?>"
                            class="form-control">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="max">To :</label>
                        <input type="date" id="max" onfocus="this.showPicker()" value="<?php echo e(date('Y-m-d')); ?>"
                            class="form-control">
                    </div>
                </div>
            </div>
            <table id="example1" class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Employee Name</th>
                        
                        <th scope="col">Voucher Number</th>
                        <th scope="col">Voucher Date</th>
                        <th scope="col">Proposed Amount</th>
                        <th scope="col">Rejected On</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $vouchers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $voucher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $expenses = $voucher->expenses;
                        $total_amt = 0.0;
                        foreach ($expenses as $exp) {
                            $total_amt += $exp->amount;
                        }

                    ?>
                    <tr>
                        <td><?php echo e($voucher->employee()->first()->name); ?></td>
                        
                        <td><?php echo e($voucher->number); ?></td>
                        <td><?php if(isset($voucher->date)): ?><?php echo e(date('Y-m-d', strtotime($voucher->date))); ?><?php endif; ?></td>
                        <td>
                            <span class="badge badge-primary px-2 py-2">
                                Rs. <?php echo e($total_amt); ?>

                            </span>
                        </td>
                        <td><?php if(isset($voucher->approval_date)): ?><?php echo e($voucher->approval_date->format('d-M-Y')); ?><?php endif; ?></td>
                        <td>
                            <a class="btn btn-primary" href="<?php echo e(route('employees.voucherDetails', ['id' => $voucher->id])); ?>">View</a>
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
                    "order": [[3, 'desc']],
                    "oSearch": {
                    "sSearch": "<?php echo e(date('Y-m')); ?>"
                    },
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
                        var DataTableStart = data[2].trim();
                        var DataTableEnd = data[2].trim();
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
    <?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>



<?php $__env->startSection('js'); ?>
    <script src="<?php echo e(asset('js/tableFilter.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\freelancing\employee-expense-management-system\resources\views/employees/rejected.blade.php ENDPATH**/ ?>