@extends('templates.layout')

@section('content')
  <div class="card">
    <div class="card-header">
      <h3>Tambah Kehadiran</h3>
    </div>
    <div class="card-body">

      @if ($errors->any())
        <div class="alert alert-danger">
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form action="{{ route('attendance.store') }}" method="POST">
        @csrf

        <div class="form-group mb-2">
          <label for="invitation_id" class="form-label">Undangan</label>
          <select name="invitation_id" class="form-select" required>
            <option value="">-- Pilih Undangan --</option>
            @foreach ($invitations as $inv)
              <option value="{{ $inv->id }}">{{ $inv->title }}</option>
            @endforeach
          </select>
        </div>

        <div class="form-group mb-2">
          <label for="guest_id" class="form-label">Tamu</label>
          <select name="guest_id" class="form-select" required>
            <option value="">-- Pilih Tamu --</option>
            @foreach ($guests as $guest)
              <option value="{{ $guest->id }}">{{ $guest->name }}</option>
            @endforeach
          </select>
        </div>

        <div class="form-group mb-2">
          <label for="status" class="form-label">Status</label>
          <select name="status" class="form-select">
            <option value="pending">Pending</option>
            <option value="present">Present</option>
            <option value="not_present">Not Present</option>
          </select>
        </div>


        <div class="form-group mb-2">
          <label for="response_time" class="form-label">Response Time</label>
          <input type="datetime-local" name="response_time" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('attendance.index') }}" class="btn btn-secondary">Batal</a>
      </form>

    </div>
  </div>
@endsection