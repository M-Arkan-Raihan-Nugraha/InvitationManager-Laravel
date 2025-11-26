<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h3 class="card-title">Daftar Tamu</h3>
    <a href="{{ route('guest.create') }}" class="btn btn-primary btn-sm">Tambah Tamu</a>
  </div>

  <div class="card-body">
    <table class="table table-bordered table-striped text-center">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nama</th>
          <th>Alamat</th>
          <th>Telepon</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($data as $g)
        <tr>
          <td>{{ $g->id }}</td>
          <td>{{ $g->name }}</td>
          <td>{{ $g->address }}</td>
          <td>{{ $g->contact }}</td>
          <td>
            <a href="{{ route('guest.edit', $g->id) }}" class="btn btn-warning btn-sm">Edit</a>

            <form action="{{ route('guest.destroy', $g->id) }}" method="POST" style="display:inline"
              onsubmit="return confirm('Yakin mau hapus guest {{ $g->name }}?')">
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