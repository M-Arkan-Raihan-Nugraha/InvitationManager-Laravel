@extends('templates.layout')

@section('title', 'Home Page')

@section('content')
<div class="container-fluid">

  @if (session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
  @endif

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <!-- Welcome Message -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="alert alert-primary">
        <h4>Selamat Datang di Aplikasi Manajemen Undangan</h4>
        <p>Ini adalah dashboard utama untuk mengelola data.</p>
      </div>
    </div>
  </div>

  <!-- Statistik Box -->
  <div class="row">
    <!--begin::Col-->
    <div class="col-lg-3 col-6">
      <!--begin::Small Box Widget 1-->
      <div class="small-box text-bg-danger">
        <div class="inner">
          <h3>{{ $jumlah_undangan ?? 0 }}</h3>
          <p>Jumlah Undangan</p>
        </div>
        <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
          aria-hidden="true">
          <path d="M8 7a.5.5 0 0 1 .5.5V9H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V10H6a.5.5 0 0 1 0-1h1.5V7.5A.5.5 0 0 1 8 7"/>
          <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z"/>
        </svg>
        <a href="/invitation" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
          Lihat Undangan <i class="bi bi-link-45deg"></i>
        </a>
      </div>
      <!--end::Small Box Widget 1-->
    </div>
    <!--end::Col-->
    <div class="col-lg-3 col-6">
      <!--begin::Small Box Widget 2-->
      <div class="small-box text-bg-warning">
        <div class="inner">
          <h3>{{ $jumlah_tamu ?? 0 }}</h3>
          <p>Jumlah Tamu</p>
        </div>
        <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
          aria-hidden="true">
          <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1zm-7.978-1L7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002-.014.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0M6.936 9.28a6 6 0 0 0-1.23-.247A7 7 0 0 0 5 9c-4 0-5 3-5 4q0 1 1 1h4.216A2.24 2.24 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816M4.92 10A5.5 5.5 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0m3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4"/>
        </svg>
        <a href="/guest" class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover">
          Lihat Tamu <i class="bi bi-link-45deg"></i>
        </a>
      </div>
      <!--end::Small Box Widget 2-->
    </div>
    <!--end::Col-->

    <div class="col-lg-3 col-6">
      <!--begin::Small Box Widget 3-->
      <div class="small-box text-bg-success">
        <div class="inner">
          <h3>{{ $jumlah_kehadiran ?? 0 }}</h3>
          <p>Jumlah Kehadiran</p>
        </div>
        <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
          aria-hidden="true">
          <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m1.679-4.493-1.335 2.226a.75.75 0 0 1-1.174.144l-.774-.773a.5.5 0 0 1 .708-.708l.547.548 1.17-1.951a.5.5 0 1 1 .858.514M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4"/>
          <path d="M8.256 14a4.5 4.5 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10q.39 0 .74.025c.226-.341.496-.65.804-.918Q8.844 9.002 8 9c-5 0-6 3-6 4s1 1 1 1z"/>
        </svg>
        <a href="/attendance" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
          Lihat Kehadiran <i class="bi bi-link-45deg"></i>
        </a>
      </div>
      <!--end::Small Box Widget 3-->
  <!--end::Row-->
@endsection