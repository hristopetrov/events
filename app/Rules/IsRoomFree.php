<?php

namespace App\Rules;

use App\Http\Requests\CreateUpdateRoomRequest;
use App\Models\Event;
use Illuminate\Contracts\Validation\Rule;

class IsRoomFree implements Rule
{

    private object $request;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $events = Event::forRoom($value)
                        ->availableFor($this->request->input('start_at'), $this->request->input('end_at'))
                        ->get();

        if($events->count() === 0){
            return true;
        }

        if($events->count() === 1 && $this->request->event?->id === $events->first()->id){
            return true;
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The room is booked for this time slot';
    }
}
