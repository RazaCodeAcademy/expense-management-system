@extends('adminlte::page')

@section('title', 'List Of Vouchers Requested For Approval')

@section('content_header')
    <h1>List Of Vouchers Requested For Approval</h1>
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
                        <th scope="col">Employee Name</th>
                        {{-- <th scope="col">Job Numbers</th> --}}
                        <th scope="col">Voucher Number</th>
                        <th scope="col">Voucher Date</th>
                        <th scope="col">Proposed Amount</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($vouchers as $voucher)
                        <?php
                        $expenses = $voucher->expenses;
                        $total_amt = 0.0;
                        foreach ($expenses as $exp) {
                            $total_amt += $exp->amount;
                        }

                        ?>
                        <tr>
                            <td>{{ $voucher->employee()->first()->name }}</td>
                            {{-- <td>
                                @foreach ($voucher->jobs as $job)
                                    {{ $job->number }}@if (!$loop->last)
                                        ,
                                    @endif
                                @endforeach
                            </td> --}}
                            <td>{{ $voucher->number }}</td>
                            <td>
                                @if (isset($voucher->date))
                                    {{ $voucher->date->format('Y-m-d') }}
                                @endif
                            </td>
                            <td>
                                <span class="badge badge-primary px-2 py-2">
                                    Rs. {{ $total_amt }}
                                </span>
                            </td>
                            <td>
                                <a class="btn btn-primary"
                                    href="{{ route('employees.voucherDetails', ['id' => $voucher->id]) }}">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
    @push('js')
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
        <script src="{{ asset('/dist/js/adminlte.min.js') }}"></script>
        <script>
            $(function() {
                $("#example1").DataTable({
                    "order": [[1, 'desc']],
                    "oSearch": {
                    "sSearch": "{{ date('Y-m') }}"
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
    @endpush
@stop

{{-- @section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop --}}

@section('js')
    <script src="{{ asset('js/tableFilter.js') }}"></script>
@stop
