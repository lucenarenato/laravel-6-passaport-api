<?php

namespace FederalSt\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreVehicle extends FormRequest
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
            'plate'     => 'required|string|max:8',
            'renavam'   => 'required|string|max:11',
            'brand'     => 'required||string|max:32',
            'model'     => 'required|string|max:32',
            'color'     => 'required|string|max:20',
            'year'      => 'required|string|date_format:"Y"',
            'owner'     => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'plate'   => trans('core.plate'),
            'renavam' => trans('core.renavam'),
            'brand'   => trans('core.brand'),
            'model'   => trans('core.color'),
            'color'   => trans('core.color'),
            'year'    => trans('core.year'),
            'owner'   => trans('core.owner_id'),
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['status' => false, 'messages' => $validator->messages()],200));
    }
}
