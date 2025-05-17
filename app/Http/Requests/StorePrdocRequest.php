<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Prdoc;
use App\Rules\PrNumberRule;
use App\Rules\PrModeRule;
use App\Rules\PrValueRule;
use App\Rules\PrEventNeedRule;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class StorePrdocRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = Auth::user();
        return $user->hasRole('admin') and $user->can('create-prdoc');
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
            'mode' => ['required', new PrModeRule()],
            'value' => ['required', new PrValueRule()],
            'desc' => ['required', 'min:10', 'max:50',],
            'purpose' => ['required', 'min:15', 'max:255',],
            'event_need' => ['required', new PrEventNeedRule(),],
            'event_loc' => ['required', 'min:5', 'max:100',],
            'user_id' => ['required',],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'number' => 'PR Number',
            'mode' => 'Mode',
            'value' => 'PR Value',
            'desc' => 'Description',
            'purpose' => 'Purpose',
            'event_need' => 'Event Date Needed',
            'event_loc' => 'Event Location',
            'user_id' => 'End-User',
        ];
    }
}