@extends('templates.layout')

@section('content')
<div class="card shadow-sm">
  <div class="card-header">
    <h3>Edit Undangan</h3>
  </div>

  <div class="card-body">
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('invitation.update', $invitation->id) }}" method="POST">
      @csrf
      @method('PUT')

      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label fw-bold">Judul Undangan</label>
          <input type="text" name="title" class="form-control"
                 value="{{ old('title', $invitation->title) }}" required>
        </div>

        <div class="col-md-6 mb-3">
          <label class="form-label fw-bold">Tanggal Acara</label>
          <input type="date" name="date" class="form-control"
                 value="{{ old('date', \Carbon\Carbon::parse($invitation->date)->format('Y-m-d')) }}" required>
        </div>

        <div class="col-md-12 mb-3">
          <label class="form-label fw-bold">Deskripsi</label>
          <textarea name="description" class="form-control" rows="3">{{ old('description', $invitation->description) }}</textarea>
        </div>

        <div class="col-md-6 mb-3">
          <label class="form-label fw-bold">Lokasi</label>
          <select name="location_id" class="form-select" required>
            <option value="">-- Pilih Lokasi --</option>
            @foreach($locations as $loc)
              <option value="{{ $loc->id }}"
                {{ old('location_id', $invitation->location_id) == $loc->id ? 'selected' : '' }}>
                {{ $loc->name }}
              </option>
            @endforeach
          </select>
        </div>

        <div class="col-md-6 mb-4">
          <label class="form-label fw-bold">Kategori</label>
          <select name="category_id" class="form-select" required>
            <option value="">-- Pilih Kategori --</option>
            @foreach($categories as $cat)
              <option value="{{ $cat->id }}"
                {{ old('category_id', $invitation->category_id) == $cat->id ? 'selected' : '' }}>
                {{ $cat->name }}
              </option>
            @endforeach
          </select>
        </div>
      </div>

      <hr>
      <h5 class="fw-bold mb-3">Pilih Tamu Undangan</h5>

      <div class="row" id="guestCards">
        @foreach($guests as $guest)
          @php
            $selectedGuests = old('guest_ids')
              ? explode(',', old('guest_ids'))
              : $invitation->guests->pluck('id')->toArray();
          @endphp

          <div class="col-md-3 mb-3">
            <div class="card guest-card h-100 text-center border-2
                {{ in_array($guest->id, $selectedGuests) ? 'selected' : '' }}"
                data-id="{{ $guest->id }}"
                onclick="toggleGuest({{ $guest->id }})">
              <div class="card-body d-flex flex-column justify-content-center">
                <h5 class="card-title mb-2 fw-semibold text-dark">{{ $guest->name }}</h5>

                <div class="guest-info text-muted small">
                  <div class="d-flex align-items-start mb-1">
                    <i class="bi bi-geo-alt-fill me-1 text-danger"></i>
                    <span>{{ $guest->address }}</span>
                  </div>
                  <div class="d-flex align-items-center">
                    <i class="bi bi-telephone-fill me-1 text-success"></i>
                    <span>{{ $guest->contact }}</span>
                  </div>
                </div>
              </div>

              <div class="card-footer bg-light">
                <span class="btn btn-sm btn-outline-primary select-btn">
                  {{ in_array($guest->id, $selectedGuests) ? 'Dipilih' : 'Tambah' }}
                </span>
              </div>
            </div>
          </div>
        @endforeach
      </div>
      
      <div id="selectedGuestsContainer"></div>

      <hr>
      <div class="d-flex justify-content-end">
        <a href="{{ route('invitation.index') }}" class="btn btn-secondary me-2">Batal</a>
        <button type="submit" class="btn btn-success">Update Undangan</button>
      </div>
    </form>
  </div>
</div>

<style>
  .guest-card {
    cursor: pointer;
    transition: all 0.2s ease;
    border-radius: 12px;
  }

  .guest-card:hover {
    transform: scale(1.03);
    box-shadow: 0 0 12px rgba(0, 0, 0, 0.1);
  }

  .guest-card.selected {
    border-color: #198754 !important;
    background-color: #e9fbea;
  }

  .guest-card.selected .select-btn {
    background-color: #198754;
    color: white;
    border-color: #198754;
  }

  .guest-info {
    text-align: left;
    margin-top: 5px;
  }

  .guest-info i {
    font-size: 14px;
    opacity: 0.8;
  }

  .card-footer {
    border-top: none;
  }
</style>

<script>
  const selected = new Set(
    "{{ implode(',', $selectedGuests) }}"
      .split(',')
      .filter(id => id)
      .map(Number)
  );

  function toggleGuest(id) {
      const card = document.querySelector(`.guest-card[data-id="${id}"]`);
      const btn = card.querySelector('.select-btn');

      if (selected.has(id)) {
          selected.delete(id);
          card.classList.remove('selected');
          btn.textContent = 'Tambah';
      } else {
          selected.add(id);
          card.classList.add('selected');
          btn.textContent = 'Dipilih';
      }

      updateHiddenInputs();
  }

  function updateHiddenInputs() {
      const container = document.getElementById('selectedGuestsContainer');
      container.innerHTML = '';

      selected.forEach(id => {
          const input = document.createElement('input');
          input.type = 'hidden';
          input.name = 'guest_ids[]';
          input.value = id;
          container.appendChild(input);
      });
  }

// Generate input awal saat halaman dibuka
updateHiddenInputs();

</script>
@endsection
