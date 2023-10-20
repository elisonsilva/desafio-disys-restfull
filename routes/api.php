<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



Route::prefix('v1')->group(function () {

    // Rotas para Customer (Clientes)
    Route::get('customers', [CustomerController::class, 'index']);
    Route::post('customers', [CustomerController::class, 'store']);
    Route::get('customers/{id}', [CustomerController::class, 'show']);
    Route::put('customers/{id}', [CustomerController::class, 'update']);
    Route::delete('customers/{id}', [CustomerController::class, 'destroy']);


    // Rotas para Product (Produtos)
    Route::get('products', [ProductController::class, 'index']); // Listar produtos com paginação
    Route::post('products', [ProductController::class,'store']); // Criar novo produto
    Route::get('products/{id}', [ProductController::class,'show']); //
    Route::put('products/{id}', [ProductController::class,'update']); // Atualizar produto
    Route::delete('products/{id}', [ProductController::class,'destroy']); // Deletar produto

    // Rotas para Order (Pedidos)
    Route::get('orders', [OrderController::class,'index']); // Listar pedidos com paginação
    Route::post('orders', [OrderController::class,'store']); // Criar novo pedido
    Route::get('orders/{id}', [OrderController::class,'show']); //
    Route::put('orders/{id}', [OrderController::class,'update']); // Atualizar pedido
    Route::delete('orders/{id}', [OrderController::class,'destroy']); // Deletar pedido
});



