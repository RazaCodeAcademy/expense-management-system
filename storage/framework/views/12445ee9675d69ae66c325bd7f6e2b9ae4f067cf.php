<?php $__env->startSection('title', 'Vouchers'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1>Vouchers</h1>
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
    <p>Your wallet details are visible here.</p>

    <div class="card px-3 py-1">
        <h2>Your total wallet banalce is:
            <span class="badge badge-primary px-2 py-2">
                Rs. <?php echo e(auth()->user()->employee->wallet_balance); ?>

            </span>
        </h2>

        <br>

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
                        <th scope="col">Payment Number</th>
                        <th scope="col">Total Amount</th>
                        <th scope="col">Payment Mode</th>
                        <th scope="col">Date</th>
                        <th scope="col">Remark</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>
                                <b style="font-size: 1rem;">
                                    <?php if(strpos($payment->remark, 'Voucher Accepted') !== false): ?>
                                        <?php echo e($payment->employee->code); ?>-<?php echo e($payment->id); ?>

                                    <?php else: ?>
                                        P-<?php echo e($payment->employee->code); ?>-<?php echo e($payment->id); ?>

                                    <?php endif; ?>
                                </b>
                            </td>
                            <td>
                                <?php if(strpos($payment->remark, 'Voucher Accepted') !== false): ?>
                                    <span class="badge badge-success px-2 py-2" style="font-size: 1rem;">
                                        Rs. -<?php echo e($payment->amount); ?>

                                    </span>
                                <?php else: ?>
                                    <span class="badge badge-primary px-2 py-2" style="font-size: 1rem;">
                                        Rs. <?php echo e($payment->amount); ?>

                                    </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="badge badge-warning px-2 py-2" style="font-size: 1rem;">
                                    <?php if(strpos($payment->remark, 'Voucher Accepted') !== false): ?>
                                        Voucher Accepted
                                    <?php else: ?>
                                        <i
                                            class="fas fa-<?php echo e(App\Accunity\Utils::PAYMENT_MODES_ICONS[$payment->payment_mode]); ?>"></i>
                                        <?php echo e(App\Accunity\Utils::PAYMENT_MODES[$payment->payment_mode]); ?>

                                    <?php endif; ?>
                                </span>
                            </td>
                            <td style="font-weight: 600;">
                                <?php echo e(date('Y-m-d', strtotime($payment->date))); ?>

                            </td>
                            <td style="font-weight: 600;">
                                <?php echo e($payment->remark); ?>

                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

    </div>

    <?php $__env->startPush('js'); ?>
        <!-- jQuery -->
        <script src="<?php echo e(asset('/plugins/jquery/jquery.min.js')); ?>"></script>
        <!-- Bootstrap 4 -->
        <script src="<?php echo e(asset('/plugins/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
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
                        [3, 'desc']
                    ],
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
                        var DataTableStart = data[3].trim();
                        var DataTableEnd = data[3].trim();
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



<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\freelancing\employee-expense-management-system\resources\views/wallet/index.blade.php ENDPATH**/ ?>