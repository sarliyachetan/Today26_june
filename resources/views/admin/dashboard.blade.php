@extends('admin.layouts.layout')
@section('title','Dashboard')
@section('content')
<style>
  .bg-yellow {
    background-color: #f39c12;
  }

  .bg-coupon {
    background-color: #00a65a;
  }

  .bg-category {
    background-color: #a67b00;
  }

  .bg-product {
    background-color: #a64d00;
  }

  .bg-slider {
    background-color: #85a600;
  }

  .bg-cms {
    background-color: #0097a6;
  }
</style>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Dashboard
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>
  <!-- Main content -->

  <!-- /.content -->
</div>
@endsection