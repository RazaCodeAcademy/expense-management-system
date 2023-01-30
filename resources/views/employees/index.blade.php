@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Employees</h1>
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
    <p>List of all your employees is visible here.</p>

    <div class="card px-3 py-1">
        <div class="my-3">
            <a class="btn btn-success float-right" href="{{ route('employees.create') }}">+ Create New Employee</a>
        </div>
        <br>
        <div class="card-body">
            {{-- <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="min">From :</label>
                        <input type="date" id="min" class="form-control">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="max">To :</label>
                        <input type="date" id="max" class="form-control">
                    </div>
                </div>
            </div> --}}
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
                    @foreach ($employees as $employee)
                        <tr>
                            <td>{{ $employee->name }}</td>
                            <td>{{ $employee->code }}</td>
                            <td>{{ $employee->email }}</td>
                            <td>{{ $employee->number }}</td>
                            <td>
                                <span>
                                    <a target="_blank"  href="{{ asset('storage/employee/' . $employee->photo) }}">
                                        <img width="50" height="60"
                                            src="{{ asset('storage/employee/' . $employee->photo) }}" class="img-thumbnail"
                                            alt="Employee photo" />
                                    </a>
                                </span>
                            </td>
                            <td>
                                <span>
                                    <a target="_blank"  href="{{ asset('storage/employee/' . $employee->aadhar_photo) }}">
                                        <img width="50" height="60"
                                            src="{{ asset('storage/employee/' . $employee->aadhar_photo) }}"
                                            class="img-thumbnail" alt="Employee Id Card Photo" />
                                    </a>
                                </span>
                            </td>
                            <td>
                                <span>
                                    <a target="_blank"  href="{{ asset('storage/employee/' . $employee->front_license) }}">
                                        <img width="50" height="60"
                                            src="{{ asset('storage/employee/' . $employee->front_license) }}" class="img-thumbnail"
                                            alt="Employee front_license" />
                                    </a>
                                </span>
                            </td>
                            <td>
                                <span>
                                    <a target="_blank" href="{{ asset('storage/employee/' . $employee->back_license) }}">
                                        <img width="50" height="60"
                                            src="{{ asset('storage/employee/' . $employee->back_license) }}"
                                            class="img-thumbnail" alt="Employee back_license" />
                                    </a>
                                </span>
                            </td>
                            <td>
                                <span
                                    class="badge @if ($employee->wallet_balance > 0) badge-primary @else badge-warning @endif px-2 py-2"
                                    style="font-size: 1.2rem;">
                                    Rs. {{ $employee->wallet_balance }}
                                </span>
                            </td>
                            <td>
                                {{ $employee->password }}
                            </td>
                            <td>
                                @if ($employee->user->active)
                                    <span class="badge badge-success px-2 py-2" style="font-size: 1rem;">
                                        Active
                                    </span>
                                @else
                                    <span class="badge badge-danger px-2 py-2" style="font-size: 1rem;">
                                        Inactive
                                    </span>
                                @endif
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
                                            href="{{ route('employees.addbalance', ['id' => $employee->id]) }}">Add
                                            Balance</a>
                                        <a class="dropdown-item text-primary"
                                            href="{{ route('employees.edit', ['id' => $employee->id]) }}">Edit</a>
                                        <div class="dropdown-divider"></div>
                                        @if ($employee->user->active)
                                            <a class="dropdown-item text-danger deactivateBtn"
                                                href="{{ route('employees.destroy', ['id' => $employee->id]) }}">
                                                Deactivate
                                            </a>
                                        @else
                                            <a class="dropdown-item text-success activateBtn"
                                                href="{{ route('employees.activate', ['id' => $employee->id]) }}">
                                                Activate
                                            </a>
                                        @endif
                                        <a style="{{ $employee->wallet_balance >= 0 ? 'pointer-events: none' : '' }}" class="dropdown-item text-primary"
                                            href="{{ route('employees.payamount', ['id' => $employee->id]) }}">Pay Amount</a>
                                    </div>
                                </div>
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
        {{-- <script src="{{ asset('/dist/js/adminlte.min.js') }}"></script> --}}
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
    @endpush

@stop

@section('js')
    <script src="{{ asset('js/tableFilter.js') }}"></script>
    <script src="{{ asset('js/empactdeact.js') }}"></script>
@stop
