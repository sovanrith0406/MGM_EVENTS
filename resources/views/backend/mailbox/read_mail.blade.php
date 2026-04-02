@extends('backend.layouts.master')
@section('title', 'Read Mail | Event')
@section('mb_menu-open', 'menu-open')
@section('mb_active', 'active')

@section('main-content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6"><h1>Read Message</h1></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('mailbox.index') }}">Inbox</a></li>
                        <li class="breadcrumb-item active">Read</li>
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
                                    <a href="{{ route('mailbox.index') }}" class="nav-link">
                                        <i class="fas fa-inbox mr-1"></i> Inbox
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

                {{-- Message Thread + Reply --}}
                <div class="col-md-9">

                    {{-- Thread messages --}}
                    @foreach($thread as $msg)
                    <div class="card card-outline {{ $msg->message_id === $message->message_id ? 'card-primary' : 'card-secondary' }} mb-3">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-envelope mr-1 text-muted"></i>
                                <strong>{{ $msg->subject }}</strong>
                            </h3>
                            <div class="card-tools">
                                <span class="text-muted text-sm">
                                    {{ $msg->created_at->format('d M Y, h:i A') }}
                                </span>
                            </div>
                        </div>
                        <div class="card-body">
                            {{-- Sender info --}}
                            <div class="d-flex align-items-center mb-3">
                                <div class="d-flex align-items-center justify-content-center mr-3 text-white font-weight-bold"
                                     style="width:40px;height:40px;border-radius:50%;background:#007bff;font-size:16px;flex-shrink:0;">
                                    {{ strtoupper(substr($msg->sender_name ?? 'U', 0, 1)) }}
                                </div>
                                <div>
                                    <div><strong>{{ $msg->sender_name }}</strong>
                                        <span class="text-muted ml-1" style="font-size:12px">
                                            &lt;{{ $msg->sender_email }}&gt;
                                        </span>
                                    </div>
                                    <div class="text-muted" style="font-size:12px">
                                        To: {{ $msg->recipient_email }}
                                    </div>
                                </div>
                                {{-- Delete button --}}
                                <div class="ml-auto">
                                    <form action="{{ route('mailbox.destroy', $msg->message_id) }}" method="POST"
                                          onsubmit="return confirm('Delete this message?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">
                                            <i class="far fa-trash-alt"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                            {{-- Message body --}}
                            <div class="p-3 rounded" style="background:var(--light);white-space:pre-wrap;line-height:1.8;">
                                {{ $msg->body }}
                            </div>
                        </div>
                    </div>
                    @endforeach

                    {{-- Reply Box --}}
                    <div class="card card-outline card-success">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-reply mr-1"></i> Reply to
                                <strong>{{ $message->sender_name }}</strong>
                            </h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('mailbox.reply', $message->message_id) }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <textarea name="body" rows="6"
                                        class="form-control @error('body') is-invalid @enderror"
                                        placeholder="Write your reply here...">{{ old('body') }}</textarea>
                                    @error('body')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="d-flex justify-content-between">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-paper-plane mr-1"></i> Send Reply
                                    </button>
                                    <a href="{{ route('mailbox.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-arrow-left mr-1"></i> Back to Inbox
                                    </a>
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