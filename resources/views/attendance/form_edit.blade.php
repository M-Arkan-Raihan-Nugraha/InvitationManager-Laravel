@extends('templates.layout')

@section('content')
<div class="card">
  <div class="card-header"><h3>Edit Kehadiran</h3></div>
  <div class="card-body">
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
      </div>
    @endif

    <form action="{{ route('attendance.update', $attendance->id) }}" method="POST">
      @csrf
      @method('PUT')

      <div class="form-group mb-2">
        <label for="invitation_id" class="form-label">Invitation</label>
        <select name="invitation_id" class="form-select" required>
            @foreach ($invitations as $inv)
                <option value="{{ $inv->id }}" {{ $attendance->invitation_id == $inv->id ? 'selected' : '' }}>
                    {{ $inv->title }}
                </option>
            @endforeach
        </select>
      </div>

      <div class="form-group mb-2">
        <label for="guest_id" class="form-label">Guest</label>
        <select name="guest_id" class="form-select" required>
            @foreach ($guests as $guest)
                <option value="{{ $guest->id }}" {{ $attendance->guest_id == $guest->id ? 'selected' : '' }}>
                    {{ $guest->name }}
                </option>
            @endforeach
        </select>
      </div>

      <div class="form-group mb-2">
        <label for="status" class="form-label">Status</label>
        <select name="status" class="form-select">
            <option value="pending" {{ $attendance->status == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="present" {{ $attendance->status == 'present' ? 'selected' : '' }}>Present</option>
            <option value="not_present" {{ $attendance->status == 'not_present' ? 'selected' : '' }}>Not Present</option>
        </select>
      </div>

      <div class="form-group mb-2">
        <label for="response_time" class="form-label">Response Time</label>
        <input type="datetime-local" name="response_time" class="form-control"
            value="{{ $attendance->response_time ? \Carbon\Carbon::parse($attendance->response_time)->format('Y-m-d\TH:i') : '' }}">
      </div>

      <button type="submit" class="btn btn-success">Update</button>
      <a href="{{ route('attendance.index') }}" class="btn btn-secondary">Batal</a>
    </form>
  </div>
</div>
@endsection