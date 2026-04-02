@extends('backend.layouts.master')
@section('title', 'Create Sponsor | Event')
@section('sp_menu-open', 'menu-open')
@section('sp_active', 'active')

@section('main-content')
<div class="content-wrapper">

    {{-- Page Header --}}
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add Sponsor</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('/sponsors') }}">Sponsors</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <form action="{{ url('/sponsors') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">

                    {{-- LEFT COLUMN --}}
                    <div class="col-md-8">

                        {{-- Validation Errors --}}
                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <h6><i class="icon fas fa-ban"></i> Please fix the following errors:</h6>
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Company Info Card --}}
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-building mr-2"></i> Company Information
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="row">

                                    {{-- Company Name --}}
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="name">
                                                Company Name <span class="text-danger">*</span>
                                            </label>
                                            <input type="text"
                                                   name="name" id="name"
                                                   class="form-control @error('name') is-invalid @enderror"
                                                   value="{{ old('name') }}"
                                                   placeholder="e.g. Google, Meta, AWS"
                                                   required>
                                            @error('name')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Website --}}
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="website">Website</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-globe"></i>
                                                    </span>
                                                </div>
                                                <input type="url"
                                                       name="website" id="website"
                                                       class="form-control @error('website') is-invalid @enderror"
                                                       value="{{ old('website') }}"
                                                       placeholder="https://example.com">
                                                @error('website')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                </div>{{-- end row --}}
                            </div>
                        </div>

                        {{-- Contact Info Card --}}
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-address-card mr-2"></i> Contact Information
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="row">

                                    {{-- Contact Name --}}
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="contact_name">Contact Person</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-user"></i>
                                                    </span>
                                                </div>
                                                <input type="text"
                                                       name="contact_name" id="contact_name"
                                                       class="form-control @error('contact_name') is-invalid @enderror"
                                                       value="{{ old('contact_name') }}"
                                                       placeholder="Full name">
                                                @error('contact_name')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Contact Email --}}
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="contact_email">Email</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-envelope"></i>
                                                    </span>
                                                </div>
                                                <input type="email"
                                                       name="contact_email" id="contact_email"
                                                       class="form-control @error('contact_email') is-invalid @enderror"
                                                       value="{{ old('contact_email') }}"
                                                       placeholder="contact@example.com">
                                                @error('contact_email')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Contact Phone --}}
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="contact_phone">Phone</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-phone"></i>
                                                    </span>
                                                </div>
                                                <input type="text"
                                                       name="contact_phone" id="contact_phone"
                                                       class="form-control @error('contact_phone') is-invalid @enderror"
                                                       value="{{ old('contact_phone') }}"
                                                       placeholder="+855 12 000 000">
                                                @error('contact_phone')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                </div>{{-- end row --}}
                            </div>
                        </div>

                        {{-- Link to Event Card --}}
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-link mr-2"></i> Link to Event
                                    <small class="ml-2 font-weight-normal">(optional)</small>
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="row">

                                    {{-- Event --}}
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="event_id">Event</label>
                                            <select name="event_id" id="event_id"
                                                    class="form-control @error('event_id') is-invalid @enderror">
                                                <option value="">-- No event --</option>
                                                @foreach($events as $event)
                                                    <option value="{{ $event->event_id }}"
                                                        {{ old('event_id') == $event->event_id ? 'selected' : '' }}>
                                                        {{ $event->event_name }}
                                                        ({{ \Carbon\Carbon::parse($event->start_date)->format('M Y') }})
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('event_id')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Tier --}}
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="tier">Sponsor Tier</label>
                                            <select name="tier" id="tier" class="form-control">
                                                <option value="">-- Select Tier --</option>
                                                @foreach([
                                                    'platinum'  => '🏆 Platinum',
                                                    'gold'      => '🥇 Gold',
                                                    'silver'    => '🥈 Silver',
                                                    'bronze'    => '🥉 Bronze',
                                                    'community' => '🤝 Community',
                                                ] as $val => $label)
                                                    <option value="{{ $val }}"
                                                        {{ old('tier') == $val ? 'selected' : '' }}>
                                                        {{ $label }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    {{-- Amount --}}
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="amount">
                                                Amount ($)
                                                <small class="text-muted font-weight-normal" id="amount-hint"></small>
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">$</span>
                                                </div>
                                                <input type="number"
                                                    name="amount" id="amount"
                                                    class="form-control @error('amount') is-invalid @enderror"
                                                    value="{{ old('amount', 0) }}"
                                                    min="0" step="0.01"
                                                    placeholder="0.00">
                                                @error('amount')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <small class="text-muted">You can adjust the amount manually</small>
                                        </div>
                                    </div>

                                    {{-- Auto-fill Script --}}
                                    <script>
                                    const tierAmounts = {
                                        'platinum'  : 1000,
                                        'gold'      : 500,
                                        'silver'    : 300,
                                        'bronze'    : 200,
                                        'community' : 150,
                                    };

                                    const tierLabels = {
                                        'platinum'  : '🏆 default $1,000',
                                        'gold'      : '🥇 default $500',
                                        'silver'    : '🥈 default $300',
                                        'bronze'    : '🥉 default $200',
                                        'community' : '🤝 default $150',
                                    };

                                    document.getElementById('tier').addEventListener('change', function () {
                                        const val    = this.value;
                                        const amount = document.getElementById('amount');
                                        const hint   = document.getElementById('amount-hint');

                                        if (tierAmounts[val]) {
                                            amount.value = tierAmounts[val];
                                            hint.textContent = '— ' + tierLabels[val];
                                        } else {
                                            amount.value = 0;
                                            hint.textContent = '';
                                        }
                                    });

                                    // On page load — restore tier hint if old() value exists
                                    document.addEventListener('DOMContentLoaded', function () {
                                        const tier = document.getElementById('tier').value;
                                        const hint = document.getElementById('amount-hint');
                                        if (tier && tierLabels[tier]) {
                                            hint.textContent = '— ' + tierLabels[tier];
                                        }
                                    });
                                    </script>

                                </div>{{-- end row --}}
                            </div>
                        </div>

                    </div>{{-- end LEFT COLUMN --}}

                    {{-- RIGHT COLUMN --}}
                    <div class="col-md-4">

                        {{-- Logo Upload Card --}}
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-image mr-2"></i> Sponsor Logo
                                </h3>
                            </div>
                            <div class="card-body text-center">

                                {{-- Preview --}}
                                <div id="logo-preview-wrapper"
                                     class="mb-3 d-flex align-items-center justify-content-center bg-light"
                                     style="height:140px; border:2px dashed #ced4da; border-radius:8px;">
                                    <img id="logo-preview"
                                         src="#"
                                         alt="Preview"
                                         style="max-height:130px; max-width:100%; display:none; object-fit:contain;">
                                    <span id="logo-placeholder" class="text-muted">
                                        <i class="fas fa-image fa-2x d-block mb-1"></i>
                                        No logo selected
                                    </span>
                                </div>

                                {{-- File Input --}}
                                <div class="form-group mb-1">
                                    <div class="custom-file">
                                        <input type="file"
                                               name="logo" id="logo"
                                               class="custom-file-input @error('logo') is-invalid @enderror"
                                               accept="image/*">
                                        <label class="custom-file-label" for="logo">
                                            Choose logo...
                                        </label>
                                    </div>
                                    @error('logo')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                                <small class="text-muted">
                                    JPG, PNG, SVG, WEBP &mdash; max 2MB
                                </small>

                            </div>
                        </div>

                        {{-- Submit Card --}}
                        <div class="card">
                            <div class="card-body">
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fas fa-save mr-1"></i> Save Sponsor
                                </button>
                                <a href="{{ url('/sponsors') }}" class="btn btn-secondary btn-block mt-2">
                                    <i class="fas fa-times mr-1"></i> Cancel
                                </a>
                            </div>
                        </div>

                    </div>{{-- end RIGHT COLUMN --}}

                </div>{{-- end .row --}}
            </form>
        </div>
    </section>
</div>

{{-- Logo Preview Script --}}
<script>
document.getElementById('logo').addEventListener('change', function () {
    const file  = this.files[0];
    const label = this.nextElementSibling;

    if (file) {
        label.textContent = file.name;
        const reader = new FileReader();
        reader.onload = function (e) {
            const preview     = document.getElementById('logo-preview');
            const placeholder = document.getElementById('logo-placeholder');
            preview.src          = e.target.result;
            preview.style.display    = 'block';
            placeholder.style.display = 'none';
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endsection