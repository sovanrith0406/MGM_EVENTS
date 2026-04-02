@extends('backend.layouts.master')
@section('title', 'schedule | Event')
@section('sc_menu-open', 'menu-open')
@section('sc_active', 'active')
@section('main-content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Event Schedule</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Schedule</li>
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
            <a class="btn btn-primary btn-sm" href="{{ url('/schedule/create') }}">
                <i class="fas fa-plus"></i> Add Schedule
            </a>
        </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daily Timeline</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped projects">
                        <thead>
                            <tr>
                                <th style="width: 10%">Time</th>
                                <th style="width: 25%">Title Details</th>
                                <th style="width: 20%">Speaker Name</th>
                                <th style="width: 15%">Venue Name</th>
                                <th style="width: 10%" class="text-center">Status</th>
                                <th style="width: 20%" class="text-right">Actions</th>
                            </tr>   
                        </thead>
                        <tbody>
                            @if($Schedule->isEmpty())
                                <tr>
                                    <td class="text-danger text-center" colspan="6">No data found</td>
                                </tr>
                            @else
                                @foreach($Schedule as $item)
                                    <tr>
                                        <td>
                                            <span class="text-primary font-weight-bold">
                                                {{ \Carbon\Carbon::parse($item->start_time)->format('h:i A') }}
                                            </span><br>
                                            <small class="text-muted">
                                                To {{ \Carbon\Carbon::parse($item->end_time)->format('h:i A') }}
                                            </small>
                                        </td>
                                        <td>
                                            <strong>{{ $item->title }}</strong><br>
                                            <small class="text-muted">
                                                Track: {{ $item->track_name ?? 'N/A' }}
                                            </small>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                {{-- <img alt="Avatar" class="img-circle mr-2"
                                                    src="{{ asset('backend/dist/img/avatar.png') }}"
                                                    style="width:30px; height:30px;"> --}}
                                                <span>{{ $item->speaker_name ?? 'TBA' }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <i class="fas fa-map-marker-alt text-danger mr-1"></i>
                                            {{ $item->room_name ?? 'N/A' }}
                                            <br>
                                            <small class="text-muted">{{ $item->venue_name ?? '' }}</small>
                                        </td>
                                        <td class="text-center">
                                            @if($item->status == 'confirmed')
                                                <span class="badge badge-success">Confirmed</span>
                                            @elseif($item->status == 'cancelled')
                                                <span class="badge badge-danger">Cancelled</span>
                                            @else
                                                <span class="badge badge-warning">Pending</span>
                                            @endif
                                        </td>
                                        <td class="project-actions text-right">
                                            <a class="btn btn-info btn-sm" 
                                            href="{{ url('/schedule/'.$item->schedule_id.'/edit') }}">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <form action="{{ url('/schedule/'.$item->schedule_id) }}" 
                                                method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Delete this schedule?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            {{-- <tr>
                                <td>
                                    <span class="text-primary font-weight-bold">09:00 AM</span><br>
                                    <small class="text-muted">To 10:30 AM</small>
                                </td>
                                <td>
                                    <a><strong>Introduction to Laravel 11</strong></a>
                                    <br/>
                                    <small>Track: Web Development</small>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img alt="Avatar" class="img-circle mr-2" src="{{ asset('backend/dist/img/avatar.png') }}" style="width: 30px; height: 30px;">
                                        <span>John Doe</span>
                                    </div>
                                </td>
                                <td>
                                    <i class="fas fa-map-marker-alt text-danger mr-1"></i> Main Hall B
                                </td>
                                <td class="project-state">
                                    <span class="badge badge-success">Confirmed</span>
                                </td>
                                <td class="project-actions text-right">
                                    <a class="btn btn-info btn-sm" href="#">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <a class="btn btn-danger btn-sm" href="#">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr> --}}
                            <tr class="bg-light">
                                <td class="text-center"><i class="fas fa-coffee"></i></td>
                                <td colspan="3"><strong>Lunch Break & Networking</strong></td>
                                <td class="text-center"><span class="badge badge-secondary">Break</span></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>
</div>
@endsection