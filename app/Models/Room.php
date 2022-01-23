<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
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
     * @return HasMany
     */
    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }
}
