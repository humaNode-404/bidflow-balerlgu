<?php

namespace App\Http\Requests\PrCreate;

use App\Models\Prdoc;
use App\Rules\PrNumberRule;
use App\Rules\PrValueRule;
use App\Rules\PrModeRule;
use App\Rules\PrEventNeedRule;
use App\Rules\PrOfficeRule;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class Step5Request extends FormRequest
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
            'number' => ['required', new PrNumberRule(), Rule::unique(Prdoc::class)],
            'value' => ['required', new PrValueRule()],
            'desc' => ['required', 'min:10', 'max:50',],
            'purpose' => ['required', 'min:15', 'max:255',],
            'event_need' => ['required', new PrEventNeedRule(),],
            'event_loc' => ['required', 'min:5', 'max:100',],
            'office_id' => ['required', new PrOfficeRule()],
            'user_id' => ['required',],
        ];
    }
}
