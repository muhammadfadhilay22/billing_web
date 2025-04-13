@extends('administrator.layouts.master')

@section('title', 'Dashboard')

@section('content')
<h1>Selamat Datang, {{ Auth::user()->namauser }}</h1>
<p>Anda login sebagai <strong>{{ Auth::user()->getRoleNames()->first() }}</strong>.</p>

@endsection