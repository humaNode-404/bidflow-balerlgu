<?php

namespace App\Http\Requests\Account;

use App\Models\User;
use App\Rules\PrOfficeRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AccInfoRequest extends FormRequest
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
            'first_name' => ['required', 'string', 'max:125'],
            'middle_name' => ['nullable', 'string', 'max:125'],
            'last_name' => ['required', 'string', 'max:125'],
            'address' => ['required', 'string', 'max:125'],
            'phone' => ['required', 'digits:11'],
            'office_id' => ['required', new PrOfficeRule()],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
        ];
    }
}
