@extends('backend.layouts.master')
@section('title', 'Sponsors | Event')
@section('sp_menu-open', 'menu-open')
@section('sp_active', 'active')

@section('main-content')
<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Sponsors</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item active">Sponsors</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            {{-- Success Message --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <strong>Success!</strong> {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                </div>
            @endif

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <a href="{{ url('/sponsors/create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus mr-1"></i> Add Sponsor
                    </a>
                </div>

                <div class="card-body p-0">
                    <table class="table table-striped projects">
                        <thead>
                            <tr>
                                <th style="width: 3%">#</th>
                                <th style="width: 12%">Logo</th>
                                <th style="width: 22%">Company</th>
                                <th style="width: 20%">Contact</th>
                                <th style="width: 15%">Website</th>
                                <th style="width: 8%" class="text-center">Events</th>
                                <th style="width: 10%" class="text-center">Total ($)</th>
                                <th style="width: 10%" class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($sponsors->isEmpty())
                                <tr>
                                    <td colspan="8" class="text-center text-danger py-3">
                                        No sponsors found.
                                    </td>
                                </tr>
                            @else
                                @foreach($sponsors as $index => $sponsor)
                                    <tr>
                                        {{-- # --}}
                                        <td>{{ $index + 1 }}</td>

                                        {{-- Logo --}}
                                        <td>
                                            @if($sponsor->logo_url)
                                                <img src="{{ asset('uploads/sponsors/' . $sponsor->logo_url) }}"
                                                     alt="{{ $sponsor->name }}"
                                                     style="max-width:70px; height:40px; object-fit:contain;">
                                            @else
                                                <div class="bg-secondary d-flex align-items-center justify-content-center"
                                                     style="width:70px; height:40px; border-radius:4px;">
                                                    <i class="fas fa-building text-white"></i>
                                                </div>
                                            @endif
                                        </td>

                                        {{-- Company --}}
                                        <td>
                                            <strong>{{ $sponsor->name }}</strong>
                                        </td>

                                        {{-- Contact --}}
                                        <td>
                                            @if($sponsor->contact_name)
                                                <span class="d-block">
                                                    <i class="fas fa-user fa-xs text-muted mr-1"></i>
                                                    {{ $sponsor->contact_name }}
                                                </span>
                                            @endif
                                            @if($sponsor->contact_email)
                                                <small class="text-muted">
                                                    <i class="fas fa-envelope fa-xs mr-1"></i>
                                                    {{ $sponsor->contact_email }}
                                                </small>
                                            @endif
                                            @if($sponsor->contact_phone)
                                                <small class="d-block text-muted">
                                                    <i class="fas fa-phone fa-xs mr-1"></i>
                                                    {{ $sponsor->contact_phone }}
                                                </small>
                                            @endif
                                        </td>

                                        {{-- Website --}}
                                        <td>
                                            @if($sponsor->website)
                                                <a href="{{ $sponsor->website }}" target="_blank" rel="noopener">
                                                    <i class="fas fa-external-link-alt fa-xs mr-1"></i>
                                                    {{ parse_url($sponsor->website, PHP_URL_HOST) ?? $sponsor->website }}
                                                </a>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>

                                        {{-- Events count --}}
                                        <td class="text-center">
                                            <span class="badge badge-info badge-pill">
                                                {{ $sponsor->event_count ?? 0 }}
                                            </span>
                                        </td>

                                        {{-- Total amount --}}
                                        <td class="text-center">
                                            <strong class="text-success">
                                                ${{ number_format($sponsor->total_amount ?? 0, 2) }}
                                            </strong>
                                        </td>

                                        {{-- Actions --}}
                                        <td class="project-actions text-right">
                                            <a class="btn btn-info btn-sm"
                                               href="{{ url('/sponsors/' . $sponsor->sponsor_id . '/edit') }}"
                                               title="Edit">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            {{-- <a class="btn btn-primary btn-sm"
                                               href="{{ url('/sponsors/' . $sponsor->sponsor_id) }}"
                                               title="View">
                                                <i class="fas fa-eye"></i>
                                            </a> --}}
                                            <form action="{{ url('/sponsors/' . $sponsor->sponsor_id) }}"
                                                  method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="btn btn-danger btn-sm"
                                                        title="Delete"
                                                        onclick="return confirm('Delete {{ addslashes($sponsor->name) }}?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>

                {{-- Footer summary --}}
                @if(!$sponsors->isEmpty())
                    <div class="card-footer text-muted small">
                        Total: <strong>{{ $sponsors->count() }}</strong> sponsor(s) &nbsp;|&nbsp;
                        Total raised: <strong class="text-success">
                            ${{ number_format($sponsors->sum('total_amount'), 2) }}
                        </strong>
                    </div>
                @endif

            </div>
        </div>
    </section>
</div>
@endsection