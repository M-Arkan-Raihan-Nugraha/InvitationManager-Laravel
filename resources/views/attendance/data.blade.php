<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h3 class="card-title">Daftar Kehadiran</h3>
    <a href="{{ route('attendance.create') }}" class="btn btn-primary btn-sm">Tambah Kehadiran</a>
  </div>

  <div class="card-body">
    <table class="table table-bordered table-striped text-center align-middle">
      <thead class="table-light">
        <tr>
          <th>ID</th>
          <th>Judul Undangan</th>
          <th>Daftar Tamu</th>
          <th>Jumlah Tamu</th>
          <th>Rincian Kehadiran</th>
        </tr>
      </thead>
      <tbody>
        @forelse($data as $inv)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $inv->title }}</td>
            <td>
              {{ $inv->guests->unique('id')->pluck('name')->join(', ') ?: 'Belum ada tamu' }}
            </td>
            <td>{{ $inv->guests->count() }}</td>
            <td>
              Hadir: {{ $inv->guests->where('pivot.status', 'present')->count() }},
              Tidak Hadir: {{ $inv->guests->where('pivot.status', 'not_present')->count() }},
              Belum Respon: {{ $inv->guests->where('pivot.status', 'pending')->count() }}
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5">Belum ada data undangan.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
