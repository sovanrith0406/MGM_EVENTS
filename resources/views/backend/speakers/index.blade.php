@extends('backend.layouts.master')
@section('title', 'speakers | Event')
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
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Speakers</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <section class="content">
        <div class="container-fluid">
            <div class="card-header">
            <a class="btn btn-primary btn-sm" href="{{ url('/speakers/create') }}">
                <i class="fas fa-plus"></i> Add Speaker
            </a>
        </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">All Speakers</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped projects">
                        <thead>
                            <tr>
                                <th style="width: 1%">#</th>
                                <th style="width: 15%">Full Name</th>
                                <th style="width: 25%">Name & Title</th>
                                <th style="width: 25%">Bio Snippet</th>
                                <th style="width: 10%">Profile</th>
                                <th style="width: 8%" class="text-center">Status</th>
                                <th style="width: 20%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($speakers->isEmpty())
                                <tr>
                                    <td class="text-danger text-center">NO Data found</td>
                                </tr>
                            @else
                                @foreach($speakers as $key => $value)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        {{-- <td>{{ $loop->iteration }}</td> --}}
                                    {{-- <td>
                                        <img src="{{ $value->photo_url ? asset($value->photo_url) : asset('backend/dist/img/avatar5.png') }}" 
                                            class="img-circle img-size-32 mr-2" 
                                            style="width: 40px; height: 40px; object-fit: cover; border: 1px solid #ddd;">
                                    </td> --}}
                                        <td>
                                            <a>{{ $value->full_name }}</a>
                                            <br/>
    
                                        </td>
                                        <td>{{ $value->title }}</td>
                                        <td class="project_progress">
                                            {{-- Using Str::limit to keep the row height manageable --}}
                                            {{ Str::limit($value->bio, 50) }}
                                        </td>
                                        <td>
                                            <img src="{{ $value->photo_url ? asset($value->photo_url) : asset('backend/dist/img/avatar5.png') }}" 
                                                class="img-circle img-size-32 mr-2" 
                                                style="width: 40px; height: 40px; object-fit: cover; border: 1px solid #ddd;">
                                        </td>
                                        <td class="project-state">
                                            @if($value->status == 'active')
                                                <span class="badge badge-success">Active</span>
                                            @else
                                                <span class="badge badge-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td class="project-actions text-right">
                                            <a class="btn btn-primary btn-sm" href="{{ route('speakers.show', $value->speaker_id) }}">
                                                <i class="fas fa-folder"></i> View
                                            </a>
                                            <a class="btn btn-info btn-sm" href="{{ route('speakers.edit', $value->speaker_id) }}">
                                                <i class="fas fa-pencil-alt"></i> Edit
                                            </a>
                                            
                                            {{-- Delete must be a form in Laravel --}}
                                            <form action="{{ route('speakers.destroy', $value->speaker_id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this speaker?')">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    {{-- <tr>
                                        <td style="width: 1%">{{ ++$key}}</td>
                                        <td style="width: 15%">{{ $value->full_name}}</td>
                                        <td style="width: 25%">{{ $value->title}}</td>
                                        <td style="width: 30%">{{ $value->bio}}</td>
                                        <td style="width: 8%" class="text-center">{{ $value->status}}</td>
                                        <td style="width: 20%">
                                            <td class="project-actions text-right">
                                                <a class="btn btn-info btn-sm" href="#">
                                                    <i class="fas fa-pencil-alt"></i> View
                                                </a>
                                                <a class="btn btn-info btn-sm" href="#">
                                                    <i class="fas fa-pencil-alt"></i> Edit
                                                </a>
                                                <a class="btn btn-danger btn-sm" href="#">
                                                    <i class="fas fa-trash"></i> Delete
                                                </a>
                                            </td>
                                        </td>
                                    </tr> --}}
                                @endforeach

                            @endif 
                            {{-- <tr>
                                <td style="width: 1%">#</td>
                                <td style="width: 15%">Photo</td>
                                <td style="width: 25%">Name & Title</td>
                                <td style="width: 30%">Bio Snippet</td>
                                <td style="width: 8%" class="text-center">Status</td>
                                <td style="width: 20%">Actions</td>
                            </tr> --}}
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>
</div>
@endsection