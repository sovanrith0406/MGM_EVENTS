@extends('backend.layouts.master')
@section('title', 'Edit Speaker | Event')

@section('main-content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Speaker</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('speakers.index') }}" class="btn btn-secondary btn-sm">Back to List</a>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Modify Speaker: {{ $speaker->full_name }}</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('speakers.update', $speaker->speaker_id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Full Name</label>
                                    <input type="text" name="full_name" class="form-control" value="{{ $speaker->full_name }}" required>
                                </div>
                                <div class="form-group">
                                    <label>Professional Title</label>
                                    <input type="text" name="title" class="form-control" value="{{ $speaker->title }}">
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control" value="{{ $speaker->email }}">
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Current Image</label><br>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" name="photo" class="custom-file-input" id="image">
                                            <label class="custom-file-label" for="image">Choose new file</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="form-control" name="status">
                                        <option value="active" {{ $speaker->status == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ $speaker->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Phone</label>
                                    <input type="text" name="phone" class="form-control" value="{{ $speaker->phone }}">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Short Bio</label>
                                    <textarea name="bio" class="form-control" rows="3">{{ $speaker->bio }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-info">Update Speaker</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection