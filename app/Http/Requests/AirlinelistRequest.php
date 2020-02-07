<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AirlinelistRequest extends FormRequest
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
            $name = 'required|unique:airlinelists,name,'.$id;     
            $logo = 'mimes:jpeg,jpg,png,gif|max:10000';        
        } else  {
            $name = 'required|unique:airlinelists,name';
            $logo = 'mimes:jpeg,jpg,png,gif|required|max:10000';        
        }

        return [
            'name' => $name,
            'membership_plan' => 'required',
            'airline_group' => 'required',
            'airline_gst' => 'required',
            'email' => 'required_if:airline_gst,0',
            'phone_number' => 'required_if:airline_gst,0',
            'contact_person' => 'required_if:airline_gst,0',
            'url' =>  'required_if:airline_gst,1',
            'logo' => $logo
        ];         
    }

    public function messages()
    {
        return [
            'name.required' => 'Please enter airline name',
            'membership_plan.required' => 'Please select membership plan',
            'unique.required'  => 'airline name allready exists',
            'airline_group.required' => 'Please select airline group',
            'airline_gst.required' => 'Please select airline gst',
            'email.required_if' => 'Please enter email',
            'phone_number.required_if' => 'Please enter phone number',
            'contact_person.required_if' => 'Please enter contact persone',
            'url.required_if' => 'Please enter url',
            'logo.required' => 'Please choose logo',
        ];
    }
}
