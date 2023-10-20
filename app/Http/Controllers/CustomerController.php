<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerStoreRequest;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class CustomerController extends Controller
{
    protected int $perPage = 10;
    protected string $notFoundTest = 'Customer not found';

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $perPage = $request->input('per_page', $this->perPage);
        $customers = Customer::paginate($perPage);
        return response($customers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CustomerStoreRequest $request
     * @return Response
     */
    public function store(CustomerStoreRequest $request): Response
    {
        try {
            $data = $request->all();
            $customer = Customer::create($data);
            return response(['id' => $customer->id ], Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            return response(['errors' => $e->errors()], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return Response
     */
    public function show(Request $request): Response
    {
        try {
            $customer = Customer::findOrFail($request->id);
            return response($customer);
        } catch (ModelNotFoundException $e) {
            return response(
                [ 'message' => $this->notFoundTest ],
                Response::HTTP_NOT_FOUND
            );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function update(Request $request): Response
    {

        try {
            $customer = Customer::findOrFail($request->id);
            $customer->update($request->all());
            return response(['id' => $customer->id ]);
        } catch (ModelNotFoundException $e) {
            return response(
                [ 'message' => $this->notFoundTest ],
                Response::HTTP_NOT_FOUND
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return Response
     */
    public function destroy(Request $request): Response
    {

        try {
            $customer = Customer::findOrFail($request->id);
            $customer->delete();
            return response()->noContent();
        } catch (ModelNotFoundException $e) {
            return response(
                [ 'message' => $this->notFoundTest ],
                Response::HTTP_NOT_FOUND
            );
        }
    }
}
