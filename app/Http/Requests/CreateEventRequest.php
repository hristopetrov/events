<?php

namespace App\Http\Requests;

use App\Rules\IsAnISO8601WithMilliSecondsDate;
use App\Rules\IsRoomFree;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'start_at' => [
                'required',
                new IsAnISO8601WithMilliSecondsDate(),
                'after_or_equal:now'
            ],
            'end_at' => [
                'required',
                new IsAnISO8601WithMilliSecondsDate(),
                'after:start_at'
            ],
            'room_id' => [
                'required',
                'numeric',
                Rule::exists('rooms', 'id'),
                new IsRoomFree($this)
            ]
        ];
    }
}
