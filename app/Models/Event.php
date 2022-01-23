<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;


class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'start_at',
        'end_at',
        'room_id'
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at'   => 'datetime',
        'room_id'  => 'integer',
    ];

    /**
     * All of the models Mutators&Accessors
     * should begin from here.
     */

    /**
     * All of the models scopes methods
     * should begin from here.
     */

    /**
     * @param Builder $query
     * @param $date
     * @return Builder
     */
    public function scopeByDate(Builder $query, $date): Builder
    {
        return $query->whereDate('start_at', Carbon::parse($date));
    }


    /**
     * @param Builder $query
     * @param $roomId
     * @return Builder
     */
    public function scopeForRoom(Builder $query, $roomId): Builder
    {
        return $query->where('room_id', $roomId);
    }

    /**
     * @param Builder $query
     * @param $userId
     * @return Builder
     */
    public function scopeForUser(Builder $query, $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    /**
     * @param Builder $query
     * @param $startAt
     * @param $endAt
     * @return Builder
     */
    public function scopeAvailableFor(Builder $query, $startAt, $endAt): Builder
    {
        return $query->where(function ($query) use ($startAt, $endAt) {
                    $query->where(function ($query) use ($startAt, $endAt) {
                            $query->where('start_at', '<=', $startAt)
                                 ->where('end_at', '>', $startAt);
                        })
                        ->orWhere(function ($query) use ($startAt, $endAt) {
                            $query->where('start_at', '<', $endAt)
                                  ->where('end_at', '>=', $endAt);
                        });
                });
    }

    /**
     * All of the models custom methods
     * should begin from here.
     */

    /**
     * All of the models method overwrites
     * should begin from here.
     */


    /**
     * All of the models relationships
     * should begin from here.
     */

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }
}
