@extends('backend.layouts.master')
@section('title', 'Mailbox | Event')
@section('mb_menu-open', 'menu-open')
@section('mb_active', 'active')

@section('main-content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Inbox @if($unread > 0)<span class="badge badge-danger ml-1">{{ $unread }}</span>@endif</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Inbox</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    {{ session('success') }}
                </div>
            @endif

            <div class="row">
                {{-- Sidebar --}}
                <div class="col-md-3">
                    <a href="{{ route('mailbox.compose') }}" class="btn btn-primary btn-block mb-3">
                        <i class="fas fa-pen mr-1"></i> Compose
                    </a>
                    <div class="card">
                        <div class="card-header"><h3 class="card-title">Folders</h3></div>
                        <div class="card-body p-0">
                            <ul class="nav nav-pills flex-column">
                                <li class="nav-item">
                                    <a href="{{ route('mailbox.index') }}" class="nav-link active">
                                        <i class="fas fa-inbox mr-1"></i> Inbox
                                        @if($unread > 0)
                                            <span class="badge bg-primary float-right">{{ $unread }}</span>
                                        @endif
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('mailbox.sent') }}" class="nav-link">
                                        <i class="far fa-envelope mr-1"></i> Sent
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Message List --}}
                <div class="col-md-9">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Inbox</h3>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive mailbox-messages">
                                <table class="table table-hover table-striped mb-0">
                                    <tbody>
                                        @forelse($messages as $msg)
                                        <tr class="{{ !$msg->is_read ? 'font-weight-bold' : '' }}">
                                            <td class="mailbox-star">
                                                @if(!$msg->is_read)
                                                    <i class="fas fa-circle text-primary" style="font-size:8px"></i>
                                                @endif
                                            </td>
                                            <td class="mailbox-name">
                                                <a href="{{ route('mailbox.show', $msg->message_id) }}">
                                                    {{ $msg->sender_name }}
                                                </a>
                                            </td>
                                            <td class="mailbox-subject">
                                                <a href="{{ route('mailbox.show', $msg->message_id) }}" class="text-dark">
                                                    <b>{{ $msg->subject }}</b>
                                                    <span class="text-muted font-weight-normal"> — {{ Str::limit($msg->body, 60) }}</span>
                                                </a>
                                            </td>
                                            <td class="mailbox-date text-muted" style="white-space:nowrap">
                                                {{ $msg->created_at->diffForHumans() }}
                                            </td>
                                            <td>
                                                <form action="{{ route('mailbox.destroy', $msg->message_id) }}" method="POST"
                                                      onsubmit="return confirm('Delete this message?')">
                                                    @csrf @method('DELETE')
                                                    <button class="btn btn-sm btn-outline-danger border-0">
                                                        <i class="far fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-4">
                                                <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                                Your inbox is empty.
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection