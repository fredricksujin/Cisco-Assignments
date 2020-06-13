<?php

namespace App\Http\Requests\Admin\Router;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateRouter extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.router.edit', $this->router);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'sapId' => ['sometimes', Rule::unique('routers', 'sapId')->ignore($this->router->getKey(), $this->router->getKeyName()), 'string'],
            'hostname' => ['sometimes', 'string'],
            'loopback' => ['sometimes', 'string'],
            'mac_address' => ['sometimes', Rule::unique('routers', 'mac_address')->ignore($this->router->getKey(), $this->router->getKeyName()), 'string'],
            
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
