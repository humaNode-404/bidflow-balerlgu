<?php

namespace App\Http\Requests\PrCreate;

use App\Rules\PrEventNeedRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class Step3Request extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'event_need' => ['required', new PrEventNeedRule(),],
            'event_loc' => ['required', 'min:5', 'max:100',],
        ];
    }
}
