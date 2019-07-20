<?php

namespace App\Http\Requests;

use App\ProductTag;
use Gate;
use Illuminate\Foundation\Http\FormRequest;

class MassDestroyProductTagRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('product_tag_delete'), 403, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:product_tags,id',
        ];
    }
}
