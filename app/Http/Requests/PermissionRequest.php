<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
     public function rules()
    {
        $id =  $this->input('id');
        if ($this->method() == 'PUT') {
            $name = 'required|unique:permissions,name,'.$id;     
        } else  {
            $name = 'required|unique:permissions,name';
        }

        return [
            'name' => $name
        ];         
    }

    public function messages()
    {
        return [
            'name.required' => 'Please enter airline name',
            'unique.required'  => 'Permission allready exists',
        ];
    }
}
