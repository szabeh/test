<?php

namespace App\Http\Requests;

use App\Content;
use Illuminate\Foundation\Http\FormRequest;

class UpdateContentRequest extends FormRequest
{
    public function authorize()
    {
        return \Gate::allows('content_edit');
    }

    public function rules()
    {
        return [
        ];
    }
}
