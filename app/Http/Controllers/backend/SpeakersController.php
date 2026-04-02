<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SpeakersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $Speakers = DB::table('speakers')->get();
        return view('backend.speakers.index', ['speakers'=>$Speakers]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('backend.speakers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // 1. Validation
    $request->validate([
        'full_name' => 'required|max:150',
        'photo'     => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'status'    => 'required'
    ]);

    // 2. Handle Image Upload
    $imagePath = null;
    if ($request->hasFile('photo')) {
        $file = $request->file('photo');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        
        // Move to public/uploads/speakers
        $file->move(public_path('uploads/speakers'), $filename);
        
        // This is the relative path we save to the DB
        $imagePath = 'uploads/speakers/' . $filename;
    }

    // 3. Insert into Database and get the ID
    // We use insertGetId so we can redirect to the "View" page if we want
    $id = DB::table('speakers')->insertGetId([
        'full_name'  => $request->full_name,
        'title'      => $request->title,
        'company'    => $request->company,
        'email'      => $request->email,
        'phone'      => $request->phone,
        'bio'        => $request->bio,
        'status'     => $request->status,
        'photo_url'  => $imagePath, // Corrected: passing the uploaded path
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    // 4. Check if insert was successful and redirect
    if ($id) {
        return redirect()->route('speakers.index')
                         ->with('success', 'Speaker saved successfully!');
    } else {
        return redirect()->back()
                         ->with('fail', 'Failed to save speaker data.')
                         ->withInput();
    }
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // //
        $speaker = DB::table('speakers')->where('speaker_id', $id)->first();

        if (!$speaker) {
            return redirect()->route('speakers.index')->with('error', 'Speaker not found');
        }

        return view('backend.speakers.view', ['value' => $speaker]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $speaker = DB::table('speakers')->where('speaker_id', $id)->first();

        if (!$speaker) {
            return redirect()->route('speakers.index')->with('error', 'Speaker not found');
        }

        return view('backend.speakers.edit', ['speaker' => $speaker]); // ✅ 'speaker' not 'value'
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
        'full_name' => 'required|max:150',
        'photo'     => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $data = [
        'full_name'  => $request->full_name,
        'title'      => $request->title,
        'bio'        => $request->bio,
        'email'      => $request->email,
        'phone'      => $request->phone,
        'status'     => $request->status,
        'updated_at' => now(),
    ];

    // ✅ Handle photo update
    if ($request->hasFile('photo')) {
        $file = $request->file('photo');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/speakers'), $filename);
        $data['photo_url'] = 'uploads/speakers/' . $filename;
    }

    DB::table('speakers')->where('speaker_id', $id)->update($data);

    return redirect()->route('speakers.index')->with('success', 'Speaker updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        DB::table('speakers')->where('speaker_id', $id)->delete();
        return redirect()->route('speakers.index')->with('success', 'Speaker deleted!');
    }
}
