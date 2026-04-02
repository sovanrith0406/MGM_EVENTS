@extends('backend.layouts.master')
@section('title', 'Compose | Event')
@section('mb_menu-open', 'menu-open')
@section('mb_active', 'active')

@section('main-content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6"><h1>Compose Message</h1></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('mailbox.index') }}">Inbox</a></li>
                        <li class="breadcrumb-item active">Compose</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                {{-- Sidebar --}}
                <div class="col-md-3">
                    <a href="{{ route('mailbox.compose') }}" class="btn btn-primary btn-block mb-3">
                        <i class="fas fa-pen mr-1"></i> Compose
                    </a>
                    <div class="card">
                        <div class="card-body p-0">
                            <ul class="nav nav-pills flex-column">
                                <li class="nav-item">
                                    <a href="{{ route('mailbox.index') }}" class="nav-link">
                                        <i class="fas fa-inbox mr-1"></i> Inbox
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('mailbox.sent') }}" class="nav-link">
                                        <i class="far fa-envelope mr-1"></i> Sent
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Compose Form --}}
                <div class="col-md-9">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-pen mr-1"></i> New Message</h3>
                        </div>
                        <div class="card-body">
                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $e)
                                            <li>{{ $e }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('mailbox.send') }}" method="POST">
                                @csrf

                                {{-- To --}}
                                <div class="form-group">
                                    <label>To <span class="text-danger">*</span></label>
                                    <select name="recipient_email"
                                            class="form-control select2 @error('recipient_email') is-invalid @enderror">
                                        <option value="">— Select recipient —</option>
                                        @foreach($users as $u)
                                            <option value="{{ $u->email }}"
                                                {{ old('recipient_email') === $u->email ? 'selected' : '' }}>
                                                {{ $u->full_name }} &lt;{{ $u->email }}&gt;
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('recipient_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Subject --}}
                                <div class="form-group">
                                    <label>Subject <span class="text-danger">*</span></label>
                                    <input type="text" name="subject"
                                           class="form-control @error('subject') is-invalid @enderror"
                                           value="{{ old('subject') }}"
                                           placeholder="Message subject">
                                    @error('subject')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Body --}}
                                <div class="form-group">
                                    <label>Message <span class="text-danger">*</span></label>
                                    <textarea name="body" rows="10"
                                              class="form-control @error('body') is-invalid @enderror"
                                              placeholder="Write your message...">{{ old('body') }}</textarea>
                                    @error('body')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-flex justify-content-between">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-paper-plane mr-1"></i> Send Message
                                    </button>
                                    <a href="{{ route('mailbox.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times mr-1"></i> Cancel
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('.select2').select2({ theme: 'bootstrap4' });
    });
</script>
@endpush