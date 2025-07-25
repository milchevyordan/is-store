<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartRequest;
use App\Http\Requests\StoreOrderRequest;
use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Inertia\Response;
use Throwable;

class CartController extends Controller
{
    /**
     * Return the cart order page
     *
     * @return Response
     */
    public function index(): Response
    {
        $cartService = new CartService();

        return Inertia::render('Order', [
            'cartItems'  => $cartService->getCartItems(),
            'cart'       => $cartService->getCart(),
            'totalPrice' => $cartService->getCartTotalPrice(),
        ]);
    }

    /**
     * Add the product to cart
     *
     * @param CartRequest $request
     * @return RedirectResponse
     */
    public function addProduct(CartRequest $request): RedirectResponse
    {
        (new CartService())->addProduct($request->validated());

        return redirect()->route('cart.index');
    }

    /**
     * Change the quantity of the product in cart
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function changeQuantity(Request $request): RedirectResponse
    {
        (new CartService())->setCartCookie($request->all());

        return redirect()->back();
    }

    /**
     * Remove the product from cart
     *
     * @param CartRequest $request
     * @return RedirectResponse
     */
    public function removeFromCart(CartRequest $request): RedirectResponse
    {
        (new CartService())->removeProduct($request->validated());

        return redirect()->route('cart.index');
    }

    /**
     * Save the order in database
     *
     * @param StoreOrderRequest $request
     * @return RedirectResponse
     */
    public function saveOrder(StoreOrderRequest $request): RedirectResponse
    {
        DB::beginTransaction();

        try {
            (new CartService())->saveOrder($request->validated())->clearCart();

            DB::commit();

            return redirect()->route('home')->with('success', 'Поръчката е регистрирана успешно.');
        } catch (Throwable $th) {
            DB::rollBack();

            Log::error($th->getMessage(), ['exception' => $th]);

            return redirect()->back()->withErrors(['Грешка при регистриране на поръчка.']);
        }
    }
}
