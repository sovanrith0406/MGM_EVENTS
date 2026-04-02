<?php

namespace App\Http\Controllers\backend\mail;

use App\Http\Controllers\Controller;
use App\Models\MailboxMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Mail_BoxController extends Controller
{
    // ── Inbox ─────────────────────────────────────────────────────────────────
    public function index()
    {
        $user     = Auth::user();
        $messages = MailboxMessage::where('recipient_email', $user->email)
                        ->where('folder', 'inbox')
                        ->orderByDesc('created_at')
                        ->get();

        $unread = $messages->where('is_read', false)->count();

        return view('backend.mailbox.mailbox', compact('messages', 'unread'));
    }

    // ── Read a message ────────────────────────────────────────────────────────
    public function show($id)
    {
        $user    = Auth::user();
        $message = MailboxMessage::findOrFail($id);

        // Mark as read if recipient
        if ($message->recipient_email === $user->email && !$message->is_read) {
            $message->update(['is_read' => true]);
        }

        // Thread: replies share same subject (Re: ...)
        $thread = MailboxMessage::where(function($q) use ($message) {
                        $q->where('subject', $message->subject)
                          ->orWhere('subject', 'Re: ' . $message->subject)
                          ->orWhere('subject', ltrim(str_replace('Re:', '', $message->subject)));
                    })
                    ->where(function($q) use ($message, $user) {
                        $q->where('recipient_email', $user->email)
                          ->orWhere('sender_email', $user->email);
                    })
                    ->orderBy('created_at')
                    ->get();

        return view('backend.mailbox.read_mail', compact('message', 'thread'));
    }

    // ── Compose form ──────────────────────────────────────────────────────────
    public function compose()
    {
        $users = User::where('email', '!=', Auth::user()->email)->get();
        return view('backend.mailbox.compose', compact('users'));
    }

    // ── Send message ──────────────────────────────────────────────────────────
    public function send(Request $request)
    {
        $request->validate([
            'recipient_email' => 'required|email|exists:users,email',
            'subject'         => 'required|string|max:255',
            'body'            => 'required|string',
        ]);

        $user = Auth::user();

        MailboxMessage::create([
            'sender_name'     => $user->full_name,
            'sender_email'    => $user->email,
            'recipient_email' => $request->recipient_email,
            'subject'         => $request->subject,
            'body'            => $request->body,
            'folder'          => 'inbox',
            'is_read'         => false,
            'created_by'      => $user->id,
            'created_at'      => now(),
            'event_id'        => $request->event_id ?? null,
        ]);

        return redirect()->route('mailbox.index')
                         ->with('success', 'Message sent successfully.');
    }

    // ── Reply ─────────────────────────────────────────────────────────────────
    public function reply(Request $request, $id)
    {
        $request->validate([
            'body' => 'required|string',
        ]);

        $original = MailboxMessage::findOrFail($id);
        $user     = Auth::user();

        MailboxMessage::create([
            'sender_name'     => $user->full_name,
            'sender_email'    => $user->email,
            'recipient_email' => $original->sender_email,
            'subject'         => 'Re: ' . ltrim(str_replace('Re:', '', $original->subject)),
            'body'            => $request->body,
            'folder'          => 'inbox',
            'is_read'         => false,
            'created_by'      => $user->id,
            'created_at'      => now(),
            'event_id'        => $original->event_id,
        ]);

        return redirect()->route('mailbox.show', $id)
                         ->with('success', 'Reply sent.');
    }

    // ── Sent box ──────────────────────────────────────────────────────────────
    public function sent()
    {
        $messages = MailboxMessage::where('sender_email', Auth::user()->email)
                        ->orderByDesc('created_at')
                        ->get();

        return view('backend.mailbox.sent', compact('messages'));
    }

    // ── Delete ────────────────────────────────────────────────────────────────
    public function destroy($id)
    {
        $message = MailboxMessage::findOrFail($id);
        $message->delete();

        return redirect()->route('mailbox.index')
                         ->with('success', 'Message deleted.');
    }
}