<?php $__env->startSection('title', 'Logbooks'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1>Logbooks</h1>
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

    <p class="float-left">List of all of your logbooks is visible here.</p>
    

    <br><br><br><br>

    <div class="card px-3 py-1">
        <!-- /.card-header -->
        <div class="card-body">

            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <select class="form-control js-example-basic-multiple" onchange="selectEmployee(this.value)" id="employee_id">
                        <option value="1" disabled selected>Select Employee</option>
                        <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e(route('single.employee.logbook', $employee->user_id)); ?>" <?php echo e(request('id') == $employee->user_id ? 'selected': ''); ?>><?php echo e($employee->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-3"></div>
            </div>

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
                        <th scope="col">Id</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Prev Reading</th>
                        <th scope="col">Current Reading</th>
                        <th scope="col">Distance</th>
                        <th scope="col">Purpose</th>
                        <th scope="col">Fuel Liters</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Date</th>
                        <th scope="col">Cal Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $logbooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($log->id); ?></td>
                            <td><?php echo e($log->user ? $log->user->name : ''); ?></td>
                            <td><?php echo e($log->user ? $log->user->email : ''); ?></td>
                            <td><?php echo e($log->prev_reading); ?></td>
                            <td><?php echo e($log->current_reading); ?></td>
                            <td><?php echo e($log->distance); ?></td>
                            <td><?php echo e($log->purpose); ?></td>
                            <td><?php echo e($log->leters); ?></td>
                            <td>
                                <span class="badge badge-primary px-2 py-2">
                                    Rs. <?php echo e($log->fuel_price_total); ?>

                                </span>
                            </td>
                            <td>
                                <?php echo e(date('Y-m-d', strtotime($log->created_at))); ?>

                            </td>
                            <td>
                                <?php echo e($log->fuel_price_total); ?>

                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
                
            </table>
            <div id="footer_detail" style="display: none">
                <div class="row">
                    <div class="col-md-4">
                        <p><b>Total Distance :</b> <span id="total_distance">0</span></p>
                    </div>
                    <div class="col-md-4">
                        <p><b>Total Fuel :</b> <span id="total_fuel">0</span></p>
                    </div>
                    <div class="col-md-4">
                        <p><b>Total Average :</b> <span id="total_avg">0</span></p>
                    </div>
                </div>
            </div>
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
        <script src="<?php echo e(asset('/dist/js/adminlte.min.js')); ?>"></script>
        <script>
            const ele = (id) => {
                return document.getElementById(id);
            }

            const selectEmployee = (url) => {
                location.href=url;
            }
            $(function() {
                $("#example1").DataTable({
                    "order": [
                        [0, 'desc']
                    ],
                    "oSearch": {
                    "sSearch": "<?php echo e(date('Y-m')); ?>"
                    },
                    'columnDefs' : [
                        //hide the second & fourth column
                        { 'visible': false, 'targets': [8] }
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

                var total_distance = 0;
                var total_fuel = 0;
                var total_avg = 0;

                $.fn.dataTable.ext.search.push(
                    function(settings, data, dataIndex) {
                        total_distance += parseFloat(data[5])/2;
                        total_fuel += parseFloat(data[7])/2;
                        total_avg = Math.round(((total_distance/total_fuel) + Number.EPSILON) * 100) / 100;
                        $('input[type="search"]').val('').keyup();
                        var FilterStart = $('#min').val();
                        var FilterEnd = $('#max').val();
                        var DataTableStart = data[9].trim();
                        var DataTableEnd = data[9].trim();
                        ele('total_distance').innerText = total_distance;
                        ele('total_fuel').innerText = total_fuel;
                        ele('total_avg').innerText = total_avg;
                        ele('footer_detail').style.display = 'block';

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



<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\freelancing\employee-expense-management-system\resources\views/logbooks/employee_index.blade.php ENDPATH**/ ?>