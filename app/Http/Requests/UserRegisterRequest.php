<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
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

    public function validated(): array
    {
        $validated = $this->validator->validated();

        $merged = collect($validated)->merge([
            'password'   => bcrypt($validated['password']),
        ]);

        return $merged->all();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'     => [
                'required',
                'string',
                'min:3',
                'max:255'
            ],
            'email'    => [
                'required',
                'email',
                'string',
                'max:255',
                'unique:users'
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed'
            ],
        ];
    }
}
