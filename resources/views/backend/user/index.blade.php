@extends('backend.layouts.master')
@section('title', 'User Management')
@section('u_menu-open', 'menu-open')
@section('u_active', 'active')

@section('main-content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6"><h1>User Management</h1></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Users</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-circle mr-1"></i> {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            @endif

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">All Users</h3>
                    <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-user-plus mr-1"></i> Add New User
                    </a>
                </div>

                <div class="card-body">
                    {{-- Search / Filter Row --}}
                    <form method="GET" action="{{ route('users.index') }}" class="mb-3">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control form-control-sm"
                                       placeholder="Search name or email..."
                                       value="{{ request('search') }}">
                            </div>
                            <div class="col-md-3">
                                <select name="role_id" class="form-control form-control-sm">
                                    <option value="">-- All Roles --</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->role_id }}"
                                            {{ request('role_id') == $role->role_id ? 'selected' : '' }}>
                                            {{ $role->role_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="is_active" class="form-control form-control-sm">
                                    <option value="">-- All Status --</option>
                                    <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-secondary btn-sm w-100">
                                    <i class="fas fa-search mr-1"></i> Search
                                </button>
                            </div>
                        </div>
                    </form>

                    <table class="table table-bordered table-hover table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th style="width:50px">#</th>
                                <th style="width:60px">Avatar</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th style="width:100px">Status</th>
                                <th>Created At</th>
                                <th style="width:120px" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="text-center" style="width:60px; overflow:hidden;">
                                    @if($user->avatar_url)
                                        <img src="{{ $user->avatar }}"
                                        class="img-circle elevation-1"
                                        style="width:36px; height:36px; object-fit:cover; display:block; margin:auto;"
                                        alt="Avatar">
                                    @else
                                        <span class="img-circle bg-secondary d-inline-flex align-items-center justify-content-center text-white"
                                            style="width:36px; height:36px; font-size:14px; display:inline-flex !important;">
                                            {{ strtoupper(substr($user->full_name, 0, 1)) }}
                                        </span>
                                    @endif
                                </td>
                                <td>{{ $user->full_name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span class="badge badge-info">
                                        {{ $user->role->role_name ?? 'N/A' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @if($user->is_active)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>{{ $user->created_at->format('d M Y') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('users.edit', $user->user_id) }}"
                                       class="btn btn-warning btn-xs" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('users.destroy', $user->user_id) }}"
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('Delete this user?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-xs" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    <i class="fas fa-users fa-2x mb-2 d-block"></i>
                                    No users found.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($users->hasPages())
                <div class="card-footer clearfix">
                    {{ $users->appends(request()->query())->links() }}
                </div>
                @endif
            </div>

        </div>
    </section>
</div>
@endsection