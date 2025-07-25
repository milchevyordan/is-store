<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Services\CartService;
use Illuminate\Foundation\Inspiring;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Tighten\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     *
     * @param Request $request
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @param  Request              $request
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        [$message, $author] = str(Inspiring::quotes()->random())->explode('-');

        return [
            ...parent::share($request),
            'name'  => config('app.name'),
            'quote' => ['message' => trim($message), 'author' => trim($author)],
            'auth'  => [
                'user' => $request->user(),
            ],
            'cartItemsCount' => (new CartService())->getCartItemsCount(),
            'ziggy'          => [
                ...(new Ziggy())->toArray(),
                'location' => $request->url(),
            ],
            'sidebarOpen' => ! $request->hasCookie('sidebar_state') || $request->cookie('sidebar_state') === 'true',
            'flash'       => [
                // Flash session variables -> !!! Vue plugin doesn't update the values, so we can check them in the components via {{ }} !!!
                'status'  => fn () => session('status'),
                'success' => fn () => session('success'),
                'errors'  => function () {
                    $errorBag = session('errors');

                    if ($errorBag) {
                        return $errorBag->toArray();
                    }

                    return [];
                },
                'error' => fn () => session('error'),
            ],
        ];
    }
}
