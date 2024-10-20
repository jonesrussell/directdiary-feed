<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDomainRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:domains',
                'regex:/^(?!-)[A-Za-z0-9-]{1,63}(?<!-)(\.[A-Za-z]{2,63})+$/',
            ],
            'user_id' => [
                'required',
                'exists:users,id',
                function ($attribute, $value, $fail) {
                    if ($value != auth()->id()) {
                        $fail('You can only create domains for yourself.');
                    }
                },
            ],
        ];
    }
}

