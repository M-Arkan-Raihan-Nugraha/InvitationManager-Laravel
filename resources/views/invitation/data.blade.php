<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h3 class="card-title">Daftar Undangan</h3>
    <a href="{{ route('invitation.create') }}" class="btn btn-primary btn-sm">Tambah Undangan</a>
  </div>

  <div class="card-body">
    <table class="table table-bordered table-striped text-center">
      <thead>
        <tr>
          <th>ID</th>
          <th>Judul</th>
          <th>Tanggal</th>
          <th>Kategori</th>
          <th>Lokasi</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($invitations as $inv)
          <tr>
            <td>{{ $inv->id }}</td>
            <td>{{ $inv->title }}</td>
            <td>{{ $inv->date ? \Carbon\Carbon::parse($inv->date)->format('d M Y') : '-' }}</td>
            <td>{{ $inv->category->name ?? '-' }}</td>
            <td>{{ $inv->location->name ?? '-' }}</td>
            <td>
              <a href="{{ route('invitation.edit', $inv->id) }}" class="btn btn-warning btn-sm">Edit</a>
              <form action="{{ route('invitation.destroy', $inv->id) }}" method="POST" style="display:inline"
                onsubmit="return confirm('Yakin mau hapus invitation {{ $inv->name }}?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
