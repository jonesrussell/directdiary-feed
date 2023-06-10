<?php

namespace App\Http\Requests\Chat;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreConversationRequest extends FormRequest
{
    public function authorized()
    {
        return Auth::check();
    }

    public function rules()
    {
        return [
            'participants' => 'array',
            'participants.*.id' => 'required',
            'participants.*.type' => 'required|string',
            'data' => 'array',
        ];
    }

    public function participants()
    {
        $participantModels = [];
        $participants = $this->input('participants', []);

        foreach ($participants as $participant) {
            $participantModels[] = app($participant['type'])->find($participant['id']);
        }

        return $participantModels;
    }
}
