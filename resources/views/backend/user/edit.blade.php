@extends('backend.layouts.master')
@section('title', 'Edit User')
@section('u_menu-open', 'menu-open')
@section('u_active', 'active')

@section('main-content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6"><h1>Edit User</h1></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('users.index') }}">Users</a></li>
                        <li class="breadcrumb-item active">Edit User</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit User: <strong>{{ $user->full_name }}</strong></h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('users.update', $user->user_id) }}" method="POST"
                          enctype="multipart/form-data" class="form-horizontal">
                        @csrf
                        @method('PUT')

                        {{-- Full Name --}}
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Full Name <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" name="full_name"
                                       class="form-control @error('full_name') is-invalid @enderror"
                                       value="{{ old('full_name', $user->full_name) }}" placeholder="Full Name">
                                @error('full_name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Email <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="email" name="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email', $user->email) }}" placeholder="Email Address">
                                @error('email')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        {{-- Role --}}
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Role <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <select name="role_id" class="form-control @error('role_id') is-invalid @enderror">
                                    <option value="">-- Select Role --</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->role_id }}"
                                            {{ old('role_id', $user->role_id) == $role->role_id ? 'selected' : '' }}>
                                            {{ $role->role_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('role_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        {{-- New Password (optional on edit) --}}
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">New Password</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <input type="password" name="password" id="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           placeholder="Leave blank to keep current password">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-outline-secondary toggle-password"
                                                data-target="password">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    @error('password')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                </div>
                                <small class="form-text text-muted">Leave blank to keep the current password.</small>
                            </div>
                        </div>

                        {{-- Confirm Password --}}
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Confirm Password</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                           class="form-control" placeholder="Confirm new password">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-outline-secondary toggle-password"
                                                data-target="password_confirmation">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Avatar --}}
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Profile Image</label>
                            <div class="col-sm-10">
                                {{-- Current Avatar --}}
                                <div class="mb-2" id="current-avatar-wrap">
                                    @if($user->avatar_url)
                                        <img id="avatar-preview" src="{{ asset($user->avatar_url) }}"
                                             alt="Current Avatar" class="img-thumbnail"
                                             style="width:80px;height:80px;object-fit:cover;">
                                        <small class="text-muted d-block">Current photo</small>
                                    @else
                                        <span class="text-muted"><i class="fas fa-user-circle fa-3x"></i>
                                        <br><small>No photo uploaded</small></span>
                                    @endif
                                </div>
                                <div class="custom-file">
                                    <input type="file" name="avatar" class="custom-file-input"
                                           id="avatar" accept="image/*">
                                    <label class="custom-file-label" for="avatar">Choose new file</label>
                                </div>
                                @error('avatar')<small class="text-danger">{{ $message }}</small>@enderror
                                {{-- New preview --}}
                                <div class="mt-2" id="new-avatar-preview-wrap" style="display:none;">
                                    <img id="new-avatar-preview" src="#" alt="New Preview"
                                         class="img-thumbnail" style="width:80px;height:80px;object-fit:cover;">
                                    <small class="text-muted d-block">New photo (not saved yet)</small>
                                </div>
                            </div>
                        </div>

                        {{-- Active Status --}}
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Status</label>
                            <div class="col-sm-10 d-flex align-items-center">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input"
                                           id="is_active" name="is_active" value="1"
                                           {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="is_active">Active</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="offset-sm-2 col-sm-10">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save mr-1"></i> Save Changes
                                </button>
                                <a href="{{ route('users.index') }}" class="btn btn-secondary ml-2">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
    // Toggle password visibility
    document.querySelectorAll('.toggle-password').forEach(btn => {
        btn.addEventListener('click', function () {
            const input = document.getElementById(this.dataset.target);
            const icon = this.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        });
    });

    // New avatar preview
    document.getElementById('avatar').addEventListener('change', function () {
        const [file] = this.files;
        if (file) {
            document.querySelector('.custom-file-label').textContent = file.name;
            document.getElementById('new-avatar-preview').src = URL.createObjectURL(file);
            document.getElementById('new-avatar-preview-wrap').style.display = 'block';
        }
    });
</script>
@endpush