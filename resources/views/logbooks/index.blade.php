@extends('adminlte::page')

@section('title', 'Logbooks')

@section('content_header')
    <h1>Logbooks</h1>
@stop

@section('content')

    @push('css')
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ asset('/plugins/fontawesome-free/css/all.min.css') }}">
        <!-- DataTables -->
        <link rel="stylesheet" href="{{ asset('/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{ asset('/dist/css/adminlte.min.css') }}">
    @endpush

    <p class="float-left">List of all of your logbooks is visible here.</p>
    {{-- <div class="float-right">
        <a href="{{ route('vouchers.create') }}" class="btn btn-primary">+ Create New Voucher</a>
    </div> --}}

    <br><br><br><br>

    <div class="card px-3 py-1">
        <!-- /.card-header -->
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="min">From :</label>
                        <input type="date" id="min" onfocus="this.showPicker()" value="{{ date('Y-m-01') }}"
                            class="form-control">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="max">To :</label>
                        <input type="date" id="max" onfocus="this.showPicker()" value="{{ date('Y-m-d') }}"
                            class="form-control">
                    </div>
                </div>
            </div>
            <table id="example1" class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Id</th>
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
                    @foreach ($logbooks as $log)
                        <tr>
                            <td>{{ $log->id }}</td>
                            <td>{{ $log->prev_reading }}</td>
                            <td>{{ $log->current_reading }}</td>
                            <td>{{ $log->distance }}</td>
                            <td>{{ $log->purpose }}</td>
                            <td>{{ $log->leters }}</td>
                            <td>
                                <span class="badge badge-primary px-2 py-2">
                                    Rs. {{ $log->fuel_price_total }}
                                </span>
                            </td>
                            <td>
                                {{ date('Y-m-d', strtotime($log->created_at)) }}
                            </td>
                            <td>
                                {{ $log->fuel_price_total }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                {{-- <tfoot>
                    <tr>
                        <th>Total Distance : </th>
                        <td id="total_distance"></td>
                        <th>Total Amount : </th>
                        <td id="total_fuel"></td>
                        <th>Total Average : </th>
                        <td id="total_avg"></td>
                    </tr>
                </tfoot> --}}
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

    @push('js')
        <!-- jQuery -->
        <script src="{{ asset('/plugins/jquery/jquery.min.js') }}"></script>
        <!-- Bootstrap 4 -->
        <script src="{{ asset('/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <!-- DataTables  & Plugins -->
        <script src="{{ asset('/plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('/plugins/jszip/jszip.min.js') }}"></script>
        <script src="{{ asset('/plugins/pdfmake/pdfmake.min.js') }}"></script>
        <script src="{{ asset('/plugins/pdfmake/vfs_fonts.js') }}"></script>
        <script src="{{ asset('/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
        <script src="{{ asset('/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
        <!-- AdminLTE App -->
        {{-- <script src="{{ asset('/dist/js/adminlte.min.js') }}"></script> --}}
        <script>
            const ele = (id) => {
                return document.getElementById(id);
            }
            $(function() {
                $("#example1").DataTable({
                    "order": [
                        [0, 'desc']
                    ],
                    "oSearch": {
                    "sSearch": "{{ date('Y-m') }}"
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
                        total_distance += parseFloat(data[3])/2;
                        total_fuel += parseFloat(data[5])/2;
                        total_avg = Math.round(((total_distance/total_fuel) + Number.EPSILON) * 100) / 100;
                        $('input[type="search"]').val('').keyup();
                        var FilterStart = $('#min').val();
                        var FilterEnd = $('#max').val();
                        var DataTableStart = data[7].trim();
                        var DataTableEnd = data[7].trim();
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
    @endpush
@stop

{{-- @section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop --}}
