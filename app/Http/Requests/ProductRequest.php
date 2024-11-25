<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
        ];
    }

    public  static function createProduct($request){
        $rules = [
            'name'        => 'required|string|max:255',
            'description' => 'required|string|min:3|max:500',
            'price'       => 'required|numeric|min:1',
            'image'       => 'required|image|mimes:png,jpg,jpeg,webp|max:2095'
        ];
    
        $messages = [
            'name.required'        => 'The product name is required.',
            'name.string'          => 'The product name must be a string.',
            'name.max'             => 'The product name cannot exceed 255 characters.',
            
            'description.string'   => 'The description must be a string.',
            'description.min'      => 'The description must be at least 3 characters.',
            'description.max'      => 'The description cannot exceed 500 characters.',
            
            'price.required'       => 'The price is required.',
            'price.numeric'        => 'The price must be a numeric value.',
            'price.min'            => 'The price must be at least 1.',
            
            'image.image'          => 'The uploaded file must be an image.',
            'image.mimes'          => 'The image must be a file of type: png, jpg, jpeg, webp.',
            'image.max'            => 'The image size cannot exceed 2MB.'
        ];


        $validator = Validator::make($request->all(), $rules, $messages);
    
        if ($validator->fails()) {
            $errorMessage = '';
            foreach ($validator->errors()->messages() as $fieldErrors) {
                if (!empty($fieldErrors)) {
                    $errorMessage = $fieldErrors[0];
                    break;
                }
            }
            return $errorMessage;
        }
    
        return true;
    }

    public  static function updateProduct($request){
        $rules = [
            'name'        => 'sometimes|string|max:255',
            'description' => 'sometimes|string|min:3|max:500',
            'price'       => 'sometimes|numeric|min:1',
            'image'       => 'sometimes|image|mimes:png,jpg,jpeg,webp|max:2095'
        ];
    
        $messages = [
            'name.string'          => 'The product name must be a string.',
            'name.max'             => 'The product name cannot exceed 255 characters.',
            
            'description.string'   => 'The description must be a string.',
            'description.min'      => 'The description must be at least 3 characters.',
            'description.max'      => 'The description cannot exceed 500 characters.',
            
            'price.numeric'        => 'The price must be a numeric value.',
            'price.min'            => 'The price must be at least 1.',
            
            'image.image'          => 'The uploaded file must be an image.',
            'image.mimes'          => 'The image must be a file of type: png, jpg, jpeg, webp.',
            'image.max'            => 'The image size cannot exceed 2MB.'
        ];


        $validator = Validator::make($request->all(), $rules, $messages);
    
        if ($validator->fails()) {
            $errorMessage = '';
            foreach ($validator->errors()->messages() as $fieldErrors) {
                if (!empty($fieldErrors)) {
                    $errorMessage = $fieldErrors[0];
                    break;
                }
            }
            return $errorMessage;
        }
    
        return true;
    }
}
