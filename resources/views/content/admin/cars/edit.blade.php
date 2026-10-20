@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Edit Mobil')

@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Data Mobil /</span> Edit</h4>

@include('content.admin._partials.flash')

@include('content.admin.cars._form', [
'car' => $car,
'action' => route('admin.cars.update', $car),
'method' => 'PUT',
])
@endsection
