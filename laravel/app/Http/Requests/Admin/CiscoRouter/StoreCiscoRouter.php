<?php

namespace App\Http\Requests\Admin\CiscoRouter;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreCiscoRouter extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.cisco-router.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'sapId' => ['nullable', Rule::unique('cisco_routers', 'sapId'), 'string'],
            'hostname' => ['nullable', 'string'],
            'loopback' => ['nullable', 'string'],
            'mac_address' => ['nullable', Rule::unique('cisco_routers', 'mac_address'), 'string'],
            
        ];
    }

    /**
    * Modify input data
    *
    * @return array
    */
    public function getSanitized(): array
    {
        $sanitized = $this->validated();

        //Add your code for manipulation with request data here

        return $sanitized;
    }
}
