<?php

namespace App\Http\Requests;

class EmployeeRequest extends ApiRequest
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        /* @var $rule \App\Validation\Rules\DifferentPosition */
        $rule = resolve('differentPosition');

        return [
            'name' => 'required|string|max:40',
            'superior' => 'exclude_if:superior,null|integer|min:1|exists:employees,id',
            'start_date' => 'required|date',
            'end_date' => 'exclude_if:end_date,null|date|after:start_date',
            'position' => [
                'required',
                'string',
                'max:20',
                $rule->setId($this->superior),
            ],
        ];
    }
}
