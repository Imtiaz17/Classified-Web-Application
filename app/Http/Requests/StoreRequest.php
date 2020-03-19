<?php

namespace App\Http\Requests;

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class StoreRequest extends FormRequest
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
            'shop_name'=>'required'
            'address'=>'required'
            'phone'=>'required'
            'store_id'=>'required'
            'storelogo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024',
        ];
    }
}
