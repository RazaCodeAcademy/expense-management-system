<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1>Dashboard</h1>
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

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label for="min">From :</label>
                <input type="date" id="min" onfocus="this.showPicker()" onchange="filterByDate()"
                    value="<?php echo e(date('Y-m-01')); ?>" class="form-control">
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label for="max">To :</label>
                <input type="date" id="max" onfocus="this.showPicker()" onchange="filterByDate()"
                    value="<?php echo e(date('Y-m-d')); ?>" class="form-control">
            </div>
        </div>
    </div>

    <?php if(auth()->user()->is_admin): ?>
        
        <div class="row">
            <div class="col-sm-4">
                <div class="card px-3 py-1 bg-success text-white" style="height: 120px;">
                    <span class="ml-auto">Approval Requests</span>
                    <span class="ml-auto" style="font-size: 60px;" id="approval">
                        <?php echo e($approval); ?>

                    </span>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card px-3 py-1 bg-primary text-white" style="height: 120px;">
                    <span class="ml-auto">Approved Requests</span>
                    <span class="ml-auto" style="font-size: 60px;" id="approved">
                        <?php echo e($approved); ?>

                    </span>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card px-3 py-1 bg-danger text-white" style="height: 120px;">
                    <span class="ml-auto">Rejected Vouchers</span>
                    <span class="ml-auto" style="font-size: 60px;" id="rejected">
                        <?php echo e($rejected); ?>

                    </span>
                </div>
            </div>
            <?php if(auth()->user()->is_admin == 1): ?>
                <div class="col-sm-4">
                    <div class="card px-3 py-1 bg-primary text-white" style="height: 120px;">
                        <span class="ml-auto">Total Payments</span>
                        <span class="ml-auto" style="font-size: 60px;" id="payments">
                            Rs. <?php echo e($payments); ?>

                        </span>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <br><br>

        <div class="card">
            <div class="card-body">
                

                <h2>Employee License Expiry Detail</h2>
                <table id="example1" class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Employee Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">License Number</th>
                            <th scope="col">Expiry Date</th>
                            <th scope="col">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <?php echo e($employee->id); ?>

                                </td>
                                <td>
                                    <?php echo e($employee->name); ?>

                                </td>
                                <td><?php echo e($employee->email); ?></td>
                                <td>
                                    <?php echo e($employee->license_no); ?>

                                </td>
                                <td>
                                    <?php echo e($employee->expiry_date); ?>

                                </td>
                                <td style="font-weight: 600;">
                                    <?php echo e($employee->created_at->format('Y-m-d')); ?>

                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php else: ?>
        
        <div class="row">
            <div class="col-sm-3">
                <div class="card px-3 py-1 bg-success text-white" style="height: 120px;">
                    <span class="ml-auto">Wallet Balance</span>
                    <span class="ml-auto" style="font-size: 60px;" id="wallet">
                        Rs. <?php echo e(auth()->user()->employee->wallet_balance); ?>

                    </span>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card px-3 py-1 bg-primary text-white" style="height: 120px;">
                    <span class="ml-auto">Draft Vouchers</span>
                    <span class="ml-auto" style="font-size: 60px;" id="drafted">
                        <?php echo e($drafted); ?>

                    </span>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card px-3 py-1 bg-secondary text-white" style="height: 120px;">
                    <span class="ml-auto">Open Vouchers</span>
                    <span class="ml-auto" style="font-size: 60px;" id="approval">
                        <?php echo e($approval); ?>

                    </span>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card px-3 py-1 bg-info text-white" style="height: 120px;">
                    <span class="ml-auto">Approved Vouchers</span>
                    <span class="ml-auto" style="font-size: 60px;" id="approved">
                        <?php echo e($approved); ?>

                    </span>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card px-3 py-1 bg-danger text-white" style="height: 120px;">
                    <span class="ml-auto">Rejected Vouchers</span>
                    <span class="ml-auto" style="font-size: 60px;" id="rejected">
                        <?php echo e($rejected); ?>

                    </span>
                </div>
            </div>
        </div>
    <?php endif; ?>

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
                        [0, 'desc']
                    ],
                    // "oSearch": {
                    //     "sSearch": "<?php echo e(date('Y-m')); ?>"
                    // },
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
                        // $('input[type="search"]').val('').keyup();
                        var FilterStart = $('#min').val();
                        var FilterEnd = $('#max').val();
                        var DataTableStart = data[5].trim();
                        var DataTableEnd = data[5].trim();
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

            const ele = (id) => {
                return document.getElementById(id);
            }

            const filterByDate = () => {
                from = ele('min').value;
                to = ele('max').value;
                if (from && to) {
                    $.ajax({
                        type: 'GET',
                        url: "<?php echo e(route('dashboard.index')); ?>",
                        data: {
                            from: from,
                            to: to,
                        },
                        success: (res) => {
                            if (ele('approval')) {
                                ele('approval').innerText = res.approval;
                                ele('approved').innerText = res.approved;
                                if(ele('payments')){
                                    ele('payments').innerText = res.payments;
                                }
                            } else {
                                ele('total_vouchers').innerText = res.total_vouchers;
                            }
                        }
                    })
                }
            }

            // var browser = require("webextension-polyfill");
        </script>
    <?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\freelancing\employee-expense-management-system\resources\views/dashboard/index.blade.php ENDPATH**/ ?>