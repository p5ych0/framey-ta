<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Services\EmployeeService;
use Symfony\Component\HttpFoundation\Response;

class EmployeeController extends Controller
{
    public function __construct(protected EmployeeService $service) {}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->success('List of Employees', $this->service->getByPosition(request()->query('position')));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  EmployeeRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeRequest $request)
    {
        return $this->success('Employee Created', $this->service->create($request->validated()), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id Employee ID
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        return $this->success('Employee Found', $this->service->find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  EmployeeRequest $request
     * @param  int $id Employee ID
     * @return \Illuminate\Http\Response
     */
    public function update(EmployeeRequest $request, int $id)
    {
        return $this->success('Employee Updated', $this->service->update($request->validated(), $id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id Employee ID
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        return $this->service->delete($id) ?
            $this->success('Employee Deleted', true) :
            $this->error('Employee Cannot Be Deleted', false);
    }

    /**
     * Fetch all available positions.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function positions()
    {
        return $this->success('Positions Fetched', $this->service->getPositions());
    }

    /**
     * Get children.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function children(int $id)
    {
        return $this->success('Descendants', $this->service->getDescentants($id));
    }
}
