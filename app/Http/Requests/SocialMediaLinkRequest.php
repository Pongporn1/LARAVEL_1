<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SocialMediaLinkRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $userId  = $this->user()->id ?? null;
        $current = $this->route('social_link'); // binding จาก Route::resource

        return [
            'platform_name' => [
                'required','string','max:50',
                Rule::unique('social_media_links','platform_name')
                    ->where('user_id', $userId)
                    ->ignore($current?->id),
            ],
            'url' => ['required','url','max:255'],
        ];
    }

    public function messages(): array
    {
        return ['platform_name.unique' => 'แพลตฟอร์มนี้ถูกเพิ่มไว้ในบัญชีของคุณแล้ว'];
    }
}
