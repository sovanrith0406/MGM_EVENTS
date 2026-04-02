@extends('backend.layouts.master')
@section('title', 'Add Speaker | Event')
@section('s_menu-open', 'menu-open')
@section('s_active', 'active')

@section('main-content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Speakers</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('speakers.index') }}" class="btn btn-secondary btn-sm">Back to List</a>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Add New Speaker</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('speakers.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="full_name">Full Name</label>
                                    <input type="text" name="full_name" class="form-control @error('full_name') is-invalid @enderror" value="{{ old('full_name') }}" placeholder="Enter Speaker Name">
                                    @error('full_name') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-group">
                                    <label for="title">Professional Title</label>
                                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" placeholder="e.g. Senior Software Engineer">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="email@example.com">
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="image">Speaker Image</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" name="photo" class="custom-file-input" id="image">
                                            <label class="custom-file-label" for="image">Choose image</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="form-control" name="status">
                                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="Phone Number">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="bio">Short Bio</label>
                                    <textarea name="bio" class="form-control @error('bio') is-invalid @enderror" rows="3" placeholder="Enter a brief bio...">{{ old('bio') }}</textarea>
                                    @error('bio') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Save Speaker</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection