@extends('backend.layouts.master')
@section('title', 'Profile Settings')
@section('p_menu-open', 'menu-open')
@section('p_active', 'active')
@section('profile_sub_active', 'active')
@section('main-content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6"><h1>Profile Settings</h1></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Profile</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            @endif

            <div class="row">
                {{-- Avatar Card --}}
                <div class="col-md-3">
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile text-center">
                            @if($user->avatar_url)
                                <img src="{{ asset('storage/' . $user->avatar_url) }}"
                                     class="profile-user-img img-fluid img-circle"
                                     style="width:100px; height:100px; object-fit:cover;"
                                     alt="Avatar">
                            @else
                                <img src="{{ asset('theme/dist/img/avatar.png') }}"
                                     class="profile-user-img img-fluid img-circle"
                                     style="width:100px; height:100px; object-fit:cover;"
                                     alt="Avatar">
                            @endif
                            <h3 class="profile-username text-center mt-2">{{ $user->full_name }}</h3>
                            <p class="text-muted text-center">{{ $user->role->role_name ?? 'No Role' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Edit Form --}}
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Edit Account Information</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('profile.update') }}" method="POST"
                                  enctype="multipart/form-data" class="form-horizontal">
                                @csrf
                                @method('PUT')

                                {{-- Full Name --}}
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Full Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="full_name"
                                               class="form-control @error('full_name') is-invalid @enderror"
                                               value="{{ old('full_name', $user->full_name) }}">
                                        @error('full_name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                    </div>
                                </div>

                                {{-- Email --}}
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                        <input type="email" name="email"
                                               class="form-control @error('email') is-invalid @enderror"
                                               value="{{ old('email', $user->email) }}">
                                        @error('email')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                    </div>
                                </div>

                                {{-- Avatar --}}
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Profile Image</label>
                                    <div class="col-sm-10">
                                        <div class="custom-file">
                                            <input type="file" name="avatar"
                                                   class="custom-file-input @error('avatar') is-invalid @enderror"
                                                   id="avatar" accept="image/*">
                                            <label class="custom-file-label" for="avatar">Choose file</label>
                                        </div>
                                        @error('avatar')<small class="text-danger">{{ $message }}</small>@enderror
                                    </div>
                                </div>

                                <hr>
                                <h5>Security <small class="text-muted">(Leave blank to keep current password)</small></h5>

                                {{-- New Password --}}
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">New Password</label>
                                    <div class="col-sm-10">
                                        <input type="password" name="password"
                                               class="form-control @error('password') is-invalid @enderror"
                                               placeholder="New Password">
                                        @error('password')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                    </div>
                                </div>

                                {{-- Confirm Password --}}
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Confirm Password</label>
                                    <div class="col-sm-10">
                                        <input type="password" name="password_confirmation"
                                               class="form-control"
                                               placeholder="Confirm Password">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="offset-sm-2 col-sm-10">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save mr-1"></i> Update Profile
                                        </button>
                                    </div>
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