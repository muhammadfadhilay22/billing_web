@extends('administrator.layouts.master')

@section('title', 'Dashboard')

@section('content')
<h1>Selamat Datang, {{ Auth::user()->username }} di Dashboard {{ Auth::user()->role }}</h1>
<p>Ini adalah halaman utama admin.</p>
@endsection