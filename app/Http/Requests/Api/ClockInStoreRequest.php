<?php

namespace App\Http\Requests\Api;

use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class ClockInStoreRequest
 * @package App\Http\Requests\Api
 */
class ClockInStoreRequest extends FormRequest
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
        $rules = [
            'lat' => 'required|numeric',
            'lon' => 'required|numeric',
            'timestamp' => 'required|integer',
            'worker_id' => [Rule::exists('users', 'id')]
        ];
        return $rules;

    }
}
