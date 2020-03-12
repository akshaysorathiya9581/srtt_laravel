<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UnderRequest extends FormRequest
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
        $id =  $this->input('id');
        if ($this->method() == 'PUT') {
            $name = 'required|unique:unders,name,'.$id;
        } else  {
            $name = 'required|unique:unders,name';
        }

        return [
            'name' => $name
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Please enter under name',
            'name.unique'  => 'Under name allready exists'
        ];
    }
}
