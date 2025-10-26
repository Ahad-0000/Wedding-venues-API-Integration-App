<?php

namespace App\Http\Controllers;

use App\Models\WeddingVenue;
use App\Http\Requests\StoreWeddingVenueRequest;
use App\Http\Requests\UpdateWeddingVenueRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Check;






use Inertia\Inertia;


class WeddingVenueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       
    $venues = WeddingVenue::with('users') // Eager load users (creator info)
    ->latest()
    ->get();

return Inertia::render('Dashboard/Weddingvenues/Index', [
'venues' => $venues,
]);
}

public function approve(WeddingVenue $venue)
{
    if (Auth::user()?->email !== 'admin@gmail.com') {
        abort(403, 'Unauthorized action.');
    }

    $venue->is_approved = true;
    $venue->save();

    $venues = WeddingVenue::with('users')->get();

    return Inertia::render('Dashboard/Weddingvenues/Index', [
        'venues' => $venues,
        'message' => 'Venue approved successfully.',
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
    public function store(StoreWeddingVenueRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(WeddingVenue $weddingVenue)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WeddingVenue $weddingVenue)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWeddingVenueRequest $request, WeddingVenue $weddingVenue)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WeddingVenue $weddingvenue)
    {
        // dd($weddingvenue); // ab isme proper record milega
        $weddingvenue->delete();
        return redirect()->back()->with('message', 'Venue deleted successfully.');
    }
}
