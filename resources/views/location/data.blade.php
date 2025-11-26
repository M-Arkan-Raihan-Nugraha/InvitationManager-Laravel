<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h3 class="card-title">Daftar Lokasi</h3>
    <a href="{{ route('location.create') }}" class="btn btn-primary btn-sm">Tambah Lokasi</a>
  </div>

  <div class="card-body">
    <table class="table table-bordered table-striped text-center">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nama</th>
          <th>Alamat</th>
          <th>Kota</th>
          <th>Provinsi</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($data as $l)
        <tr>
          <td>{{ $l->id }}</td>
          <td>{{ $l->name }}</td>
          <td>{{ $l->address }}</td>
          <td>{{ $l->city }}</td>
          <td>{{ $l->province }}</td>
          <td>
            <a href="{{ route('location.edit', $l->id) }}" class="btn btn-warning btn-sm">Edit</a>

            <form action="{{ route('location.destroy', $l->id) }}" method="POST" style="display:inline"
              onsubmit="return confirm('Yakin mau hapus location {{ $l->name }}?')">
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