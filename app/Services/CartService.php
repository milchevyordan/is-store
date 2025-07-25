<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cookie;

class CartService
{
    protected $cookieName = 'cart';

    protected $cookieLifetime = 10080; // 7 days

    /**
     * Context cart.
     */
    private array $cart;

    /**
     * Context cart.
     */
    private Collection $cartItems;

    /**
     * Get the value of cart.
     */
    public function getCart(): array
    {
        if (! $this->cart) {
            $this->setCart();
        }

        return $this->cart;
    }

    /**
     * Get the value of the cart.
     */
    public function getCartItemsCount(): int
    {
        return array_sum(array_column($this->getCart(), 'quantity'));
    }

    /**
     * Get the value of the cart
     */
    public function getCartItems(): Collection
    {
        $this->setCartItems();

        return $this->cartItems;
    }

    /**
     * Set the value of cart.
     *
     * @return self
     */
    public function setCartItems(): self
    {
        $this->cartItems = Product::whereIn('id', array_keys($this->getCart()))->select('id', 'slug', 'title', 'client_price', 'partner_price', 'image')->get();

        return $this;
    }

    /**
     * Calculate and return client and partner total price.
     */
    public function getCartTotalPrice(): array
    {
        $cart = $this->getCart();

        $partnerPriceTotal = 0;
        $clientPriceTotal = 0;
        foreach ($this->getCartItems() as $cartItem) {
            $partnerPriceTotal += $cartItem->partner_price * $cart[$cartItem->id]['quantity'];
            $clientPriceTotal += $cartItem->client_price * $cart[$cartItem->id]['quantity'];
        }

        return [
            'partner_price_total' => $partnerPriceTotal,
            'client_price_total'  => $clientPriceTotal,
        ];
    }

    /**
     * Set the value of cart.
     *
     * @return self
     */
    public function setCart(): self
    {
        $this->cart = json_decode(Cookie::get($this->cookieName, '[]'), true);

        return $this;
    }

    /**
     * Create a new CartService instance.
     */
    public function __construct()
    {
        $this->setCart();
        $this->cartItems = new Collection();
    }

    public function addProduct(array $validatedRequest): static
    {
        $productId = $validatedRequest['product_id'];

        $cart = $this->getCart();

        $cart[$productId] = [
            'quantity' => ($cart[$productId]['quantity'] ?? 0) + 1,
        ];

        $this->setCartCookie($cart);

        return $this;
    }

    /**
     * Remove a product from the cart.
     *
     * @param array $validatedRequest
     */
    public function removeProduct(array $validatedRequest): void
    {
        $productId = $validatedRequest['product_id'];
        $cart = $this->getCart();

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
        }

        $this->setCartCookie($cart);
    }

    /**
     * Clear the cart.
     */
    public function clearCart(): void
    {
        Cookie::queue(Cookie::forget($this->cookieName));
    }

    /**
     * Helper method to set the cookie.
     *
     * @param array $cart
     */
    public function setCartCookie(array $cart): void
    {
        Cookie::queue($this->cookieName, json_encode($cart), $this->cookieLifetime);
    }
}
