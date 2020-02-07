<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class airlineGroupRequest extends FormRequest
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
            return ['name' => 'required|unique:airline_groups,name,'.$id];         
        } else  {
            return ['name' => 'required|unique:airline_groups'];
        }

        
    }

    public function messages()
    {
        return [
            'name.required' => 'Please enter group name',
            'unique.required'  => 'Group Name allready exists',
        ];
    }
}
