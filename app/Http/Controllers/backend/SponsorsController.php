<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SponsorsController extends Controller
{
    // ══════════════════════════════════════════════
    // INDEX — list all sponsors with event count
    // ══════════════════════════════════════════════
    public function index()
    {
        $sponsors = DB::table('sponsors as s')
            ->leftJoin('event_sponsors as es', 's.sponsor_id', '=', 'es.sponsor_id')
            ->select(
                's.sponsor_id',
                's.name',
                's.website',
                's.logo_url',
                's.contact_name',
                's.contact_email',
                's.contact_phone',
                's.created_at',
                DB::raw('COUNT(es.event_id) as event_count'),
                DB::raw('SUM(es.amount) as total_amount')
            )
            ->groupBy(
                's.sponsor_id', 's.name', 's.website', 's.logo_url',
                's.contact_name', 's.contact_email', 's.contact_phone', 's.created_at'
            )
            ->orderBy('s.created_at', 'desc')
            ->get();

        return view('backend.sponsors.index', compact('sponsors'));
    }

    // ══════════════════════════════════════════════
    // CREATE — show create form
    // ══════════════════════════════════════════════
    public function create()
    {
        $events = DB::table('events')
            ->select('event_id', 'event_name', 'start_date')
            ->orderBy('start_date', 'desc')
            ->get();

        return view('backend.sponsors.create', compact('events'));
    }

    // ══════════════════════════════════════════════
    // STORE — save new sponsor
    // ══════════════════════════════════════════════
    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:180',
            'website'       => 'nullable|url|max:255',
            'logo'          => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'contact_name'  => 'nullable|string|max:150',
            'contact_email' => 'nullable|email|max:190',
            'contact_phone' => 'nullable|string|max:50',
            // event pivot fields
            'event_id'      => 'nullable|exists:events,event_id',
            'tier'          => 'nullable|in:platinum,gold,silver,bronze,community',
            'amount'        => 'nullable|numeric|min:0',
        ]);

        // Handle logo upload
        $logoPath = null;
        if ($request->hasFile('logo')) {
            $file     = $request->file('logo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/sponsors'), $filename);
            $logoPath = $filename;
        }

        // Insert sponsor
        $sponsorId = DB::table('sponsors')->insertGetId([
            'name'          => $request->name,
            'website'       => $request->website,
            'logo_url'      => $logoPath,
            'contact_name'  => $request->contact_name,
            'contact_email' => $request->contact_email,
            'contact_phone' => $request->contact_phone,
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);

        // Link to event if provided
        if ($request->filled('event_id')) {
            DB::table('event_sponsors')->insert([
                'event_id'   => $request->event_id,
                'sponsor_id' => $sponsorId,
                'tier'       => $request->tier   ?? 'bronze',
                'amount'     => $request->amount ?? 0,
            ]);
        }

        return redirect('/sponsors')->with('success', 'Sponsor created successfully!');
    }

    // ══════════════════════════════════════════════
    // SHOW — sponsor detail + all linked events
    // ══════════════════════════════════════════════
    public function show(string $id)
    {
        $sponsor = DB::table('sponsors')->where('sponsor_id', $id)->first();
        if (!$sponsor) abort(404);

        $events = DB::table('event_sponsors as es')
            ->join('events as e', 'es.event_id', '=', 'e.event_id')
            ->select('e.event_id', 'e.event_name', 'e.start_date', 'es.tier', 'es.amount')
            ->where('es.sponsor_id', $id)
            ->orderByRaw("FIELD(es.tier, 'platinum','gold','silver','bronze','community')")
            ->get();

        return view('backend.sponsors.show', compact('sponsor', 'events'));
    }

    // ══════════════════════════════════════════════
    // EDIT — show edit form with current data
    // ══════════════════════════════════════════════
    public function edit(string $id)
    {
        // Find sponsor or 404
        $sponsor = DB::table('sponsors')->where('sponsor_id', $id)->first();
        if (!$sponsor) abort(404);

        // All events for the "link new event" dropdown
        $events = DB::table('events')
            ->select('event_id', 'event_name', 'start_date')
            ->orderBy('start_date', 'desc')
            ->get();

        // Events already linked to this sponsor (with event name for display)
        $linkedEvents = DB::table('event_sponsors as es')
            ->join('events as e', 'es.event_id', '=', 'e.event_id')
            ->select('es.event_id', 'es.tier', 'es.amount', 'e.event_name')
            ->where('es.sponsor_id', $id)
            ->orderByRaw("FIELD(es.tier, 'platinum','gold','silver','bronze','community')")
            ->get();

        return view('backend.sponsors.edit', compact('sponsor', 'events', 'linkedEvents'));
    }

    // ══════════════════════════════════════════════
    // UPDATE — update sponsor data
    // ══════════════════════════════════════════════
    public function update(Request $request, string $id)
    {
        $sponsor = DB::table('sponsors')->where('sponsor_id', $id)->first();
        if (!$sponsor) abort(404);

        $request->validate([
            'name'          => 'required|string|max:180',
            'website'       => 'nullable|url|max:255',
            'logo'          => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'contact_name'  => 'nullable|string|max:150',
            'contact_email' => 'nullable|email|max:190',
            'contact_phone' => 'nullable|string|max:50',
            // Validation for linking a new event from the edit page
            'event_id'      => 'nullable|exists:events,event_id',
            'link_tier'     => 'nullable|in:platinum,gold,silver,bronze,community',
            'link_amount'   => 'nullable|numeric|min:0',
        ]);

        // Handle logo upload — delete old if replaced
        $logoPath = $sponsor->logo_url;
        if ($request->hasFile('logo')) {
            // Delete old logo file
            if ($logoPath && file_exists(public_path('uploads/sponsors/' . $logoPath))) {
                unlink(public_path('uploads/sponsors/' . $logoPath));
            }
            $file     = $request->file('logo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/sponsors'), $filename);
            $logoPath = $filename;
        }

        DB::table('sponsors')->where('sponsor_id', $id)->update([
            'name'          => $request->name,
            'website'       => $request->website,
            'logo_url'      => $logoPath,
            'contact_name'  => $request->contact_name,
            'contact_email' => $request->contact_email,
            'contact_phone' => $request->contact_phone,
            'updated_at'    => now(),
        ]);

        // Link to new event if provided during the update
        if ($request->filled('event_id')) {
            DB::table('event_sponsors')->updateOrInsert(
                [
                    'event_id'   => $request->event_id,
                    'sponsor_id' => $id
                ],
                [
                    'tier'       => $request->link_tier ?? 'bronze',
                    'amount'     => $request->link_amount ?? 0
                ]
            );
        }

        return redirect('/sponsors')->with('success', 'Sponsor updated successfully!');
    }

    // ══════════════════════════════════════════════
    // DESTROY — delete sponsor + pivot rows
    // ══════════════════════════════════════════════
    public function destroy(string $id)
    {
        $sponsor = DB::table('sponsors')->where('sponsor_id', $id)->first();
        if (!$sponsor) abort(404);

        // Delete logo file
        if ($sponsor->logo_url && file_exists(public_path('uploads/sponsors/' . $sponsor->logo_url))) {
            unlink(public_path('uploads/sponsors/' . $sponsor->logo_url));
        }

        // Pivot rows deleted automatically via ON DELETE CASCADE
        DB::table('sponsors')->where('sponsor_id', $id)->delete();

        return redirect('/sponsors')->with('success', 'Sponsor deleted successfully!');
    }

    // ══════════════════════════════════════════════
    // LINK EVENT — attach sponsor to an event (AJAX or form)
    // ══════════════════════════════════════════════
    public function linkEvent(Request $request, string $id)
    {
        $request->validate([
            'event_id' => 'required|exists:events,event_id',
            'tier'     => 'required|in:platinum,gold,silver,bronze,community',
            'amount'   => 'nullable|numeric|min:0',
        ]);

        // Upsert — update if already linked, insert if not
        $exists = DB::table('event_sponsors')
            ->where('event_id',   $request->event_id)
            ->where('sponsor_id', $id)
            ->exists();

        if ($exists) {
            DB::table('event_sponsors')
                ->where('event_id',   $request->event_id)
                ->where('sponsor_id', $id)
                ->update([
                    'tier'   => $request->tier,
                    'amount' => $request->amount ?? 0,
                ]);
        } else {
            DB::table('event_sponsors')->insert([
                'event_id'   => $request->event_id,
                'sponsor_id' => $id,
                'tier'       => $request->tier,
                'amount'     => $request->amount ?? 0,
            ]);
        }

        return redirect()->back()->with('success', 'Sponsor linked to event successfully!');
    }

    // ══════════════════════════════════════════════
    // UNLINK EVENT — detach sponsor from an event
    // ══════════════════════════════════════════════
    public function unlinkEvent(string $sponsorId, string $eventId)
    {
        DB::table('event_sponsors')
            ->where('sponsor_id', $sponsorId)
            ->where('event_id',   $eventId)
            ->delete();

        return redirect()->back()->with('success', 'Sponsor unlinked from event.');
    }
}