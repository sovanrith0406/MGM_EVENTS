@extends('backend.layouts.master')
@section('title', 'Add New Event')
@section('e_menu-open', 'menu-open')
@section('e_active', 'active')

@section('main-content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6"><h1>Add New Event</h1></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('events.index') }}">Events</a></li>
                        <li class="breadcrumb-item active">Add Event</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Event Information</h3>
                </div>

                {{-- enctype required for file upload --}}
                <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
                    @csrf
                    <div class="card-body">

                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Event Name --}}
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Event Name <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" name="event_name"
                                       class="form-control @error('event_name') is-invalid @enderror"
                                       value="{{ old('event_name') }}"
                                       placeholder="e.g. Tech Summit 2026">
                                @error('event_name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        {{-- Description --}}
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Description</label>
                            <div class="col-sm-10">
                                <textarea name="description" rows="4"
                                          class="form-control @error('description') is-invalid @enderror"
                                          placeholder="Event description...">{{ old('description') }}</textarea>
                                @error('description')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        {{-- Image Upload --}}
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Event Image</label>
                            <div class="col-sm-10">
                                <div class="custom-file">
                                    <input type="file" name="image" id="image" accept="image/*"
                                           class="custom-file-input @error('image') is-invalid @enderror"
                                           onchange="previewImage(this)">
                                    <label class="custom-file-label" for="image">Choose image...</label>
                                </div>
                                @error('image')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
                                <small class="text-muted">Accepted: jpg, jpeg, png, webp. Max size: 2MB.</small>
                                <div class="mt-2">
                                    <img id="image-preview" src="#" alt="Preview"
                                         class="img-thumbnail" style="max-height: 180px; display: none;">
                                </div>
                            </div>
                        </div>

                        {{-- Start Date & End Date --}}
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Start Date <span class="text-danger">*</span></label>
                            <div class="col-sm-4">
                                <input type="date" name="start_date"
                                       class="form-control @error('start_date') is-invalid @enderror"
                                       value="{{ old('start_date') }}">
                                @error('start_date')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                            <label class="col-sm-2 col-form-label">End Date <span class="text-danger">*</span></label>
                            <div class="col-sm-4">
                                <input type="date" name="end_date"
                                       class="form-control @error('end_date') is-invalid @enderror"
                                       value="{{ old('end_date') }}">
                                @error('end_date')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        {{-- Timezone --}}
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Timezone <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <select name="timezone" class="form-control @error('timezone') is-invalid @enderror">
                                    <option value="">-- Select Timezone --</option>
                                    <option value="UTC"              {{ old('timezone') == 'UTC'             ? 'selected' : '' }}>UTC</option>
                                    <option value="Asia/Phnom_Penh"  {{ old('timezone', 'Asia/Phnom_Penh') == 'Asia/Phnom_Penh' ? 'selected' : '' }}>Asia/Phnom_Penh (ICT +7)</option>
                                    <option value="Asia/Singapore"   {{ old('timezone') == 'Asia/Singapore'  ? 'selected' : '' }}>Asia/Singapore (SGT +8)</option>
                                    <option value="Asia/Tokyo"       {{ old('timezone') == 'Asia/Tokyo'      ? 'selected' : '' }}>Asia/Tokyo (JST +9)</option>
                                    <option value="America/New_York" {{ old('timezone') == 'America/New_York'? 'selected' : '' }}>America/New_York (EST)</option>
                                    <option value="Europe/London"    {{ old('timezone') == 'Europe/London'   ? 'selected' : '' }}>Europe/London (GMT)</option>
                                </select>
                                @error('timezone')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        {{-- Venue --}}
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Venue <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <select name="venue_id" class="form-control @error('venue_id') is-invalid @enderror">
                                    <option value="">-- Select Venue --</option>
                                    @foreach($venues as $venue)
                                        <option value="{{ $venue->venue_id }}"
                                            {{ old('venue_id') == $venue->venue_id ? 'selected' : '' }}>
                                            {{ $venue->name ?? $venue->venue_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('venue_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        {{-- Price & Currency --}}
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Price <span class="text-danger">*</span></label>
                            <div class="col-sm-7">
                                <input type="number" name="price" step="0.01" min="0"
                                       class="form-control @error('price') is-invalid @enderror"
                                       value="{{ old('price', '0.00') }}"
                                       placeholder="0.00">
                                @error('price')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-sm-3">
                                <select name="currency" class="form-control @error('currency') is-invalid @enderror">
                                    <option value="USD" {{ old('currency', 'USD') == 'USD' ? 'selected' : '' }}>USD</option>
                                    <option value="KHR" {{ old('currency') == 'KHR' ? 'selected' : '' }}>KHR</option>
                                    <option value="EUR" {{ old('currency') == 'EUR' ? 'selected' : '' }}>EUR</option>
                                </select>
                                @error('currency')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        {{-- Status --}}
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Status <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <select name="status" class="form-control @error('status') is-invalid @enderror">
                                    <option value="draft"     {{ old('status', 'draft') == 'draft'     ? 'selected' : '' }}>Draft</option>
                                    <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                                </select>
                                @error('status')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>

                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i> Save Event
                        </button>
                        <a href="{{ route('events.index') }}" class="btn btn-secondary ml-2">
                            <i class="fas fa-times mr-1"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

@push('scripts')
<script>
    function previewImage(input) {
        const preview = document.getElementById('image-preview');
        const label   = input.nextElementSibling;
        if (input.files && input.files[0]) {
            label.textContent = input.files[0].name;
            preview.src = URL.createObjectURL(input.files[0]);
            preview.style.display = 'block';
        } else {
            label.textContent = 'Choose image...';
            preview.style.display = 'none';
        }
    }
</script>
@endpush
@endsection