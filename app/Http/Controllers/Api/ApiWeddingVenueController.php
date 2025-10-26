<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WeddingVenue;
use App\Models\User;
use Illuminate\Support\Facades\Auth;



class ApiWeddingVenueController extends Controller
{
      // Get all approved venues for home page
    public function index()
    {
        $venues = WeddingVenue::where('is_approved', true)->get();
        return response()->json($venues);
    }
      // Get user's own submitted venues
      public function myVenues()
      {
          $user = Auth::user();
            $venues = $user->weddingVenues()->get();
            return response()->json($venues);
      }

        // Store new venue
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'min_capacity' => 'required|integer',
            'max_capacity' => 'required|integer',
            'location' => 'required|string',
        ]);

        $venue = new WeddingVenue([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'min_capacity' => $request->min_capacity,
            'max_capacity' => $request->max_capacity,
            'location' => $request->location,
            'is_approved' => false,
        ]);

        $user = Auth::user();
        $user->weddingVenues()->save($venue);

        return response()->json(['message' => 'Venue created. Pending admin approval.']);
    }
    //delete venue
    public function destroy(WeddingVenue $venue)
    {
        if (Auth::user()->id !== $venue->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $venue->delete();
        return response()->json(['message' => 'Venue deleted successfully.']);
        }
    //update venue
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'min_capacity' => 'required|integer',
            'max_capacity' => 'required|integer',
            'location' => 'required|string',
        ]);

        $venue = WeddingVenue::find($request->id);
        if (Auth::user()->id !== $venue->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $venue->update($request->all());
        return response()->json(['message' => 'Venue updated successfully.']);
    }
  
// Store feedback for a venue
public function storeFeedback(Request $request, WeddingVenue $weddingVenue)
{
    $request->validate([
        'rating' => 'required|integer|min:1|max:5',
        'feedback' => 'nullable|string',
    ]);

    // Save the feedback and rating in the pivot table
    $user = auth()->user();  // Get the logged-in user

    // Update the pivot table with feedback and rating
    $user->weddingVenues()->updateExistingPivot($weddingVenue->id, [
        'feedback' => $request->feedback,
        'rating' => $request->rating,
    ]);

    return response()->json([
        'message' => 'Feedback submitted successfully!',
    ], 200);
}
    // Get feedback for a specific venue
// In ApiWeddingVenueController.php

public function show(WeddingVenue $weddingVenue)
{
    // Load related feedback and rating data for the venue
    $venue = $weddingVenue->load(['users' => function($query) {
        $query->withPivot('feedback', 'rating'); // Load feedback and rating from pivot table
    }]);

    return response()->json([
        'venue' => $venue,
    ], 200);
}



    }
