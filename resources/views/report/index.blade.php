@extends('templates.layout')

@section('title', 'Report Page')

@section('content')
<div class="container mt-4">
  <div class="card shadow-sm border-0">
    <div class="card-header bg-light">
      <h4 class="mb-0 text-center fw-bold">📋 Laporan Undangan</h4>
    </div>

    <div class="card-body">
      <!-- 🔍 Filter Section -->
      <form method="GET" action="{{ route('report.index') }}" class="row g-3 align-items-end mb-4 no-print">
        <div class="col-md-3">
          <label class="form-label fw-semibold">Periode Awal</label>
          <input type="date" name="start_date" value="{{ request('start_date') }}" class="form-control">
        </div>
        <div class="col-md-3">
          <label class="form-label fw-semibold">Periode Akhir</label>
          <input type="date" name="end_date" value="{{ request('end_date') }}" class="form-control">
        </div>
        <div class="col-md-3">
          <label class="form-label fw-semibold">Kategori Undangan</label>
          <select name="category_id" class="form-select">
            <option value="">Semua Kategori</option>
            @foreach($categories as $cat)
              <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                {{ $cat->name }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="col-md-3">
          <label class="form-label fw-semibold">Lokasi Acara</label>
          <select name="location_id" class="form-select">
            <option value="">Semua Lokasi</option>
            @foreach($locations as $loc)
              <option value="{{ $loc->id }}" {{ request('location_id') == $loc->id ? 'selected' : '' }}>
                {{ $loc->name }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="col-12 d-flex justify-content-end gap-2">
          <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i> Tampilkan</button>
          <a href="{{ route('report.index') }}" class="btn btn-secondary">Reset</a>
          <button id="print-now" type="button" class="btn btn-success"><i class="bi bi-printer"></i> Cetak</button>
        </div>
      </form>

      <!-- 🧾 Info Ringkasan -->
      <div class="bg-light p-3 rounded mb-3">
        <strong>Periode:</strong> 
        {{ request('start_date') ? \Carbon\Carbon::parse(request('start_date'))->format('d M Y') : '-' }}
        s.d 
        {{ request('end_date') ? \Carbon\Carbon::parse(request('end_date'))->format('d M Y') : '-' }} <br>
        <strong>Kategori:</strong> {{ $selectedCategory ?? 'Semua' }} <br>
        <strong>Lokasi:</strong> {{ $selectedLocation ?? 'Semua' }}
      </div>

      <!-- 🧮 Ringkasan Angka -->
      <div class="row text-center mb-3 summary-row">
        <div class="col-md-3 col-6">
          <div class="p-3 bg-light rounded shadow-sm">
            <h6>Total Undangan</h6>
            <h5 class="fw-bold">{{ $totalInvitations }}</h5>
          </div>
        </div>
        <div class="col-md-3 col-6">
          <div class="p-3 bg-light rounded shadow-sm">
            <h6>Total Tamu</h6>
            <h5 class="fw-bold">{{ $totalGuests }}</h5>
          </div>
        </div>
        <div class="col-md-3 col-6">
          <div class="p-3 bg-light rounded shadow-sm">
            <h6>Hadir</h6>
            <h5 class="fw-bold text-success">{{ $present }}</h5>
          </div>
        </div>
        <div class="col-md-3 col-6">
          <div class="p-3 bg-light rounded shadow-sm">
            <h6>Tidak Hadir</h6>
            <h5 class="fw-bold text-danger">{{ $notPresent }}</h5>
          </div>
        </div>
      </div>

      <!-- 📊 Tabel Daftar Undangan -->
      <table class="table table-bordered align-middle text-center table-striped">
        <thead class="table-light">
          <tr>
            <th>No</th>
            <th>Judul Undangan</th>
            <th>Kategori</th>
            <th>Lokasi</th>
            <th>Jumlah Tamu</th>
            <th>Hadir</th>
            <th>Tidak Hadir</th>
            <th>Tanggal Acara</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($invitations as $i => $inv)
            <tr>
              <td>{{ $i + 1 }}</td>
              <td>{{ $inv->title }}</td>
              <td>{{ $inv->category->name ?? '-' }}</td>
              <td>{{ $inv->location->name ?? '-' }}</td>
              <td>{{ $inv->guests->count() }}</td>
              <td>{{ $inv->guests->where('pivot.status', 'present')->count() }}</td>
              <td>{{ $inv->guests->where('pivot.status', 'not_present')->count() }}</td>
              <td>{{ \Carbon\Carbon::parse($inv->date)->format('d M Y') }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="9" class="text-muted text-center">Tidak ada data undangan.</td>
            </tr>
          @endforelse
        </tbody>
      </table>

      <!-- 🔢 Pagination -->
      <div class="mt-3 no-print">
        {{ $invitations->links() }}
      </div>
    </div>
  </div>
</div>

@endsection

@push('script')
<script>
  function printCardOnly() {
    const card = document.querySelector('.card').cloneNode(true);
    const btns = card.querySelectorAll('button, a.btn');
    btns.forEach(b => b.remove());

    // ambil semua CSS aktif
    const styles = Array.from(document.styleSheets)
      .map(sheet => {
        try {
          return Array.from(sheet.cssRules).map(rule => rule.cssText).join('');
        } catch(e) {
          return '';
        }
      })
      .join('');

    // buka jendela print
    const printWindow = window.open('', '_blank', 'width=900,height=700');
    printWindow.document.write(`
      <html>
        <head>
          <title>Laporan Undangan - ${new Date().toLocaleDateString('id-ID')}</title>
          <style>
            ${styles}
            body {
              background: #fff;
              margin: 20px;
              font-family: 'Segoe UI', sans-serif;
            }
            .card {
              box-shadow: none !important;
              border: 1px solid #ccc !important;
            }
            table {
              width: 100%;
              border-collapse: collapse !important;
              font-size: 12px;
            }
            th, td {
              border: 1px solid #000 !important;
              padding: 6px;
            }
            .no-print {
              display: none !important;
            }
          </style>
        </head>
        <body>${card.outerHTML}</body>
      </html>
    `);
    printWindow.document.close();

    printWindow.addEventListener('load', function() {
      printWindow.focus();
      printWindow.print();
      setTimeout(() => printWindow.close(), 400);
    });
  }

  document.getElementById('print-now').addEventListener('click', printCardOnly);
</script>
@endpush