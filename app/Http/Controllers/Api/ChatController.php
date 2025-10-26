// App\Http\Controllers\Api\ChatController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\WeddingVenue;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    // Store chat message
    public function store(Request $request)
    {
        $request->validate([
            'venue_id' => 'required|exists:wedding_venues,id',
            'message' => 'required|string',
        ]);

        $venue = WeddingVenue::findOrFail($request->venue_id);

        // Receiver is the owner who added the venue
        $receiverId = $venue->users()->first()?->id; // assuming only one owner

        if (!$receiverId) {
            return response()->json(['error' => 'Venue owner not found.'], 404);
        }

        $chat = Chat::create([
            'venue_id' => $venue->id,
            'sender_id' => Auth::id(), // or auth()->id()
            'receiver_id' => $receiverId,
            'message' => $request->message,
        ]);

        return response()->json(['message' => 'Message sent.', 'chat' => $chat]);
    }

    // Fetch messages for a venue
    public function venueChats($venueId)
    {
        $chats = Chat::where('venue_id', $venueId)
            ->with(['sender:id,name', 'receiver:id,name'])
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($chats);
    }
}
