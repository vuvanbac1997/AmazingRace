<?php
namespace App\Http\Requests\API\V1;

class SignUpRequest extends Request
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
            // 'name'          => 'required|string',
            'username'          => 'required|unique:teams|min:6',
            'display_name'      => 'required',
            'password'          => 'required|min:6',
//            'grant_type'    => 'required',
//            'client_id'     => 'required',
//            'client_secret' => 'required',
//            'telephone'     => 'string',
//            'birthday'      => 'date_format:Y-m-d',
//            'locale'        => 'string'
        ];
    }

    public function messages()
    {
        return [
        ];
    }
}
