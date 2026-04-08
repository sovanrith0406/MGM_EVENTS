<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Sponsor;
use App\Models\Event;
use Illuminate\Http\Request;

class SponsorReportController extends Controller
{
    public function index(Request $request)
    {
        $events = Event::orderBy('event_name')->get();

        $query = Sponsor::query()
            ->withCount('events')
            ->addSelect(\DB::raw(
                '(SELECT SUM(amount) FROM event_sponsors
                  WHERE event_sponsors.sponsor_id = sponsors.sponsor_id
                 ) as total_amount'
            ));

        // Filter: by event
        if ($request->filled('event_id')) {
            $query->whereHas('events', fn($q) =>
                $q->where('events.event_id', $request->event_id)
            );
        }

        // Filter: by sponsor name keyword
        if ($request->filled('keyword')) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }

        $sponsors = $query->orderBy('name')->paginate(20)->withQueryString();

        // Summary stats (across full filtered set, not just this page)
        $allFiltered = $query->get();   // re-run without paginate for totals

        $totalSponsors   = $sponsors->total();
        $totalRaised     = $allFiltered->sum('total_amount');
        $totalEventLinks = $allFiltered->sum('events_count');

        return view('backend.reports.sponsor_report', compact(
            'sponsors',
            'events',
            'totalSponsors',
            'totalRaised',
            'totalEventLinks'
        ));
    }
}