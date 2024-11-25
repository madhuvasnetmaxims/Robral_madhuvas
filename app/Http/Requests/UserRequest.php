<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class UserRequest extends FormRequest
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

    public static function userCreate($request)
    {

        $rules = [
            'name'     => 'required|string',
            'email'    => 'required|email',
            'phone'    => 'required|digits_between:9,10',
            'password' => 'required|confirmed|min:6|max:8'
        ];
    
        $messages = [
            'name.required'     => 'The name field is required.',
            'email.required'    => 'The email field is required.',
            'email.email'       => 'The email must be a valid email address.',
            'email.unique'      => 'The email has already been taken.',
            'phone.required'    => 'The phone field is required.',
            'phone.digits_between' => 'The phone number must be between 9 and 10 digits.',
            'password.required' => 'The password field is required.',
            'password.confirmed' => 'The password confirmation does not match.',
            'password.min'      => 'The password must be at least 6 characters.',
            'password.max'      => 'The password must not exceed 8 characters.',
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

    public static function userLogin($request){

        // dd($request);

        $rules = [
            'email'    => 'required|email',
            'password' => 'required'
        ];
    
        $messages = [
            'email.required'    => 'The email field is required.',
            'email.email'       => 'The email must be a valid email address.',
            'password.required' => 'The password field is required.',
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
