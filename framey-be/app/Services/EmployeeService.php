<?php

namespace App\Services;

use App\Models\Employee;
use Illuminate\Validation\ValidationException;
use Kalnoy\Nestedset\Collection;
use Symfony\Component\HttpFoundation\Response;

class EmployeeService
{
    /**
     * Find employee by Id.
     *
     * @param int $id Employee ID
     * @return Employee|null
     */
    public function find(int $id): ?Employee
    {
        return Employee::findOrFail($id)?->load('superior');
    }

    /**
     * Create new employee.
     *
     * @param  array $data
     * @return Employee
     */
    public function create(array $data): Employee
    {
        $sup = $data['superior'] ?? null;
        $employee = Employee::create($data, Employee::find($sup));

        if ($sup) {
            $employee->load('superior');
        }

        return $employee;
    }

    /**
     * Update employee.
     *
     * @param array $data
     * @param int   $id    Employee ID
     * @return Employee
     * @throws ValidationException
     */
    public function update(array $data, int $id)
    {
        $sup = $data['superior'] ?? null;
        $employee = Employee::findOrFail($id);
        $desc = Employee::descendantsOf($id)->toTree();
        $parent = $employee->parent()->first();

        if ($desc->isNotEmpty() && empty($parent) && empty($sup)) {
            throw ValidationException::withMessages(['superior' => ['Cannot remove superior']])
                 ->status(Response::HTTP_PRECONDITION_FAILED);
        }

        $desc->map(function($node) use ($parent) {
            $node->superior = $parent->id;
            $node->appendToNode($parent)->save();
        });

        $employee->update($data);

        if (empty($sup)) {
            $employee->saveAsRoot();
        } else {
            $employee->appendToNode(Employee::find($sup))->save();
            $employee->load('superior');
        }

        return $employee;
    }

    /**
     * Delete employee.
     *
     * @param  int $id Employee ID
     * @return bool
     */
    public function delete(int $id): bool
    {
        $employee = Employee::findOrFail($id);
        $desc = Employee::descendantsOf($id)->toTree();
        $parent = $employee->parent()->first();

        if ($desc->isNotEmpty() && empty($parent)) {
            return false;
        }

        $desc->map(function($node) use ($parent) {
            $node->superior = $parent->id;
            $node->appendToNode($parent)->save();
        });

        return $employee->delete();
    }

    /**
     * Find employees by position.
     *
     * @param  string|null $position
     * @return Collection
     */
    public function getByPosition(?string $position)
    {
        if ($position === null) {
            return Employee::with('ancestors')->paginate(15);
        }

        return Employee::with('ancestors')->where('position', $position)->paginate(15);
    }

    /**
     * Find children of employee.
     *
     * @param  int $id Employee ID
     * @return Collection
     */
    public function getDescentants(int $id)
    {
        Employee::findOrFail($id);
        return Employee::descendantsOf($id)->toTree();
    }

    /**
     * List of all available positions.
     *
     * @return Collection
     */
    public function getPositions()
    {
        return Employee::select('position')->distinct()->get()->pluck('position')->sort()->values()->all();
    }
}
