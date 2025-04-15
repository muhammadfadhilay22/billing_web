@extends('administrator.layouts.master')

@section('title', 'Dashboard')

@section('content')
<h1>Selamat Datang, {{ $user->namauser }}</h1>

@if ($roles && $roles->isNotEmpty())
<p>Anda login sebagai <strong>{{ $roles->first() }}</strong>.</p>
@else
<p><strong>Role belum tersedia.</strong></p>
@endif
@endsection