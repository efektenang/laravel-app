<?php

namespace App\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title' => ['required', 'string', 'max:100'],
            'news_content' => ['required', 'string']
        ];
    }
}
