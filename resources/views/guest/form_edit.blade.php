@extends('templates.layout')

@section('content')
<div class="card">
  <div class="card-header"><h3>Edit Tamu</h3></div>
  <div class="card-body">
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
      </div>
    @endif

    <form action="{{ route('guest.update', $guest->id) }}" method="POST">
      @csrf
      @method('PUT')

      <div class="form-group mb-2">
        <label for="name">Nama</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $guest->name) }}" required>
      </div>

      <div class="form-group mb-2">
        <label for="address">Alamat</label>
        <input type="text" name="address" class="form-control" value="{{ old('address', $guest->address) }}" required>
      </div>

      <div class="form-group mb-2">
        <label for="contact">Telepon</label>
        <input type="text" name="contact" class="form-control" value="{{ old('contact', $guest->contact) }}" required>
      </div>

      <button type="submit" class="btn btn-success">Update</button>
      <a href="{{ route('guest.index') }}" class="btn btn-secondary">Batal</a>
    </form>
  </div>
</div>
@endsection
