<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'nullable|string|min:3|max:255', 
            'contact_no' => 'nullable|digits_between:10,15', 
            'profile_pic' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', 
            'category' => 'nullable|string', 
            'hobbies' => 'nullable|array', 
            'hobbies.*' => 'string', 
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required.',
            'contact_no.required' => 'Contact number is required.',
            'contact_no.digits_between' => 'Contact number must be between 10 and 15 digits.',
            'profile_pic.image' => 'Profile picture must be an image file.',
            'profile_pic.mimes' => 'Only jpeg, png, and jpg formats are allowed.',
            'category.required' => 'Category is required.',
            'hobbies.required' => 'At least one hobby must be selected.',
        ];
    }
}
