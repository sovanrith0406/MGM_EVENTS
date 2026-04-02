@extends('backend.layouts.master')
@section('title', 'Speaker Profile | Event')
@section('main-content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Speaker Profile</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('speakers.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle"
                                     src="{{ $value->photo_url ? asset($value->photo_url) : asset('backend/dist/img/avatar5.png') }}"
                                     alt="Speaker profile picture">
                            </div>

                            <h3 class="profile-username text-center">{{ $value->full_name }}</h3>
                            <p class="text-muted text-center">{{ $value->title }}</p>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Company</b> <a class="float-right text-primary">{{ $value->company ?? 'N/A' }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Status</b> 
                                    <span class="float-right badge {{ $value->status == 'active' ? 'badge-success' : 'badge-danger' }}">
                                        {{ ucfirst($value->status) }}
                                    </span>
                                </li>
                            </ul>

                            <a href="{{ route('speakers.edit', $value->speaker_id) }}" class="btn btn-info btn-block">
                                <i class="fas fa-pencil-alt"></i> <b>Edit Profile</b>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">About Speaker</h3>
                        </div>
                        <div class="card-body">
                            <strong><i class="fas fa-book mr-1"></i> Biography</strong>
                            <p class="text-muted">
                                {{ $value->bio ?? 'No biography available for this speaker.' }}
                            </p>

                            <hr>

                            <strong><i class="fas fa-envelope mr-1"></i> Contact Information</strong>
                            <p class="text-muted">
                                <b>Email:</b> {{ $value->email ?? 'N/A' }} <br>
                                <b>Phone:</b> {{ $value->phone ?? 'N/A' }}
                            </p>

                            <hr>

                            <strong><i class="fas fa-calendar-alt mr-1"></i> Metadata</strong>
                            <p class="text-muted">
                                <small>Speaker ID: #{{ $value->speaker_id }}</small> <br>
                                {{-- If you used DB::table, ensure these fields exist or check for null --}}
                                <small>Member Since: {{ date('F d, Y', strtotime($value->created_at)) }}</small>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection