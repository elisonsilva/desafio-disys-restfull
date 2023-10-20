<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderStoreRequest;
use App\Models\Customer;
use App\Models\Order;
use App\Notifications\OrderCreatedNotification;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    protected int $perPage = 10;
    protected string $notFoundTest = 'Order not found';

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $perPage = $request->input('per_page', $this->perPage);
        $orders = Order::paginate($perPage);
        return response($orders);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CustomerStoreRequest $request
     * @return Response
     */
    public function store(OrderStoreRequest $request): Response
    {
        try {
            $data = $request->all();
            $order = Order::create($data);

            $customer = Customer::find($order->customer_id);
            Notification::send($customer, new OrderCreatedNotification($order));

            return response(['id' => $order->id ], Response::HTTP_CREATED);
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
            $order = Order::findOrFail($request->id);
            return response($order);
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
            $order = Order::findOrFail($request->id);
            $order->delete();
            return response()->noContent();
        } catch (ModelNotFoundException $e) {
            return response(
                [ 'message' => $this->notFoundTest ],
                Response::HTTP_NOT_FOUND
            );
        }
    }
}
