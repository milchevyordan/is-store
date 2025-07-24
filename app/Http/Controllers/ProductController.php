<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Services\ChangeLogService;
use App\Services\MultiSelectService;
use App\Services\ProductService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;
use Throwable;

class ProductController extends Controller
{
    public ProductService $service;

    public function __construct()
    {
        $this->service = new ProductService();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('products/Index', [
            'dataTable'         => $this->service->getIndexMethodDatatable(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('products/Create', [
            'categories'  => fn () => (new MultiSelectService(Category::query()))->dataForSelect(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request): RedirectResponse
    {
        DB::beginTransaction();

        try {
            $this->service->createProduct($request);

            DB::commit();

            return redirect()->route('admin.products.edit', ['product' => $this->service->getProduct()->id])->with('success', 'Record successfully created.');
        } catch (Throwable $th) {
            DB::rollBack();

            Log::error($th->getMessage(), ['exception' => $th]);

            return redirect()->back()->withErrors(['Error creating record.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product): Response
    {
        $product->load(['changeLogsLimited', 'creator']);

        return Inertia::render('products/Edit', [
            'product'       => $product,
            'categories'    => fn () => (new MultiSelectService(Category::query()))->dataForSelect(),
            'changeLogs'    => Inertia::lazy(fn () => ChangeLogService::getChangeLogsDataTable($product)),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        DB::beginTransaction();

        try {
            $this->service->setProduct($product)->updateProduct($request);

            DB::commit();

            return redirect()->back()->with('success', 'Record successfully created.');
        } catch (Throwable $th) {
            DB::rollBack();

            Log::error($th->getMessage(), ['exception' => $th]);

            return redirect()->back()->withErrors(['Error creating record.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
