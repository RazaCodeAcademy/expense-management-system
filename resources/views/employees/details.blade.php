@extends('adminlte::page')

@section('title', 'View Voucher')

@section('content_header')
    <h1>View Voucher</h1>
@stop

@section('content')
    <div class="card px-3 py-1">

        <form>
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
                    <label for="employeename">Employee Name</label>
                    <input type="text" class="form-control" id="employeename" name="employeename"
                        value="{{ $voucher->employee()->first()->name }}" disabled>
                </div>
                <div class="form-group col-sm-4">
                    <label for="vouchernumber">Voucher Number</label>
                    <input type="text" class="form-control" id="vouchernumber" name="vouchernumber"
                        value="{{ $voucher->number }}" required disabled>
                </div>
                <div class="form-group col-sm-4">
                    <label for="voucherdate">Voucher Date</label>
                    <input type="date" class="form-control" id="voucherdate" name="voucherdate"
                        value="{{ $voucher->date->format('Y-m-d') }}"
                        required disabled>
                </div>
            </div>
            {{-- <div class="row">
                <div class="form-group col-sm-4">
                    <label for="job">Voucher Job(s)</label>
                    <select class="form-control js-example-basic-multiple" id="job" name="job[]" multiple="multiple"
                        disabled>
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
            </div> --}}

            @if ($voucher->status === 0)
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Update">
                </div>
            @endif

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
                    @foreach ($expenses as $expense)
                        <tr>
                            <td class="data">{{ $expense->date->format('d-M-Y') }}</td>
                            <td hidden class="data">{{ $expense->category_id }}</td>
                            <td class="data">
                                {{ App\Models\ExpenseCategory::where('id', $expense->category_id)->first()->name }}</td>
                            <td>
                                <span class="badge badge-primary px-2 py-2">
                                    Rs. {{ $expense->amount }}
                                </span>
                            </td>
                            <td class="data">
                                @if ($voucher->status === 1)
                                    <span class="badge badge-primary px-2 py-2">
                                        Rs. <input type="number" class="expenseamount" id="{{ $expense->id }}"
                                            value="{{ $expense->amount }}">
                                    </span>
                                @else
                                    <span class="badge badge-primary px-2 py-2">
                                        Rs. {{ $expense->approved_amount }}
                                    </span>
                                @endif
                            </td>
                            <td class="data">{{ $expense->description }}</td>
                            <td class="data">
                                @if ($voucher->status === 1)
                                    <input type="text" class="expenseremark" id="{{ $expense->id }}"
                                        value="{{ $expense->remark }}">
                                @else
                                    {{ $expense->remark }}
                                @endif
                            </td>
                            <td>
                                @if (count($expense->bills) > 0)
                                    <form id="addExpenseBillsForm{{ $expense->id }}"
                                        action="{{ route('vouchers.addExpenseBills') }}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-secondary downloadExpenseBillsBtn"
                                                id="{{ $expense->id }}">Download</button>
                                            <input type="hidden" name="expenseid" value="{{ $expense->id }}">
                                            <input type="file" name="bill[]" id="billupload{{ $expense->id }}"
                                                multiple hidden>
                                            @if ($voucher->status < 2)
                                                <button type="button" class="btn btn-primary addExpenseBillsBtn"
                                                    id="{{ $expense->id }}">Add</button>
                                            @endif
                                        </div>
                                    </form>
                                @else
                                    <form id="addExpenseBillsForm{{ $expense->id }}"
                                        action="{{ route('vouchers.addExpenseBills') }}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="btn-group" role="group">
                                            <div>
                                                <span class="badge badge-danger">Bill Not Provided</span>
                                            </div>
                                            <input type="hidden" name="expenseid" value="{{ $expense->id }}">
                                            <input type="file" name="bill[]" id="billupload{{ $expense->id }}"
                                                multiple hidden>
                                            @if ($voucher->status < 2)
                                                <button type="button" class="btn btn-primary addExpenseBillsBtn"
                                                    id="{{ $expense->id }}">Add</button>
                                            @endif
                                        </div>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @foreach ($expense->bills as $bill)
                            <span class="billurl {{ $expense->id }}" hidden>
                                {{ asset('storage/bill/' . $bill->file_name) }}
                            </span>
                        @endforeach


                        @if ($expense->category_id == 5)
                            @foreach ($expense->logbooks as $logbook)
                                <tr>
                                    <input type="hidden" id="point_a_lat" value="{{ $logbook->lat_from }}">
                                    <input type="hidden" id="point_a_long" value="{{ $logbook->long_from }}">
                                    <input type="hidden" id="point_b_lat" value="{{ $logbook->lat_to }}">
                                    <input type="hidden" id="point_b_long" value="{{ $logbook->long_to }}">
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
                                    <td>{{ $logbook->prev_reading }}</td>
                                    <td>{{ $logbook->current_reading }}</td>
                                    <td>{{ $logbook->distance }}</td>
                                    <td>{{ $logbook->purpose }}</td>
                                    <td>{{ $logbook->leters }}</td>
                                    <td>
                                        <span class="badge badge-primary px-2 py-2">
                                            Rs. {{ $logbook->fuel_price_total }}
                                        </span>
                                    </td>
                                    <td>
                                        {{ date('Y-m-d', strtotime($logbook->created_at)) }}
                                    </td>
                                </tr>
                            @endforeach
                        @endif

                    @endforeach
                    <?php
                    $total_amt = 0.0;
                    foreach ($expenses as $exp) {
                        $total_amt += $exp->amount;
                    }
                    ?>
                    <tr class="table-warning" style="font-size: 1.2rem;">
                        <td colspan="2" scope="row" style="font-weight: 800;">Total:-</td>
                        <td style="font-weight: 800;">
                            Rs. {{ $total_amt }}
                        </td>
                        <td style="font-weight: 800;">
                            @if ($voucher->approved_amount)
                                Rs. {{ $voucher->approved_amount }}
                            @else
                                @if ($voucher->status === 3)
                                    Rejected!
                                @else
                                    Not Yet Approved
                                @endif
                            @endif
                        </td>
                        <td colspan="2"></td>
                        <td>
                            <button class="btn btn-primary" id="downloadAllBillsBtn">
                                Download All Bills
                            </button>
                        </td>
                    </tr>
                    <tr class="table-warning" style="font-size: 1.2rem;">
                        <td colspan="1" scope="row" style="font-weight: 800;">Wallet Balance:-</td>
                        <td colspan="2" style="font-weight: 800;">
                            Rs. {{ $voucher->employee()->first()->wallet_balance }}
                        </td>
                        <td colspan="4"></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <br>
        {{-- <div id="check_map" style="display: none;">
            <label for="validationTooltip01">Location</label>
            <div class="mapouter">
                <div id="googleMap" style="width:100%;height:400px;"></div>
            </div>
        </div> --}}

        {{-- @foreach ($voucher->sitecompletiondocs as $doc)
        <span class="site_completion_doc_url" hidden>
            {{ asset('storage/site_completion_doc/' . $doc->file_name) }}
        </span>
    @endforeach
    @foreach ($voucher->receiveddocs as $doc)
        <span class="received_doc_url" hidden>
            {{ asset('storage/received_doc/' . $doc->file_name) }}
        </span>
    @endforeach
    @foreach ($voucher->returnablelistdocs as $doc)
        <span class="returnable_list_doc_url" hidden>
            {{ asset('storage/returnable_list_doc/' . $doc->file_name) }}
        </span>
    @endforeach
    @foreach ($voucher->submitteddocs as $doc)
        <span class="submitted_doc_url" hidden>
            {{ asset('storage/submitted_doc/' . $doc->file_name) }}
        </span>
    @endforeach --}}

        {{-- <h5 style="font-weight: 700;">Extra docs submitted</h5>
    <div class="row">
        <div class="form-group col-sm-3">
            <label for="siteCompletionDocBtn">Site Completion Docs: </label>
            @if (count($voucher->sitecompletiondocs) > 0)
                <button class="btn btn-secondary" id="siteCompletionDocBtn">Download Files</button>
            @else
                <span class="badge badge-secondary">No Files</span>
            @endif
        </div>
        <div class="form-group col-sm-3">
            <label for="receivedDocsBtn">Received Docs: </label>
            @if (count($voucher->receiveddocs) > 0)
                <button class="btn btn-secondary" id="receivedDocsBtn">Download Files</button>
            @else
                <span class="badge badge-secondary">No Files</span>
            @endif
        </div>
        <div class="form-group col-sm-3">
            <label for="returnableListBtn">Returnable List: </label>
            @if (count($voucher->returnablelistdocs) > 0)
                <button class="btn btn-secondary" id="returnableListBtn">Download Files</button>
            @else
                <span class="badge badge-secondary">No Files</span>
            @endif
        </div>
        <div class="form-group col-sm-3">
            <label for="submittedDocsBtn">Submitted Docs: </label>
            @if (count($voucher->submitteddocs) > 0)
                <button class="btn btn-secondary" id="submittedDocsBtn">Download Files</button>
            @else
                <span class="badge badge-secondary">No Files</span>
            @endif
        </div>
    </div>
    <br> --}}

        {{-- <h5 style="font-weight: 700;">Add extra docs</h5> --}}
        {{-- <form method="POST"
        action="{{ route('vouchers.attachAdditionalFiles', ['id' => $voucher->id]) }}" enctype="multipart/form-data">
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
                    <label for="site_completion">Site Completion</label>
                    <input type="file" class="form-control" id="site_completion" name="site_completion[]" multiple>
                </div>
                <div class="form-group col-sm-4">
                    <label for="received_docs">Received Docs</label>
                    <input type="file" class="form-control" id="received_docs" name="received_docs[]" multiple>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-4">
                    <label for="returnable_list">Returnable List</label>
                    <input type="file" class="form-control" id="returnable_list" name="returnable_list[]" multiple>
                </div>
                <div class="form-group col-sm-4">
                    <label for="submitted_docs">Submitted Docs</label>
                    <input type="file" class="form-control" id="submitted_docs" name="submitted_docs[]" multiple>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-4">
                    <button class="btn btn-success" type="submit">+ Add docs</button>
                </div>
            </div>
        </form>

        <hr> --}}

        @if ($voucher->status === 1)
            <div class="row">
                <div class="col-sm-4">
                    <label for="special_remark">Voucher Special Remark:</label>
                    <input type="text" id="special_remark" class="form-control"
                        @if (isset($voucher->special_remark)) value="{{ $voucher->special_remark }}" @endif>
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
                            value="{{ $total_approved_amt }}">
                    </div>
                    <div class="col-sm-4">
                        <label for="paymentMode">Payment Mode:</label>
                        <select class="form-control" id="paymentMode">
                            <option @if (isset($voucher->payment_mode_draft)) @if ($voucher->payment_mode_draft === 0) selected @endif
                                @endif value="0">
                                {{ App\Accunity\Utils::PAYMENT_MODES[0] }}
                            </option>
                            <option @if (isset($voucher->payment_mode_draft)) @if ($voucher->payment_mode_draft === 1) selected @endif
                                @endif value="1">
                                {{ App\Accunity\Utils::PAYMENT_MODES[1] }}
                            </option>
                            <option @if (isset($voucher->payment_mode_draft)) @if ($voucher->payment_mode_draft === 2) selected @endif
                                @endif value="2">
                                {{ App\Accunity\Utils::PAYMENT_MODES[2] }}
                            </option>
                            <option @if (isset($voucher->payment_mode_draft)) @if ($voucher->payment_mode_draft === 3) selected @endif
                                @endif value="3">
                                {{ App\Accunity\Utils::PAYMENT_MODES[3] }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-4">
                        <label for="date">Payment Date</label>
                        <input type="date" class="form-control" id="date" name="date"
                            @if (isset($voucher->payment_date_draft)) value="{{ $voucher->payment_date_draft->format('Y-m-d') }}" @else value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" @endif
                            required>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="remark">Payment Remark</label>
                        <input type="text" class="form-control" id="remark" name="remark"
                            @if (isset($voucher->payment_remark_draft)) value="{{ $voucher->payment_remark_draft }}" @endif
                            required>
                    </div>
                </div>
            </form>
        @endif

        @if ($voucher->status > 1)
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
                                @foreach ($perCategoryTotal as $category => $total)
                                    <tr scope="row" style="font-size: 1.2rem;">
                                        <td style="font-weight: 700;">{{ $category }}</td>
                                        <td>Rs. {{ $total }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <br>

            <div class="row">
                <div class="col-sm-3">
                    <b>Special Remark: </b> {{ $voucher->special_remark }}
                </div>
            </div>

        @endif

        <div class="form-group mt-3 mx-auto">
            @if ($voucher->status === 0)
                <div class="alert alert-primary" role="alert">
                    Approval is not yet requested by the author of this voucher!
                </div>
            @elseif($voucher->status === 1)
                <button class="btn btn-warning" id="saveVoucherDraftBtn">
                    <i class="fas fa-save"></i> Save Draft
                </button>
                <button class="btn btn-success" id="approveVoucherBtn">
                    <i class="fas fa-check"></i> Approve
                </button>
                <button class="btn btn-danger" id="rejectVoucherBtn">
                    <i class="fas fa-times"></i> Reject
                </button>
            @elseif($voucher->status === 2)
                <div class="alert alert-success" role="alert">
                    This voucher has been approved!
                    @if (auth()->user()->is_admin)
                        <a href="{{ route('employees.voucherDetailsPdf', ['id' => $voucher->id]) }}"
                            class="btn btn-secondary ml-2">
                            <i class="fas fa-print"></i> Print Report
                        </a>
                    @endif
                </div>
            @elseif($voucher->status === 3)
                <div class="alert alert-danger" role="alert">
                    This voucher has been rejected!
                    @if (auth()->user()->is_admin)
                        <a href="{{ route('employees.voucherDetailsPdf', ['id' => $voucher->id]) }}"
                            class="btn btn-secondary ml-2">
                            <i class="fas fa-print"></i> Print Report
                        </a>
                    @endif
                </div>
            @endif
        </div>

    </div>

    <input type="hidden" id="voucherId" value="{{ $voucher->id }}">
    <input type="hidden" id="url" value="{{ route('vouchers.voucherApproveReject') }}">
    <input type="hidden" id="voucherSaveDraftUrl" value="{{ route('vouchers.voucherSaveDraft') }}">
@stop



@section('js')
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAQb-7NDLDsJh-l3siJQ_1gEw2lBgWKYlU&libraries=places,diections">
        // src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC-5CY9mOCeg5Y3IhPqi_Yd0-DZtWrJl-E&callback=myMap&q=lahore">
    </script>
    <script>
        const ele = (id) => {
            return document.getElementById(id);
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
    <script src="{{ asset('js/downloadfiles.js') }}"></script>
    <script src="{{ asset('js/adminVoucherApproval.js') }}"></script>
    <script src="{{ asset('js/s2.js') }}"></script>
@stop
