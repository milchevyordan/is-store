<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Services\DataTable\DataTable;

class ProductService
{
    /**
     * Context model.
     *
     * @var Product
     */
    private Product $model;

    /**
     * Get the value of model.
     *
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->model;
    }

    /**
     * Set the value of model.
     *
     * @param  Product $model
     * @return self
     */
    public function setProduct(Product $model): self
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Create a new ProductService instance.
     */
    public function __construct()
    {
        $this->setProduct(new Product());
    }

    /**
     * Create a new ProductService instance.
     *
     * @return DataTable
     */
    public function getIndexMethodDatatable(): DataTable
    {
        return (new DataTable(
            Product::query()
        ))
            ->setRelation('category', ['id', 'title'])
            ->setColumn('action', 'Action')
            ->setColumn('id', '#', true, true)
            ->setColumn('category.title', 'Category', true, true)
            ->setColumn('title', 'Title', true, true)
            ->setColumn('price', 'Price', true, true)
            ->setColumn('created_at', 'Created', true, true)
            ->setDateColumn('created_at', 'dd.mm.YYYY H:i')
            ->run();
    }

    /**
     * Create the quiz question.
     *
     * @param  StoreProductRequest $request
     * @return self
     */
    public function createProduct(StoreProductRequest $request): self
    {
        $validatedRequest = $request->validated();

        $product = new Product();
        $product->fill($validatedRequest);
        $product->creator_id = auth()->id();

        (new ImageService($request, $product))->storeImage();

        $this->setProduct($product);

        (new CacheService())->clearProductCache();

        return $this;
    }

    /**
     * Update the quiz question.
     *
     * @param  UpdateProductRequest $request
     * @return self
     */
    public function updateProduct(UpdateProductRequest $request): self
    {
        $validatedRequest = $request->validated();

        $product = $this->getProduct();
        $changeLoggerService = new ChangeLoggerService($product);

        $product->update($validatedRequest);
        (new ImageService($request, $product))->storeImage();

        $changeLoggerService->logChanges($product);
        $this->setProduct($product);

        (new CacheService())->clearProductCache();

        return $this;
    }
}
