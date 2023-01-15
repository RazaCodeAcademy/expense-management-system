@extends('adminlte::page')

@section('title', 'Edit Voucher')

@section('content_header')
    <h1>Edit Voucher</h1>
@stop

@section('content')

    <div class="card px-3 py-1">

        <form method="POST" action="{{ route('vouchers.update', ['id' => $voucher->id]) }}">
            @if ($errors->any())
                <div class="border border-danger text-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @csrf

            <div class="row">
                <div class="form-group col-sm-4">
                    <label for="job">Select Job</label>
                    <select class="form-control js-example-basic-multiple" id="job" name="job[]" multiple="multiple"
                        @if ($voucher->status !== 0) disabled @endif>
                        <?php
                        $vouchers = $voucher->jobs()->get();
                        $voucherids = [];
                        foreach ($vouchers as $v) {
                            array_push($voucherids, $v->id);
                        }
                        ?>
                        @foreach ($jobs as $job)
                            <option value="{{ $job->id }}"
                                @if (isset($voucher)) @if (in_array($job->id, $voucherids)) selected @endif
                                @endif>
                                {{ $job->number }} - {{ $job->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-sm-4">
                    <label for="vouchernumber">Voucher Number</label>
                    <input type="text" class="form-control" id="vouchernumber" name="vouchernumber"
                        value="{{ $voucher->number }}" required disabled>
                </div>
            </div>

            @if ($voucher->status === 0)
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Update">
                </div>
            @endif

        </form>

        <br><br>

        @if ($voucher->status === 0)
            <form id="insertForm" method="POST" action="{{ route('vouchers.createExpense', ['id' => $voucher->id]) }}"
                enctype="multipart/form-data">
                @if ($errors->any())
                    <div class="border border-danger text-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @csrf

                <div class="row">
                    <div class="form-group col-sm-2">
                        <label for="date">Expense Date</label>
                        <input type="date" class="form-control" id="date" name="date"
                            value="@if (isset($expense)) {{ $expense->date->format('d-M-Y') }}@else{{ old('date') }} @endif"
                            required>
                    </div>
                    <div class="form-group col-sm-3">
                        <label for="category">Expense Category</label>
                        <select class="form-control" id="category" name="category" onchange="getFuelDetails(this.value)"
                            required>
                            @foreach ($expenseCategories as $category)
                                <option value="{{ $category->id }}">
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-sm-2">
                        <label for="amount">Expense Amount</label>
                        <input type="number" class="form-control" id="amount" name="amount">
                    </div>
                    <div class="form-group col-sm-3">
                        <label for="description">Expense Description</label>
                        <textarea type="text" class="form-control" id="description" name="description" rows="1" required></textarea>
                    </div>
                    <div class="form-group col-sm-2">
                        <label for="bill">Expense Bill</label>
                        <input type="file" class="form-control" id="bill" name="bill[]" multiple>
                    </div>

                </div>
                <hr>
                <div id="fuel_area" style="display: none">
                    <div class="row">
                        <div class="col-md-6 col-12 mb-1">
                            <input type="hidden" class="form-control" id="lat_from" placeholder="Enter lat"
                                name="lat_from" value=""  required />
                        </div>
                        <div class="col-md-6 col-12 mb-1">
                            <input type="hidden" class="form-control" id="long_from" placeholder="Enter long"
                                name="lng_from" value="" required />
                        </div>
                        <div class="col-md-6 col-12 mb-1">
                            <input type="hidden" class="form-control" id="lat_to" placeholder="Enter lat" name="lat_to"
                                value="" required />
                        </div>
                        <div class="col-md-6 col-12 mb-1">
                            <input type="hidden" class="form-control" id="long_to" placeholder="Enter long"
                                name="lng_to" value="" required />
                        </div>
                        <div class="col-md-12 col-12 mb-1">
                            <label for="validationTooltip01">Location</label>
                            <div class="mapouter">
                                <div id="googleMap" style="width:100%;height:400px;"></div>
                            </div>
                        </div>
                        <div class="form-group col-sm-2">
                            <label for="prev_reading">Previous Meter Reading</label>
                            <input type="text" readonly class="form-control" id="prev_reading" name="prev_reading"
                                value="@if (isset($logbook)) {{ $logbook->prev_reading }}@else{{ 0 }} @endif"
                                required>
                        </div>
                        <div class="form-group col-sm-2">
                            <label for="current_reading">Current Meter Reading</label>
                            <input type="number" class="form-control" id="current_reading" name="current_reading"
                                value="@if (isset($expense)) {{ $expense->date->format('d-M-Y') }}@else{{ 0 }} @endif"
                                required>
                        </div>
                        <div class="form-group col-sm-2">
                            <label for="leters">Total Fuel Leter</label>
                            <input type="number" class="form-control" id="leters" name="leters"
                                value="@if (isset($expense)) {{ $expense->date->format('d-M-Y') }}@else{{ 0 }} @endif"
                                required>
                        </div>
                        <div class="form-group col-sm-2">
                            <label for="fuel_price_per_leter">Fuel Price Per Leter</label>
                            <input type="number" class="form-control" id="fuel_price_per_leter"
                                name="fuel_price_per_leter"
                                value="@if (isset($expense)) {{ $expense->date->format('d-M-Y') }}@else{{ 0 }} @endif"
                                required>
                        </div>
                        <div class="form-group col-sm-2">
                            <label for="fuel_price_total">Total Fuel Price</label>
                            <input type="number" class="form-control" id="fuel_price_total" name="fuel_price_total"
                                value="@if (isset($expense)) {{ $expense->date->format('d-M-Y') }}@else{{ 0 }} @endif"
                                required>
                        </div>
                        <div class="form-group col-sm-2">
                            <label for="purpose">Route Purpose</label>
                            <input type="text" class="form-control" id="purpose" name="purpose"
                                value="@if (isset($expense)) {{ $expense->date->format('d-M-Y') }}@else @endif"
                                required>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <input type="submit" class="btn btn-success" value="+ Add">
                </div>
            </form>
        @endif

        <form id="updateForm" method="POST" action="" enctype="multipart/form-data" style="display: none;">
            @if ($errors->any())
                <div class="border border-danger text-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @csrf

            <div class="row">
                <div class="form-group col-sm-2">
                    <label for="date">Expense Date</label>
                    <input type="date" class="form-control" id="updateDate" name="date" required>
                </div>
                <div class="form-group col-sm-3">
                    <label for="category">Expense Category</label>
                    <select class="form-control" id="updateCategory" name="category" required>
                        @foreach ($expenseCategories as $category)
                            <option value="{{ $category->id }}">
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-sm-2">
                    <label for="amount">Expense Amount</label>
                    <input type="number" class="form-control" id="updateAmount" name="amount" required>
                </div>
                <div class="form-group col-sm-3">
                    <label for="description">Expense Description</label>
                    <textarea type="text" class="form-control" id="updateDescription" name="description" rows="1" required></textarea>
                </div>
                <div class="form-group col-sm-2">
                    <label for="bill">Expense Bill</label>
                    <input type="file" class="form-control" id="updateBill" name="bill[]" multiple>
                </div>
            </div>
            <div class="form-group">
                @if ($voucher->status === 0)
                    <input type="submit" class="btn btn-primary" value="Update">
                    <input type="button" id="deleteExpenseBtn" class="btn btn-danger ml-3" value="Delete">
                @endif
            </div>
        </form>

        <br><br>

        <div class="table-responsive">
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Date</th>
                        <th scope="col">Category</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Description</th>
                        <th scope="col">Bill</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($expenses as $expense)
                        <tr @if ($voucher->status === 0) class="editExpenseBtn" @endif>
                            <td hidden class="data">{{ $expense->id }}</td>
                            <td class="data">{{ $expense->date->format('d-m-Y') }}</td>
                            <td hidden class="data">{{ $expense->category_id }}</td>
                            <td class="data">
                                {{ App\Models\ExpenseCategory::where('id', $expense->category_id)->first()->name }}</td>
                            <td class="data">
                                <span class="badge badge-primary px-2 py-2" style="font-size: 1.1rem;">Rs.
                                    {{ $expense->amount }}</span>
                            </td>
                            <td class="data">{{ $expense->description }}</td>
                            <td>
                                {{-- @dd($expense->bills) --}}
                                @if (count($expense->bills) > 0)
                                    <img src="{{ asset('storage/bill/' . $expense->bills->first()->file_name) }}"
                                        alt="" width="50">
                                @else
                                    <span class="badge badge-danger">Bill Not Provided</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <br>

        @if ($voucher->status === 0)
            <form id="extraFilesForm" method="POST"
                action="{{ route('vouchers.attachAdditionalFiles', ['id' => $voucher->id]) }}"
                enctype="multipart/form-data">
                @if ($errors->any())
                    <div class="border border-danger text-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @csrf
            </form>

            <br>
        @endif

        <div class="form-group mt-3 mx-auto">
            @if ($voucher->status === 0)
                <input type="button" id="applyForApprovalBtn" class="btn btn-primary" value="Apply For Approval">
                <a class="btn btn-danger ml-3" href="{{ route('vouchers.index') }}">Cancel</a>
            @endif
        </div>

    </div>

    <input type="hidden" id="voucherId" value="{{ $voucher->id }}">
    <input type="hidden" id="url" value="{{ route('vouchers.askForApproval') }}">
    <input type="hidden" id="deleteExpenseUrl" value="{{ route('vouchers.destroyExpense') }}">
@stop

@section('js')
    <script>
        const getFuelDetails = (value) => {
            if (value == 5) {

                setTimeout(() => {
                    document.getElementById('fuel_area').style.display = "block";
                }, 1000);
            } else {
                document.getElementById('fuel_area').style.display = "none";
            }
        }
    </script>
    <script>

        var latitude="";
        var longitude="";
        window.onload = ()=>{
            getLocation();
        }

        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(myMap);
            } else {
                x.innerHTML = "Geolocation is not supported by this browser.";
            }
        }

        function showPosition(position) {
            var latitude = position.coords.latitude;
            var longitude = position.coords.longitude;
            var lat_from = document.getElementById("lat_from");
            var long_from = document.getElementById("long_from");
        }

        function myMap(position) {
            var lat_from = document.getElementById("lat_from");
            var long_from = document.getElementById("long_from");
            var lat_to = document.getElementById("lat_to");
            var long_to = document.getElementById("long_to");

            lat_from.value = position.coords.latitude;
            long_from.value = position.coords.longitude;
            lat_to.value = position.coords.latitude;
            long_to.value = position.coords.longitude;

            var mapProp = {
                center: new google.maps.LatLng(position.coords.latitude, position.coords.longitude),
                zoom: 10,
            };
            var map = new google.maps.Map(document.getElementById("googleMap"), mapProp);
            var marker = addMarker(lat_from.value, long_from.value, map);
            var marker = addMarker(lat_to.value, long_to.value, map);

            google.maps.event.addListener(map, 'click', function(event) {
                removeMarker(marker);
                lat_to.value = event.latLng.lat();
                long_to.value = event.latLng.lng();
                marker = addMarker(event.latLng.lat(), event.latLng.lng(), map);
            });
        }

        const addMarker = (lat, long, map) => {
            return new google.maps.Marker({
                position: new google.maps.LatLng(lat, long),
                map: map,
            });
        }

        const removeMarker = (marker) => {
            if (marker != null) { //already set marker to clear
                marker.setMap(null);
                marker = null;
            }
        }
    </script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC-5CY9mOCeg5Y3IhPqi_Yd0-DZtWrJl-E&callback=myMap&q=lahore">
    </script>
    <script src="{{ asset('js/downloadfiles.js') }}"></script>
    <script src="{{ asset('js/approval.js') }}"></script>
    <script src="{{ asset('js/s2.js') }}"></script>
@stop
