@extends('backend.layouts.master')
@section('title', 'Edit Sponsor | Event')
@section('sp_menu-open', 'menu-open')
@section('sp_active', 'active')

@section('main-content')
<div class="content-wrapper">

    {{-- Page Header --}}
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Sponsor</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('/sponsors') }}">Sponsors</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            {{-- MAIN UPDATE FORM --}}
            <form action="{{ url('/sponsors/' . $sponsor->sponsor_id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">

                    {{-- ── LEFT COLUMN ─────────────────────────────── --}}
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

                        {{-- Company Info --}}
                        <div class="card card-warning">
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
                                                   value="{{ old('name', $sponsor->name) }}"
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
                                                       value="{{ old('website', $sponsor->website) }}"
                                                       placeholder="https://example.com">
                                                @error('website')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        {{-- Contact Info --}}
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
                                                       value="{{ old('contact_name', $sponsor->contact_name) }}"
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
                                                       value="{{ old('contact_email', $sponsor->contact_email) }}"
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
                                                       value="{{ old('contact_phone', $sponsor->contact_phone) }}"
                                                       placeholder="+855 12 000 000">
                                                @error('contact_phone')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        {{-- Linked Events --}}
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-calendar-alt mr-2"></i> Linked Events
                                </h3>
                            </div>
                            <div class="card-body p-0">
                                @if($linkedEvents->isEmpty())
                                    <p class="text-muted text-center py-3 mb-0">
                                        Not linked to any event yet.
                                    </p>
                                @else
                                    <table class="table table-sm table-striped mb-0">
                                        <thead>
                                            <tr>
                                                <th>Event</th>
                                                <th class="text-center">Tier</th>
                                                <th class="text-center">Amount</th>
                                                <th class="text-right">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($linkedEvents as $link)
                                                <tr>
                                                    <td>{{ $link->event_name }}</td>
                                                    <td class="text-center">
                                                        @php
                                                            $tierBadge = [
                                                                'platinum'  => 'badge-light',
                                                                'gold'      => 'badge-warning',
                                                                'silver'    => 'badge-secondary',
                                                                'bronze'    => 'badge-danger',
                                                                'community' => 'badge-info',
                                                            ][$link->tier] ?? 'badge-secondary';
                                                        @endphp
                                                        <span class="badge {{ $tierBadge }}">
                                                            {{ ucfirst($link->tier) }}
                                                        </span>
                                                    </td>
                                                    <td class="text-center">
                                                        <strong class="text-success">
                                                            ${{ number_format($link->amount, 2) }}
                                                        </strong>
                                                    </td>
                                                    <td class="text-right">
                                                        {{-- FIX: Link to the external form via the 'form' attribute --}}
                                                        <button type="submit" 
                                                                form="unlink-form-{{ $link->event_id }}"
                                                                class="btn btn-danger btn-xs"
                                                                onclick="return confirm('Unlink this event?')">
                                                            <i class="fas fa-unlink"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>

                            {{-- Link new event --}}
                            <div class="card-footer">
                                <p class="mb-2 font-weight-bold text-sm">
                                    <i class="fas fa-plus-circle mr-1 text-primary"></i>
                                    Link to another event
                                </p>
                                <div class="row align-items-end">

                                    <div class="col-md-5">
                                        <div class="form-group mb-0">
                                            <label class="text-sm">Event</label>
                                            <select name="event_id" id="event_id" class="form-control form-control-sm">
                                                <option value="">-- No event --</option>
                                                @foreach($events as $event)
                                                    <option value="{{ $event->event_id }}"
                                                        {{ old('event_id') == $event->event_id ? 'selected' : '' }}>
                                                        {{ $event->event_name }}
                                                        ({{ \Carbon\Carbon::parse($event->start_date)->format('M Y') }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group mb-0">
                                            <label class="text-sm">Tier</label>
                                            <select name="link_tier" id="link_tier" class="form-control form-control-sm">
                                                @foreach([
                                                    'platinum'  => '🏆 Platinum',
                                                    'gold'      => '🥇 Gold',
                                                    'silver'    => '🥈 Silver',
                                                    'bronze'    => '🥉 Bronze',
                                                    'community' => '🤝 Community',
                                                ] as $val => $label)
                                                    <option value="{{ $val }}"
                                                        {{ old('link_tier', 'bronze') == $val ? 'selected' : '' }}>
                                                        {{ $label }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group mb-0">
                                            <label class="text-sm">
                                                Amount ($)
                                                <small id="link-amount-hint" class="text-muted"></small>
                                            </label>
                                            <div class="input-group input-group-sm">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">$</span>
                                                </div>
                                                <input type="number"
                                                       name="link_amount" id="link_amount"
                                                       class="form-control"
                                                       value="{{ old('link_amount', 200) }}"
                                                       min="0" step="0.01">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>{{-- end LEFT --}}

                    {{-- ── RIGHT COLUMN ────────────────────────────── --}}
                    <div class="col-md-4">

                        {{-- Logo Upload --}}
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-image mr-2"></i> Sponsor Logo
                                </h3>
                            </div>
                            <div class="card-body text-center">

                                {{-- Current / Preview --}}
                                <div id="logo-preview-wrapper"
                                     class="mb-3 d-flex align-items-center justify-content-center bg-light"
                                     style="height:140px; border:2px dashed #ced4da; border-radius:8px;">
                                    @if($sponsor->logo_url)
                                        <img id="logo-preview"
                                             src="{{ asset('uploads/sponsors/' . $sponsor->logo_url) }}"
                                             alt="Current Logo"
                                             style="max-height:130px; max-width:100%; object-fit:contain;">
                                        <span id="logo-placeholder" class="text-muted" style="display:none;">
                                            <i class="fas fa-image fa-2x d-block mb-1"></i>
                                            No logo selected
                                        </span>
                                    @else
                                        <img id="logo-preview" src="#" alt="Preview"
                                             style="max-height:130px; max-width:100%; display:none; object-fit:contain;">
                                        <span id="logo-placeholder" class="text-muted">
                                            <i class="fas fa-image fa-2x d-block mb-1"></i>
                                            No logo selected
                                        </span>
                                    @endif
                                </div>

                                {{-- Current logo name --}}
                                @if($sponsor->logo_url)
                                    <p class="text-muted small mb-2">
                                        <i class="fas fa-check-circle text-success mr-1"></i>
                                        Current: <code>{{ $sponsor->logo_url }}</code>
                                    </p>
                                @endif

                                {{-- File Input --}}
                                <div class="form-group mb-1">
                                    <div class="custom-file">
                                        <input type="file"
                                               name="logo" id="logo"
                                               class="custom-file-input @error('logo') is-invalid @enderror"
                                               accept="image/*">
                                        <label class="custom-file-label" for="logo">
                                            Replace logo...
                                        </label>
                                    </div>
                                    @error('logo')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                                <small class="text-muted">
                                    JPG, PNG, SVG, WEBP &mdash; max 2MB.<br>
                                    Leave blank to keep current logo.
                                </small>

                            </div>
                        </div>

                        {{-- Meta info --}}
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-info-circle mr-2"></i> Sponsor Info
                                </h3>
                            </div>
                            <div class="card-body p-0">
                                <table class="table table-sm mb-0">
                                    <tr>
                                        <td class="text-muted" style="width:45%">ID</td>
                                        <td><code>#{{ $sponsor->sponsor_id }}</code></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Events joined</td>
                                        <td>
                                            <span class="badge badge-info badge-pill">
                                                {{ $linkedEvents->count() }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Total raised</td>
                                        <td>
                                            <strong class="text-success">
                                                ${{ number_format($linkedEvents->sum('amount'), 2) }}
                                            </strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Created</td>
                                        <td>
                                            <small>
                                                {{ \Carbon\Carbon::parse($sponsor->created_at)->format('d M Y') }}
                                            </small>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="card">
                            <div class="card-body">
                                <button type="submit" class="btn btn-warning btn-block">
                                    <i class="fas fa-save mr-1"></i> Update Sponsor
                                </button>
                                <a href="{{ url('/sponsors') }}" class="btn btn-secondary btn-block mt-2">
                                    <i class="fas fa-times mr-1"></i> Cancel
                                </a>
                            </div>
                        </div>

                    </div>{{-- end RIGHT --}}

                </div>{{-- end .row --}}
            </form> {{-- END MAIN FORM --}}
        </div>
    </section>
</div>

{{-- FIX: Hidden Unlink Forms positioned outside the main form --}}
@foreach($linkedEvents as $link)
    <form id="unlink-form-{{ $link->event_id }}" 
          action="{{ url('/sponsors/'.$sponsor->sponsor_id.'/unlink/'.$link->event_id) }}" 
          method="POST" 
          style="display:none;">
        @csrf
        @method('DELETE')
    </form>
@endforeach

{{-- Scripts --}}
<script>
// ── Logo preview on file change ─────────────────
document.getElementById('logo').addEventListener('change', function () {
    const file  = this.files[0];
    const label = this.nextElementSibling;
    if (file) {
        label.textContent = file.name;
        const reader = new FileReader();
        reader.onload = function (e) {
            const preview     = document.getElementById('logo-preview');
            const placeholder = document.getElementById('logo-placeholder');
            preview.src              = e.target.result;
            preview.style.display    = 'block';
            placeholder.style.display = 'none';
        };
        reader.readAsDataURL(file);
    }
});

// ── Tier → auto amount (link new event section) ─
const tierAmounts = {
    platinum  : 1000,
    gold      : 500,
    silver    : 300,
    bronze    : 200,
    community : 150,
};

document.getElementById('link_tier').addEventListener('change', function () {
    const val    = this.value;
    const amount = document.getElementById('link_amount');
    const hint   = document.getElementById('link-amount-hint');
    if (tierAmounts[val]) {
        amount.value     = tierAmounts[val];
        hint.textContent = '— default $' + tierAmounts[val].toLocaleString();
    } else {
        amount.value     = 0;
        hint.textContent = '';
    }
});

// Init hint on load
document.addEventListener('DOMContentLoaded', function () {
    const tier = document.getElementById('link_tier').value;
    const hint = document.getElementById('link-amount-hint');
    if (tier && tierAmounts[tier]) {
        hint.textContent = '— default $' + tierAmounts[tier].toLocaleString();
    }
});
</script>
@endsection