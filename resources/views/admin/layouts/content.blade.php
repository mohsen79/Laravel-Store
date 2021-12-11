@extends('admin.layouts.master')
@section('title')
    {{ $title }}
@endsection
@section('content')



    {{-- Preloader
    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__wobble" src="/dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
    </div> --}}


    <!-- Content Wrapper. Contains page content -->
    <section class="content-wrapper">
        <div class="container-fluid">
            {{ $slot }}
        </div>
    </section>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 3.1.0
        </div>
    </footer>
@endsection
@section('script')
    {{ $script ?? '' }}
@endsection
