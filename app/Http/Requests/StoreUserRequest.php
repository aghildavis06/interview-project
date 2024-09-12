<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'contact_no' => 'required|string|max:15|regex:/^[\d\s\+\-]+$/',
            'profile_pic' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'category' => 'required|string|max:255',
            'hobbies' => 'required|array|min:1', // Changed to array validation
            'hobbies.*' => 'string|in:programming,games,reading,photography' // Validate each hobby
        ];
    }

    /**
     * Get the custom validation messages for the request.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'name.required' => 'Name is required.',
            'name.string' => 'Name must be a string.',
            'name.max' => 'Name cannot exceed 255 characters.',

            'contact_no.required' => 'Contact number is required.',
            'contact_no.string' => 'Contact number must be a string.',
            'contact_no.max' => 'Contact number cannot exceed 15 characters.',
            'contact_no.regex' => 'Contact number can only contain digits, spaces, and symbols like + and -.',

            'profile_pic.required' => 'Profile picture is required.',
            'profile_pic.image' => 'Profile picture must be an image.',
            'profile_pic.mimes' => 'Profile picture must be a file of type: jpg, jpeg, png.',
            'profile_pic.max' => 'Profile picture cannot be larger than 2MB.',

            'category.required' => 'Category is required.',
            'category.string' => 'Category must be a string.',
            'category.max' => 'Category cannot exceed 255 characters.',

            'hobbies.required' => 'At least one hobby must be selected.',
            'hobbies.array' => 'Hobbies must be an array.',
            'hobbies.min' => 'At least one hobby must be selected.',
            'hobbies.*.string' => 'Each hobby must be a string.',
            'hobbies.*.in' => 'Each hobby must be one of the following: programming, games, reading, photography.',
        ];
    }
}
