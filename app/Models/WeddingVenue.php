<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;


class WeddingVenue extends Model
{
    /** @use HasFactory<\Database\Factories\WeddingVenueFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'description',
        'min_capacity',
        'max_capacity',
        'location',
        'is_approved',
    ];
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_wedding_venue', 'wedding_venue_id', 'user_id')
                    ->withPivot('feedback', 'rating') ;
    }
// App\Models\WeddingVenue.php

public function chats()
{
    return $this->hasMany(Chat::class, 'venue_id');
}

}
