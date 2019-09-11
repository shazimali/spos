<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCustomerRequest extends FormRequest
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
                   'name'=>'required|min:3|max:50',
                   'email'=>'nullable|email',
                   'company_name'=>'nullable|min:3|max:200',
                   'phone1'=>'nullable|numeric|digits_between:7,16',
                   'phone2'=>'nullable|numeric|digits_between:7,16',
                   'nic'=>'nullable|numeric|digits_between:7,16',
                   'city'=>'nullable|string|max:100',
                   'address1'=>'nullable|string|max:500',
                   'address2'=>'nullable|string|max:500',
                   'remarks'=>'nullable|string|max:500',
                   'active'=>'nullable|boolean'
               ];

    }
}
