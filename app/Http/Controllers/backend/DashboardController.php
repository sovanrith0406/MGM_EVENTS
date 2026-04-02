<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Speaker;
use App\Models\User;
use App\Models\Sponsor;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource (Your Dashboard Home).
     */
    public function index()
    {
        return view('backend.dashboard.index', [
            'totalEvents'    => Event::count(),
            'totalSpeakers'  => Speaker::count(),
            'totalUsers'     => User::count(),
            'totalSponsors'  => Sponsor::count(),
            'upcomingEvents' => Event::where('start_date', '>', now())
                                    ->orderBy('start_date')
                                    ->take(5)
                                    ->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}