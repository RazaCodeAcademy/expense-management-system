@extends('adminlte::page')

@section('title', 'Expense Category Master - Create New Expense Category')

@section('content_header')
<h1>Create New Expense Category</h1>
@stop

@section('content')
    @push('css')
        <link href="{{asset('/toast/toastr1.css')}}" rel="stylesheet">
        <link href="{{asset('/toast/toastr2.css')}}" rel="stylesheet">
    @endpush

<div class="card px-3 py-1">

    <form method="POST" action="{{ route('expensecategories.store') }}">
        @include('expensecategories.form')
    </form>

</div>

@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop


@section('js')
@push('js')
<script src="{{asset('/toast/toastr.js')}}"></script>
    <script src="{{asset('/toast/toastr.min.js')}}"></script>
    @if(Session::has('success'))
    {{-- @dd(Session::has('success')) --}}
        <script>
            toastr.options.positionClass = 'toast-top-right';
            toastr.success('{{  Session::get('success') }}')
        </script>
    @endif

    @if(Session::has('error'))
        <script>
            toastr.options.positionClass = 'toast-top-right';
            toastr.error('{{  Session::get('error') }}')
        </script>
    @endif
    @endpush
<script>
    console.log('Hi!');

</script>
@stop
