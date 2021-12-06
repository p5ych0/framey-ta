<?php

namespace App\Validation\Rules;

use App\Services\EmployeeService;
use Illuminate\Contracts\Validation\Rule as RuleContract;
use Illuminate\Validation\Rule;

class DifferentPosition extends Rule implements RuleContract
{
    /**
     * @var int|null Employee ID
     */
    private $id;

    public function __construct(private EmployeeService $service) {}

    /**
     * Set employee ID to test against
     *
     * @param int|null $id
     * @return $this
     */
    public function setId(?int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function passes($attribute, $value): bool
    {
        try {
            $employee = $this->service->find($this->id);
        } catch (\Throwable) {
            return true;
        }

        return $employee->{$attribute} != $value;
    }

    /**
     * {@inheritdoc}
     */
    public function message() : string
    {
        return 'The :attribute cannot be the same as of superior';
    }
}
