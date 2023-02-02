<?php $__env->startSection('title', 'Edit Voucher'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1>Edit Voucher</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php $__env->startPush('css'); ?>
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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/codemirror.min.css"
            integrity="sha512-uf06llspW44/LZpHzHT6qBOIVODjWtv4MxCricRxkzvopAlSWnTf6hpZTFxuuZcuNE9CBQhqE0Seu1CoRk84nQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />
    <?php $__env->stopPush(); ?>
    <?php $__env->startPush('js'); ?>
        <script
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAQb-7NDLDsJh-l3siJQ_1gEw2lBgWKYlU&libraries=places,diections">
            // src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC-5CY9mOCeg5Y3IhPqi_Yd0-DZtWrJl-E&callback=myMap&q=lahore">
        </script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/codemirror.min.js"
            integrity="sha512-8RnEqURPUc5aqFEN04aQEiPlSAdE0jlFS/9iGgUyNtwFnSKCXhmB6ZTNl7LnDtDWKabJIASzXrzD0K+LYexU9g=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <?php $__env->stopPush(); ?>

    <div class="card px-3 py-1">

            <form id="insertForm" method="POST" action="<?php echo e(route('vouchers.updateExpense', ['id' => $expense->id])); ?>"
                enctype="multipart/form-data">
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
                    <div class="form-group col-sm-6 col-md-3">
                        <label for="date">Expense Date</label>
                        <input type="date" class="form-control" id="date" name="date"
                            value="<?php echo e($expense->date->format('Y-m-d')); ?>"
                            required>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="category">Expense Category</label>
                        <select class="form-control" id="category" name="category" onchange="getFuelDetails(this.value)"
                            required>
                            <?php $__currentLoopData = $expenseCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($category->id); ?>" <?php echo e($expense->category_id == $category->id ? 'selected' : ''); ?>>
                                    <?php echo e($category->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="form-group col-sm-6 col-md-3">
                        <label for="amount">Expense Amount</label>
                        <input type="number" class="form-control" id="amount" value="<?php echo e($expense->amount); ?>" oninput="setAmount(this.value)" name="amount">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="description">Expense Description</label>
                        <textarea type="text" class="form-control" id="description" name="description" rows="1" required><?php echo e($expense->description); ?></textarea>
                    </div>
                    <div class="form-group col-sm-6 col-md-3">
                        <label for="bill">Expense Bill</label>
                        <input type="file" class="form-control" id="bill" name="bill[]" multiple>
                    </div>

                </div>
                <hr>
                <div id="fuel_area" style="display: <?php echo e($expense->category_id == 5 ? 'block' : 'none'); ?>">

                    <div class="row">
                        <div class="col-md-6 col-12 mb-1">
                            <input type="hidden" class="form-control" id="lat_from" placeholder="Enter lat"
                                name="lat_from" value="32.7895443"  />
                        </div>
                        <div class="col-md-6 col-12 mb-1">
                            <input type="hidden" class="form-control" id="long_from" placeholder="Enter long"
                                name="lng_from" value="72.348920"  />
                        </div>
                        <div class="col-md-6 col-12 mb-1">
                            <input type="hidden" class="form-control" id="lat_to" placeholder="Enter lat" name="lat_to"
                                value="32.7895443"  />
                        </div>
                        <div class="col-md-6 col-12 mb-1">
                            <input type="hidden" class="form-control" id="long_to" placeholder="Enter long"
                                name="lng_to" value="72.348920"  />
                        </div>



                        <div class="form-group col-sm-6 col-md-3">
                            <label for="prev_reading">Previous Meter Reading</label>
                            <input type="text" readonly class="form-control" id="prev_reading" name="prev_reading"
                                value="<?php if(isset($logbook)): ?> <?php echo e($logbook->prev_reading); ?><?php else: ?><?php echo e(0); ?> <?php endif; ?>"
                                >
                        </div>
                        <div class="form-group col-sm-6 col-md-3">
                            <label for="current_reading">Current Meter Reading</label>
                            <input type="number" min="<?php if(isset($logbook)): ?> <?php echo e($logbook->prev_reading+1); ?><?php else: ?><?php echo e(0); ?> <?php endif; ?>" step=0.01 class="form-control" id="current_reading" value="<?php echo e(isset($logbook) ? $logbook->current_reading : '0'); ?>" name="current_reading"
                                >
                        </div>
                        <div class="form-group col-sm-6 col-md-3">
                            <label for="fuel_price_per_leter">Fuel Price Per Liter</label>
                            <input type="number"step=0.01 class="form-control" id="fuel_price_per_leter"
                                name="fuel_price_per_leter" oninput="caculateFuel(this.value)" value="<?php echo e(isset($logbook) ? $logbook->fuel_price_per_leter : '0'); ?>">
                        </div>
                        <div class="form-group col-sm-6 col-md-3">
                            <label for="leters">Total Fuel Liter</label>
                            <input type="number" readonly step=0.01 class="form-control" id="leters" name="leters" value="<?php echo e(isset($logbook) ? $logbook->leters : '0'); ?>"
                                >
                        </div>
                        <div class="form-group col-sm-6 col-md-3">
                            <label for="fuel_price_total">Total Fuel Price</label>
                            <input type="number" step=0.01 readonly class="form-control" id="fuel_price_total" name="fuel_price_total"
                                value="<?php echo e(isset($logbook) ? $logbook->fuel_price_total : '0'); ?>">
                        </div>
                        <div class="form-group col-sm-6 col-md-3">
                            <label for="purpose">Route Purpose</label>
                            <textarea type="text" class="form-control" rows="1" id="purpose" name="purpose"
                                ><?php echo e(isset($logbook) ? $logbook->purpose : ''); ?></textarea>
                        </div>
                        <div class="form-group col-sm-6 col-md-3">
                            <label for="journey">Journey</label>
                            <textarea type="text" class="form-control" rows="1" id="journey" name="journey" value=""
                                ><?php echo e(isset($logbook) ? $logbook->journey : ''); ?></textarea>
                        </div>
                    </div>
                    <div class="row">
                        
                        <div class="col-md-12 col-12 my-2" style="display: none">
                            <label for="validationTooltip01">Location</label>
                            <div class="mapouter">
                                <div id="googleMap" style="width:100%;height:400px;"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <input type="submit" class="btn btn-success" value="+ Save & Continue" name="save_and_continue">
                    <input type="submit" class="btn btn-info" value="+ Save & Exit" name="save_and_exist">
                </div>
            </form>

        <form id="updateForm" method="POST" action="" enctype="multipart/form-data" style="display: none;">
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
                <div class="form-group col-sm-6 col-md-3">
                    <label for="date">Expense Date</label>
                    <input type="date" class="form-control" id="updateDate" name="date" required>
                </div>
                <div class="form-group col-sm-6">
                    <label for="category">Expense Category</label>
                    <select class="form-control" id="updateCategory" name="category" required>
                        <?php $__currentLoopData = $expenseCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($category->id); ?>">
                                <?php echo e($category->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="form-group col-sm-6 col-md-3">
                    <label for="amount">Expense Amount</label>
                    <input type="number" class="form-control" id="updateAmount" name="amount" required>
                </div>
                <div class="form-group col-sm-6">
                    <label for="description">Expense Description</label>
                    <textarea type="text" class="form-control" id="updateDescription" name="description" rows="1" required></textarea>
                </div>
                <div class="form-group col-sm-6 col-md-3">
                    <label for="bill">Expense Bill</label>
                    <input type="file" class="form-control" id="updateBill" name="bill[]" multiple>
                </div>
            </div>
            <div class="form-group">
                
            </div>
        </form>

        <br><br>



    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script>
        var latitude = "";
        var longitude = "";
        var pointA = '';
        var pointB = '';

        const ele = (id) => {
            return document.getElementById(id);
        }

        const setAmount = (amount) => {
            ele('fuel_price_total').value = amount;
            var fuel_price_per_leter = ele('fuel_price_per_leter').value;
            caculateFuel(fuel_price_per_leter);
        }

        const caculateFuel = (fuel_price_per_leter) => {
            var fuel_price_total = ele('fuel_price_total').value;
            var leters = parseFloat(fuel_price_total) / parseFloat(fuel_price_per_leter);
            ele('leters').value = Math.round((leters + Number.EPSILON) * 100) / 100;
        }

        window.onload = () => {
            getLocation();
        }

        function init(latitude, longitude) {
            var map = new google.maps.Map(document.getElementById('googleMap'), {
                center: {
                    lat: latitude,
                    lng: longitude
                },
                zoom: 12
            });

            ele('lat_from').value = latitude;
            ele('long_from').value = longitude;
            ele('lat_to').value = latitude;
            ele('long_to').value = longitude;


            var fromSearchBox = new google.maps.places.SearchBox(document.getElementById('from_location'));
            // map.controls[google.maps.ControlPosition.TOP_CENTER].push(document.getElementById('from_location'));
            google.maps.event.addListener(fromSearchBox, 'places_changed', function() {
                fromSearchBox.set('map', null);


                var places = fromSearchBox.getPlaces();

                var bounds = new google.maps.LatLngBounds();
                var i, place;
                for (i = 0; place = places[i]; i++) {
                    (function(place) {
                        ele('lat_from').value = place.geometry.location.lat();
                        ele('long_from').value = place.geometry.location.lng();
                        pointA = new google.maps.LatLng(place.geometry.location.lat(), place.geometry.location.lng());
                        var marker = new google.maps.Marker({
                            position: place.geometry.location
                        });
                        marker.bindTo('map', fromSearchBox, 'map');
                        google.maps.event.addListener(marker, 'map_changed', function() {
                            if (!this.getMap()) {
                                this.unbindAll();
                            }
                        });
                        bounds.extend(place.geometry.location);


                    }(place));

                }
                map.fitBounds(bounds);
                fromSearchBox.set('map', map);
                map.setZoom(Math.min(map.getZoom(), 12));

            });

            var toSearchBox = new google.maps.places.SearchBox(document.getElementById('to_location'));
            // map.controls[google.maps.ControlPosition.TOP_CENTER].push(document.getElementById('from_location'));
            google.maps.event.addListener(toSearchBox, 'places_changed', function() {
                toSearchBox.set('map', null);


                var places = toSearchBox.getPlaces();

                var bounds = new google.maps.LatLngBounds();
                var i, place;
                for (i = 0; place = places[i]; i++) {
                    (function(place) {
                        ele('lat_to').value = place.geometry.location.lat();
                        ele('long_to').value = place.geometry.location.lng();
                        pointB = new google.maps.LatLng(place.geometry.location.lat(), place.geometry.location.lng());
                        var marker = new google.maps.Marker({
                            position: place.geometry.location
                        });
                        marker.bindTo('map', toSearchBox, 'map');
                        google.maps.event.addListener(marker, 'map_changed', function() {
                            if (!this.getMap()) {
                                this.unbindAll();
                            }
                        });
                        bounds.extend(place.geometry.location);


                    }(place));

                }

                var directionsService = new google.maps.DirectionsService();

                directionsDisplay = new google.maps.DirectionsRenderer({
                    map: map
                });

                calculateAndDisplayRoute(directionsService, directionsDisplay, pointA, pointB)

                map.fitBounds(bounds);
                toSearchBox.set('map', map);
                map.setZoom(Math.min(map.getZoom(), 12));

            });

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


        const getFuelDetails = (value) => {
            if (value == 5) {
                setTimeout(() => {
                    ele('purpose').required = true;
                    ele('fuel_price_per_leter').required = true;
                    ele('fuel_price_per_leter').required = true;
                    ele('fuel_area').style.display = "block";
                }, 1000);
            } else {
                ele('purpose').required = false;
                ele('fuel_price_per_leter').required = false;
                ele('fuel_price_per_leter').required = false;
                ele('fuel_area').style.display = "none";
            }
        }

        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            } else {
                x.innerHTML = "Geolocation is not supported by this browser.";
            }
        }

        function showPosition(position) {
            var latitude = position.coords.latitude;
            var longitude = position.coords.longitude;
            init(latitude, longitude)
        }
    </script>

    <script src="<?php echo e(asset('js/downloadfiles.js')); ?>"></script>
    <script src="<?php echo e(asset('js/approval.js')); ?>"></script>
    <script src="<?php echo e(asset('js/s2.js')); ?>"></script>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\freelancing\employee-expense-management-system\resources\views/vouchers/editExpense.blade.php ENDPATH**/ ?>