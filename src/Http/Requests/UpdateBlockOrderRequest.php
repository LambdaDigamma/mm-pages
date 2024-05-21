<?php

namespace LambdaDigamma\MMPages\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBlockOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //            'page_id' => 'required|integer|exists:LambdaDigamma\MMPages\Models\Page,id',
            'blocks' => 'required|array',
            'blocks.*.id' => 'required|integer|exists:LambdaDigamma\MMPages\Models\PageBlock,id',
            'blocks.*.order' => 'required|integer|min:0',
        ];
    }
}
