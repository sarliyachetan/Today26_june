<!DOCTYPE html>
<html>
	@include('admin.layouts.head')
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php $user = auth()->user(); ?>

  @include('admin.layouts.header')
  <!-- Left side column. contains the logo and sidebar -->
  @include('admin.layouts.sidebar')

  <!-- Content Wrapper. Contains page content -->
  @yield('content')
  <!-- /.content-wrapper -->
  @include('admin.layouts.footer')