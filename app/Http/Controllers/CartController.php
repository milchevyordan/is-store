<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartRequest;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addProduct(CartRequest $request)
    {
        (new CartService())->addProduct($request->validated());

        return redirect()->route('cart');
    }
}
