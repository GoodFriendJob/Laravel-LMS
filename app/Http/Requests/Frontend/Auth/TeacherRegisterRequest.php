<?php

namespace App\Http\Requests\Frontend\Auth;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class TeacherRegisterRequest extends FormRequest
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
            'first_name'           => ['required', 'string', 'max:191'],
            'last_name'           => ['required', 'string', 'max:191'],
            'email'               => ['required', 'string', 'email', 'max:191', Rule::unique('users')],
            'password'            => ['required', 'string', 'min:6', 'confirmed','regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/'],['password.regex' => 'The :attribute must contain at least one special character such as !, $, #, or %.'],
            'gender'              => ['required', 'in:male,female,other'],
            'facebook_link'       => ['nullable', 'url'],
            'twitter_link'        => ['nullable', 'url'],
            'linkedin_link'       => ['nullable', 'url'],
            'payment_method'        => ['required'],
            'bank_name'           => ['required_if:payment_method,bank'],
            'ifsc_code'           => ['required_if:payment_method,bank'],
            'account_number'      => ['required_if:payment_method,bank'],
            'account_name'        => ['required_if:payment_method,bank'],
            'paypal_email'        => ['required_if:payment_method,paypal'],

            // 'g-recaptcha-response' => ['required_if:captcha_status,true', new CaptchaRule()],
        ];
    }
}
