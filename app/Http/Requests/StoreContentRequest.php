<?php

namespace App\Http\Requests;

use App\Content;
use Illuminate\Foundation\Http\FormRequest;

class StoreContentRequest extends FormRequest
{
    public function authorize()
    {
        return \Gate::allows('content_create');
    }

    public function rules()
    {
        return [
            'image.*' => [
                'required',
            ],
        ];
    }
}
