@extends('backend.layouts.master')
@section('title', 'Add New User')
@section('u_menu-open', 'menu-open')
@section('u_active', 'active')

@section('main-content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6"><h1>Add New User</h1></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('users.index') }}">Users</a></li>
                        <li class="breadcrumb-item active">Add User</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">User Information</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('users.store') }}" method="POST"
                          enctype="multipart/form-data" class="form-horizontal">
                        @csrf

                        {{-- Full Name --}}
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Full Name <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" name="full_name"
                                       class="form-control @error('full_name') is-invalid @enderror"
                                       value="{{ old('full_name') }}" placeholder="Full Name">
                                @error('full_name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Email <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="email" name="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email') }}" placeholder="Email Address">
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
                                            {{ old('role_id') == $role->role_id ? 'selected' : '' }}>
                                            {{ $role->role_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('role_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        {{-- Password --}}
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Password <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <input type="password" name="password" id="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           placeholder="Password (min. 6 characters)">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-outline-secondary toggle-password"
                                                data-target="password">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    @error('password')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                </div>
                            </div>
                        </div>

                        {{-- Confirm Password --}}
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Confirm Password <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                           class="form-control" placeholder="Confirm Password">
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
                                <div class="custom-file">
                                    <input type="file" name="avatar" class="custom-file-input"
                                           id="avatar" accept="image/*">
                                    <label class="custom-file-label" for="avatar">Choose file</label>
                                </div>
                                @error('avatar')<small class="text-danger">{{ $message }}</small>@enderror
                                {{-- Preview --}}
                                <div class="mt-2" id="avatar-preview-wrap" style="display:none;">
                                    <img id="avatar-preview" src="#" alt="Preview"
                                         class="img-thumbnail" style="width:80px;height:80px;object-fit:cover;">
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
                                           {{ old('is_active', '1') == '1' ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="is_active">Active</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="offset-sm-2 col-sm-10">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-user-plus mr-1"></i> Create User
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

    // Avatar preview
    document.getElementById('avatar').addEventListener('change', function () {
        const [file] = this.files;
        if (file) {
            document.querySelector('.custom-file-label').textContent = file.name;
            document.getElementById('avatar-preview').src = URL.createObjectURL(file);
            document.getElementById('avatar-preview-wrap').style.display = 'block';
        }
    });
</script>
@endpush