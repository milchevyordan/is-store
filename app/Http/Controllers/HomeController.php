<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Product;
use App\Repositories\HomeRepository;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Welcome', [
            'offerings' => HomeRepository::getOfferings(),
        ]);
    }

    public function products(): Response
    {
        return Inertia::render('ProductsList', [
            'products' => Product::all(),
        ]);
    }

    public function product($slug): Response
    {
        return Inertia::render('Product', [
            'product' => Product::with('category')->where('slug', $slug)->first(),
        ]);
    }
}
