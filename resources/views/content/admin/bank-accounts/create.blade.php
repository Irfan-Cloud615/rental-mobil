@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Tambah Rekening')

@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Rekening Bank /</span> Tambah</h4>

@include('content.admin._partials.flash')

@include('content.admin.bank-accounts._form', [
'account' => $account,
'action' => route('admin.bank-accounts.store'),
'method' => 'POST',
])
@endsection
