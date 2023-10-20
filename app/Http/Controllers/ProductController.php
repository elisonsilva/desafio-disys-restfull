<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    protected int $perPage = 10;
    protected string $notFoundTest = 'Product not found';

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $perPage = $request->input('per_page', $this->perPage);
        $products = Product::paginate($perPage);
        return response($products);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param CustomerStoreRequest $request
     * @return Response
     */
    public function store(ProductStoreRequest $request): Response
    {
        try {
            $data = $request->all();
            $product = Product::create($data);
            return response(['id' => $product->id ], Response::HTTP_CREATED);
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
            $product = Product::findOrFail($request->id);
            return response($product);
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
            $product = Product::findOrFail($request->id);
            $product->update($request->all());
            return response(['id' => $product->id ]);
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
            $product = Product::findOrFail($request->id);
            $product->delete();
            return response()->noContent();
        } catch (ModelNotFoundException $e) {
            return response(
                [ 'message' => $this->notFoundTest ],
                Response::HTTP_NOT_FOUND
            );
        }
    }
}
