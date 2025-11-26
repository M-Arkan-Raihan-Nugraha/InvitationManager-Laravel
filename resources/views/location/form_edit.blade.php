@extends('templates.layout')

@section('content')
<div class="card">
  <div class="card-header"><h3>Edit Lokasi</h3></div>
  <div class="card-body">
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
      </div>
    @endif

    <form action="{{ route('location.update', $location->id) }}" method="POST">
      @csrf
      @method('PUT')

      <div class="form-group mb-2">
        <label for="name">Nama</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $location->name) }}" required>
      </div>

      <div class="form-group mb-2">
        <label for="address">Alamat</label>
        <input type="text" name="address" class="form-control" value="{{ old('address', $location->address) }}" required>
      </div>

      <div class="form-group mb-2">
        <label for="city">Kota</label>
        <input type="text" name="city" class="form-control" value="{{ old('contact', $location->contact) }}" required>
      </div>

      <div class="form-group mb-2">
        <label for="province">Provinsi</label>
        <input type="text" name="province" class="form-control" value="{{ old('contact', $location->contact) }}" required>
      </div>

      <button type="submit" class="btn btn-success">Update</button>
      <a href="{{ route('location.index') }}" class="btn btn-secondary">Batal</a>
    </form>
  </div>
</div>
@endsection
