<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Enums\EventStatus;

class EventRegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check(); // 認証済みのユーザーのみがイベントを登録できるようにする
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'event_date' => ['required', 'date'],
            'status' => ['required', Rule::enum(EventStatus::class)],
            'description' => ['nullable', 'string', 'max:1000'],
            'location' => ['nullable', 'string', 'max:255'],
            'image_path' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'], // 5MB
            'event_url' => ['nullable', 'url', 'max:255'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'イベント名は必須です。',
            'category_id.required' => 'カテゴリは必須です。',
            'category_id.exists' => '選択されたカテゴリは無効です。',
            'event_date.required' => '開催日は必須です。',
            'event_date.date' => '開催日は有効な日付形式で入力してください。',
            'status.required' => 'ステータスは必須です。',
            'status.enum' => '選択されたステータスは無効です。',
            'image_path.image' => 'アップロードされたファイルは画像である必要があります。',
            'image_path.mimes' => '画像はJPEG, PNG, JPG, GIF, WEBP形式である必要があります。',
            'image_path.max' => '画像サイズは5MBを超えることはできません。',
            'event_url.url' => '関連リンクは有効なURL形式で入力してください。',
            'event_url.max' => 'URLは255文字を超えることはできません。',
            'description.max' => 'メモ欄は1000文字を超えることはできません。',
            'location.max' => '場所名は255文字を超えることはできません。',
        ];
    }
}
