<?php

namespace App\Http\Requests;

class StoreNews extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:6'],
            'content' => ['required', 'string']
        ];
    }

    public function getSanitizedData()
    {
        $sanitized = $this->validated();
        $sanitized['user_id'] = request()->user()->id;
        return $sanitized;
    }
}
