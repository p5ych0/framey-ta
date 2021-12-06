<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class ApiRequest extends FormRequest
{
    /**
     * Default validation rules
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }

    /**
     * Reverse logic, set default is allowed
     *
     * {@inheritdoc}
     */
    protected function passesAuthorization()
    {
        return !method_exists($this, 'authorize') ?: $this->container->call([$this, 'authorize']);
    }

    /**
     * Removed redirect from logic
     *
     * {@inheritdoc}
     */
    protected function failedValidation(Validator $validator)
    {
        throw (new ValidationException($validator))
            ->errorBag($this->errorBag)
            ->status(Response::HTTP_PRECONDITION_FAILED);
    }
}
