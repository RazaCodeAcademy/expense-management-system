<?php $__env->startSection('title', 'View Voucher'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1>View Voucher</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="card px-3 py-1">

        <form>
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
                    <label for="employeename">Employee Name</label>
                    <input type="text" class="form-control" id="employeename" name="employeename"
                        value="<?php echo e($voucher->employee()->first()->name); ?>" disabled>
                </div>
                <div class="form-group col-sm-4">
                    <label for="vouchernumber">Voucher Number</label>
                    <input type="text" class="form-control" id="vouchernumber" name="vouchernumber"
                        value="<?php echo e($voucher->number); ?>" required disabled>
                </div>
                <div class="form-group col-sm-4">
                    <label for="voucherdate">Voucher Date</label>
                    <input type="date" class="form-control" id="voucherdate" name="voucherdate"
                        value="<?php echo e($voucher->date->format('Y-m-d')); ?>"
                        required disabled>
                </div>
            </div>
            

            <?php if($voucher->status === 0): ?>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Update">
                </div>
            <?php endif; ?>

        </form>

        <br><br>

        <div class="table-responsive">
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Date</th>
                        <th scope="col">Category</th>
                        <th scope="col">Proposed Amount</th>
                        <th scope="col">Approved Amount</th>
                        <th scope="col">Description</th>
                        <th scope="col">Remark</th>
                        <th scope="col">Bill</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $expenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expense): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="data"><?php echo e($expense->date->format('d-M-Y')); ?></td>
                            <td hidden class="data"><?php echo e($expense->category_id); ?></td>
                            <td class="data">
                                <?php echo e(App\Models\ExpenseCategory::where('id', $expense->category_id)->first()->name); ?></td>
                            <td>
                                <span class="badge badge-primary px-2 py-2">
                                    Rs. <?php echo e($expense->amount); ?>

                                </span>
                            </td>
                            <td class="data">
                                <?php if($voucher->status === 1): ?>
                                    <span class="badge badge-primary px-2 py-2">
                                        Rs. <input type="number" class="expenseamount" id="<?php echo e($expense->id); ?>"
                                            value="<?php echo e($expense->amount); ?>">
                                    </span>
                                <?php else: ?>
                                    <span class="badge badge-primary px-2 py-2">
                                        Rs. <?php echo e($expense->approved_amount); ?>

                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="data"><?php echo e($expense->description); ?></td>
                            <td class="data">
                                <?php if($voucher->status === 1): ?>
                                    <input type="text" class="expenseremark" id="<?php echo e($expense->id); ?>"
                                        value="<?php echo e($expense->remark); ?>">
                                <?php else: ?>
                                    <?php echo e($expense->remark); ?>

                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if(count($expense->bills) > 0): ?>
                                    <form id="addExpenseBillsForm<?php echo e($expense->id); ?>"
                                        action="<?php echo e(route('vouchers.addExpenseBills')); ?>" method="post"
                                        enctype="multipart/form-data">
                                        <?php echo csrf_field(); ?>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-secondary downloadExpenseBillsBtn"
                                                id="<?php echo e($expense->id); ?>">Download</button>
                                            <input type="hidden" name="expenseid" value="<?php echo e($expense->id); ?>">
                                            <input type="file" name="bill[]" id="billupload<?php echo e($expense->id); ?>"
                                                multiple hidden>
                                            <?php if($voucher->status < 2): ?>
                                                <button type="button" class="btn btn-primary addExpenseBillsBtn"
                                                    id="<?php echo e($expense->id); ?>">Add</button>
                                            <?php endif; ?>
                                        </div>
                                    </form>
                                <?php else: ?>
                                    <form id="addExpenseBillsForm<?php echo e($expense->id); ?>"
                                        action="<?php echo e(route('vouchers.addExpenseBills')); ?>" method="post"
                                        enctype="multipart/form-data">
                                        <?php echo csrf_field(); ?>
                                        <div class="btn-group" role="group">
                                            <div>
                                                <span class="badge badge-danger">Bill Not Provided</span>
                                            </div>
                                            <input type="hidden" name="expenseid" value="<?php echo e($expense->id); ?>">
                                            <input type="file" name="bill[]" id="billupload<?php echo e($expense->id); ?>"
                                                multiple hidden>
                                            <?php if($voucher->status < 2): ?>
                                                <button type="button" class="btn btn-primary addExpenseBillsBtn"
                                                    id="<?php echo e($expense->id); ?>">Add</button>
                                            <?php endif; ?>
                                        </div>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php $__currentLoopData = $expense->bills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <span class="billurl <?php echo e($expense->id); ?>" hidden>
                                <?php echo e(asset('storage/bill/' . $bill->file_name)); ?>

                            </span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                        <?php if($expense->category_id == 5): ?>
                            <?php $__currentLoopData = $expense->logbooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $logbook): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <input type="hidden" id="point_a_lat" value="<?php echo e($logbook->lat_from); ?>">
                                    <input type="hidden" id="point_a_long" value="<?php echo e($logbook->long_from); ?>">
                                    <input type="hidden" id="point_b_lat" value="<?php echo e($logbook->lat_to); ?>">
                                    <input type="hidden" id="point_b_long" value="<?php echo e($logbook->long_to); ?>">
                                </tr>
                                <tr>
                                    <th colspan="7">Fuel Detail</th>
                                </tr>
                                <tr>
                                    <th scope="col">Prev Reading</th>
                                    <th scope="col">Current Reading</th>
                                    <th scope="col">Distance</th>
                                    <th scope="col">Purpose</th>
                                    <th scope="col">Fuel Leters</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Date</th>
                                </tr>
                                <tr>
                                    <td><?php echo e($logbook->prev_reading); ?></td>
                                    <td><?php echo e($logbook->current_reading); ?></td>
                                    <td><?php echo e($logbook->distance); ?></td>
                                    <td><?php echo e($logbook->purpose); ?></td>
                                    <td><?php echo e($logbook->leters); ?></td>
                                    <td>
                                        <span class="badge badge-primary px-2 py-2">
                                            Rs. <?php echo e($logbook->fuel_price_total); ?>

                                        </span>
                                    </td>
                                    <td>
                                        <?php echo e(date('Y-m-d', strtotime($logbook->created_at))); ?>

                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php
                    $total_amt = 0.0;
                    foreach ($expenses as $exp) {
                        $total_amt += $exp->amount;
                    }
                    ?>
                    <tr class="table-warning" style="font-size: 1.2rem;">
                        <td colspan="2" scope="row" style="font-weight: 800;">Total:-</td>
                        <td style="font-weight: 800;">
                            Rs. <?php echo e($total_amt); ?>

                        </td>
                        <td style="font-weight: 800;">
                            <?php if($voucher->approved_amount): ?>
                                Rs. <?php echo e($voucher->approved_amount); ?>

                            <?php else: ?>
                                <?php if($voucher->status === 3): ?>
                                    Rejected!
                                <?php else: ?>
                                    Not Yet Approved
                                <?php endif; ?>
                            <?php endif; ?>
                        </td>
                        <td colspan="2"></td>
                        <td>
                            <button class="btn btn-primary" onclick="downloadBillInPdf('<?php echo e(route('downloadZip', request('id'))); ?>')">
                                Download All Bills
                            </button>
                            
                        </td>
                    </tr>
                    <tr class="table-warning" style="font-size: 1.2rem;">
                        <td colspan="1" scope="row" style="font-weight: 800;">Wallet Balance:-</td>
                        <td colspan="2" style="font-weight: 800;">
                            Rs. <?php echo e($voucher->employee()->first()->wallet_balance); ?>

                        </td>
                        <td colspan="4"></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <br>
        

        

        

        
        

        <?php if($voucher->status === 1): ?>
            <div class="row">
                <div class="col-sm-4">
                    <label for="special_remark">Voucher Special Remark:</label>
                    <input type="text" id="special_remark" class="form-control"
                        <?php if(isset($voucher->special_remark)): ?> value="<?php echo e($voucher->special_remark); ?>" <?php endif; ?>>
                </div>
            </div>
            <br>
            <hr>
            <h5 style="font-weight: 700;">Payment options</h5>
            <form>
                <div class="row">
                    <?php
                    $total_approved_amt = 0.0;
                    foreach ($expenses as $exp) {
                        $total_approved_amt += $exp->approved_amount;
                    }

                    if (!$total_approved_amt) {
                        $total_approved_amt = $total_amt;
                    }
                    ?>
                    <div class="col-sm-4">
                        <label for="totalAmountPaid">Total Approved Amount:</label>
                        <input type="number" id="totalAmountPaid" class="form-control"
                            value="<?php echo e($total_approved_amt); ?>">
                    </div>
                    <div class="col-sm-4">
                        <label for="paymentMode">Payment Mode:</label>
                        <select class="form-control" id="paymentMode">
                            <option <?php if(isset($voucher->payment_mode_draft)): ?> <?php if($voucher->payment_mode_draft === 0): ?> selected <?php endif; ?>
                                <?php endif; ?> value="0">
                                <?php echo e(App\Accunity\Utils::PAYMENT_MODES[0]); ?>

                            </option>
                            <option <?php if(isset($voucher->payment_mode_draft)): ?> <?php if($voucher->payment_mode_draft === 1): ?> selected <?php endif; ?>
                                <?php endif; ?> value="1">
                                <?php echo e(App\Accunity\Utils::PAYMENT_MODES[1]); ?>

                            </option>
                            <option <?php if(isset($voucher->payment_mode_draft)): ?> <?php if($voucher->payment_mode_draft === 2): ?> selected <?php endif; ?>
                                <?php endif; ?> value="2">
                                <?php echo e(App\Accunity\Utils::PAYMENT_MODES[2]); ?>

                            </option>
                            <option <?php if(isset($voucher->payment_mode_draft)): ?> <?php if($voucher->payment_mode_draft === 3): ?> selected <?php endif; ?>
                                <?php endif; ?> value="3">
                                <?php echo e(App\Accunity\Utils::PAYMENT_MODES[3]); ?>

                            </option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-4">
                        <label for="date">Payment Date</label>
                        <input type="date" class="form-control" id="date" name="date"
                            <?php if(isset($voucher->payment_date_draft)): ?> value="<?php echo e($voucher->payment_date_draft->format('Y-m-d')); ?>" <?php else: ?> value="<?php echo e(Carbon\Carbon::now()->format('Y-m-d')); ?>" <?php endif; ?>
                            required>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="remark">Payment Remark</label>
                        <input type="text" class="form-control" id="remark" name="remark"
                            <?php if(isset($voucher->payment_remark_draft)): ?> value="<?php echo e($voucher->payment_remark_draft); ?>" <?php endif; ?>
                            required>
                    </div>
                </div>
            </form>
        <?php endif; ?>

        <?php if($voucher->status > 1): ?>
            <?php
            $perCategoryTotal = [];
            foreach ($expenseCategories as $category) {
                $categoryWiseTotal = 0;
                foreach ($expenses as $expense) {
                    if ($category->id === $expense->expensecategory->id) {
                        $categoryWiseTotal += $expense->approved_amount;
                    }
                }
                $perCategoryTotal[$category->name] = $categoryWiseTotal;
            }
            ?>

            <h6 style="font-weight: 700;">Categorywise list of approved total amount:</h6>
            <div class="row">
                <div class="col-sm-3">
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <?php $__currentLoopData = $perCategoryTotal; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category => $total): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr scope="row" style="font-size: 1.2rem;">
                                        <td style="font-weight: 700;"><?php echo e($category); ?></td>
                                        <td>Rs. <?php echo e($total); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <br>

            <div class="row">
                <div class="col-sm-3">
                    <b>Special Remark: </b> <?php echo e($voucher->special_remark); ?>

                </div>
            </div>

        <?php endif; ?>

        <div class="form-group mt-3 mx-auto">
            <?php if($voucher->status === 0): ?>
                <div class="alert alert-primary" role="alert">
                    Approval is not yet requested by the author of this voucher!
                </div>
            <?php elseif($voucher->status === 1): ?>
                <button class="btn btn-warning" id="saveVoucherDraftBtn">
                    <i class="fas fa-save"></i> Save Draft
                </button>
                <button class="btn btn-success" id="approveVoucherBtn">
                    <i class="fas fa-check"></i> Approve
                </button>
                <button class="btn btn-danger" id="rejectVoucherBtn">
                    <i class="fas fa-times"></i> Reject
                </button>
            <?php elseif($voucher->status === 2): ?>
                <div class="alert alert-success" role="alert">
                    This voucher has been approved!
                    <?php if(auth()->user()->is_admin): ?>
                        <a href="<?php echo e(route('employees.voucherDetailsPdf', ['id' => $voucher->id])); ?>"
                            class="btn btn-secondary ml-2">
                            <i class="fas fa-print"></i> Print Report
                        </a>
                    <?php endif; ?>
                </div>
            <?php elseif($voucher->status === 3): ?>
                <div class="alert alert-danger" role="alert">
                    This voucher has been rejected!
                    <?php if(auth()->user()->is_admin): ?>
                        <a href="<?php echo e(route('employees.voucherDetailsPdf', ['id' => $voucher->id])); ?>"
                            class="btn btn-secondary ml-2">
                            <i class="fas fa-print"></i> Print Report
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>

    </div>

    <input type="hidden" id="voucherId" value="<?php echo e($voucher->id); ?>">
    <input type="hidden" id="url" value="<?php echo e(route('vouchers.voucherApproveReject')); ?>">
    <input type="hidden" id="voucherSaveDraftUrl" value="<?php echo e(route('vouchers.voucherSaveDraft')); ?>">
<?php $__env->stopSection(); ?>



<?php $__env->startSection('js'); ?>
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAQb-7NDLDsJh-l3siJQ_1gEw2lBgWKYlU&libraries=places,diections">
        // src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC-5CY9mOCeg5Y3IhPqi_Yd0-DZtWrJl-E&callback=myMap&q=lahore">
    </script>
    <script>
        const ele = (id) => {
            return document.getElementById(id);
        }

        const downloadBillInPdf = (url) => {
            window.location=url;
        }

        window.onload = () => {
            if (ele('point_a_lat').value.length > 0) {
                ele('check_map').style.display = "block";
            }
        }

        function init() {
            pointALat = ele('point_a_lat').value;
            pointALong = ele('point_a_long').value;
            pointBLat = ele('point_b_lat').value;
            pointBLong = ele('point_b_long').value;
            var map = new google.maps.Map(document.getElementById('googleMap'), {
                center: {
                    lat: pointALat,
                    lng: pointALong
                },
                zoom: 12
            });

            var directionsService = new google.maps.DirectionsService();

            directionsDisplay = new google.maps.DirectionsRenderer({
                map: map
            });
            var pointA = new google.maps.LatLng(pointALat, pointALong);
            var pointB = new google.maps.LatLng(pointBLat, pointBLong);

            calculateAndDisplayRoute(directionsService, directionsDisplay, pointA, pointB)
        }
        google.maps.event.addDomListener(window, 'load', init);


        function calculateAndDisplayRoute(directionsService, directionsDisplay, locations0, locations1) {
            directionsService.route({
                origin: locations0,
                destination: locations1,
                travelMode: google.maps.TravelMode.DRIVING
            }, function(response, status) {
                if (status == google.maps.DirectionsStatus.OK) {
                    directionsDisplay.setDirections(response);
                } else {
                    window.alert('Directions request failed due to ' + status);
                }
            });
        }
    </script>
    <script src="<?php echo e(asset('js/downloadfiles.js')); ?>"></script>
    <script src="<?php echo e(asset('js/adminVoucherApproval.js')); ?>"></script>
    <script src="<?php echo e(asset('js/s2.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\freelancing\employee-expense-management-system\resources\views/employees/details.blade.php ENDPATH**/ ?>