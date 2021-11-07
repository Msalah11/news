<?php

namespace App\Http\Requests;

class IndexNews extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'user_id' => ['nullable', 'numeric', 'exists:users,id'],
            'title' => ['nullable', 'string', 'min:3'],
        ];
    }

    public function getSanitizedData(): array
    {
        $sanitized = $this->validated();
        $sanitized['user_id'] = empty($sanitized['user_id']) ? request()->user()->id : $sanitized['user_id'];

        if(!empty($sanitized['name'])) {
            $name = $sanitized['name'];
            $sanitized[] = ['name', 'like', "%$name%"];
            unset($sanitized['name']);
        }

        return $sanitized;
    }
}
