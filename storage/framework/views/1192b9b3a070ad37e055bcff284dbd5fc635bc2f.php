<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1>Employees</h1>
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
    <p>List of all your employees is visible here.</p>

    <div class="card px-3 py-1">
        <div class="my-3">
            <a class="btn btn-success float-right" href="<?php echo e(route('employees.create')); ?>">+ Create New Employee</a>
        </div>
        <br>
        <div class="card-body">
            
            <table id="example1" class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Code</th>
                        <th scope="col">Email</th>
                        <th scope="col">Number</th>
                        <th scope="col">Photo</th>
                        <th scope="col">Id Card</th>
                        <th scope="col">License Front</th>
                        <th scope="col">License Back</th>
                        <th scope="col">Wallet Balance</th>
                        <th scope="col">Password</th>
                        <th scope="col">Account</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($employee->name); ?></td>
                            <td><?php echo e($employee->code); ?></td>
                            <td><?php echo e($employee->email); ?></td>
                            <td><?php echo e($employee->number); ?></td>
                            <td>
                                <span>
                                    <a target="_blank"  href="<?php echo e(asset('storage/employee/' . $employee->photo)); ?>">
                                        <img width="50" height="60"
                                            src="<?php echo e(asset('storage/employee/' . $employee->photo)); ?>" class="img-thumbnail"
                                            alt="Employee photo" />
                                    </a>
                                </span>
                            </td>
                            <td>
                                <span>
                                    <a target="_blank"  href="<?php echo e(asset('storage/employee/' . $employee->aadhar_photo)); ?>">
                                        <img width="50" height="60"
                                            src="<?php echo e(asset('storage/employee/' . $employee->aadhar_photo)); ?>"
                                            class="img-thumbnail" alt="Employee Id Card Photo" />
                                    </a>
                                </span>
                            </td>
                            <td>
                                <span>
                                    <a target="_blank"  href="<?php echo e(asset('storage/employee/' . $employee->front_license)); ?>">
                                        <img width="50" height="60"
                                            src="<?php echo e(asset('storage/employee/' . $employee->front_license)); ?>" class="img-thumbnail"
                                            alt="Employee front_license" />
                                    </a>
                                </span>
                            </td>
                            <td>
                                <span>
                                    <a target="_blank" href="<?php echo e(asset('storage/employee/' . $employee->back_license)); ?>">
                                        <img width="50" height="60"
                                            src="<?php echo e(asset('storage/employee/' . $employee->back_license)); ?>"
                                            class="img-thumbnail" alt="Employee back_license" />
                                    </a>
                                </span>
                            </td>
                            <td>
                                <span
                                    class="badge <?php if($employee->wallet_balance > 0): ?> badge-primary <?php else: ?> badge-warning <?php endif; ?> px-2 py-2"
                                    style="font-size: 1.2rem;">
                                    Rs. <?php echo e($employee->wallet_balance); ?>

                                </span>
                            </td>
                            <td>
                                <?php echo e($employee->password); ?>

                            </td>
                            <td>
                                <?php if($employee->user->active): ?>
                                    <span class="badge badge-success px-2 py-2" style="font-size: 1rem;">
                                        Active
                                    </span>
                                <?php else: ?>
                                    <span class="badge badge-danger px-2 py-2" style="font-size: 1rem;">
                                        Inactive
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <a class="btn btn-secondary dropdown-toggle" href="#" role="button"
                                        id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        ACTIONS
                                    </a>

                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <a class="dropdown-item text-primary"
                                            href="<?php echo e(route('employees.addbalance', ['id' => $employee->id])); ?>">Add
                                            Balance</a>
                                        <a class="dropdown-item text-primary"
                                            href="<?php echo e(route('employees.edit', ['id' => $employee->id])); ?>">Edit</a>
                                        <div class="dropdown-divider"></div>
                                        <?php if($employee->user->active): ?>
                                            <a class="dropdown-item text-danger deactivateBtn"
                                                href="<?php echo e(route('employees.destroy', ['id' => $employee->id])); ?>">
                                                Deactivate
                                            </a>
                                        <?php else: ?>
                                            <a class="dropdown-item text-success activateBtn"
                                                href="<?php echo e(route('employees.activate', ['id' => $employee->id])); ?>">
                                                Activate
                                            </a>
                                        <?php endif; ?>
                                        <a style="<?php echo e($employee->wallet_balance >= 0 ? 'pointer-events: none' : ''); ?>" class="dropdown-item text-primary"
                                            href="<?php echo e(route('employees.payamount', ['id' => $employee->id])); ?>">Pay Amount</a>
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
    <script src="<?php echo e(asset('js/tableFilter.js')); ?>"></script>
    <script src="<?php echo e(asset('js/empactdeact.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\freelancing\employee-expense-management-system\resources\views/employees/index.blade.php ENDPATH**/ ?>