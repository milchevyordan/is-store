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
            Product::with('answers')
        ))
            ->setColumn('action', 'Action')
            ->setColumn('id', '#', true, true)
            ->setColumn('question', 'Question', true, true)
            ->setColumn('is_binary', 'Is Binary', true, true)
            ->setColumn('created_at', 'Created', true, true)
            ->setDateColumn('created_at', 'dd.mm.YYYY H:i')
            ->run();
    }

    /**
     * Create the quiz question.
     *
     * @param StoreProductRequest $request
     * @return self
     */
    public function createProduct(StoreProductRequest $request): self
    {
        $validatedRequest = $request->validated();

        $quizQuestion = new Product();
        $quizQuestion->fill($validatedRequest);
        $quizQuestion->save();

        if (!$validatedRequest['is_binary']) {
            $quizQuestion->answers()->createMany($validatedRequest['answers']);
        }

        $this->setProduct($quizQuestion);

        CacheService::clearQuestionsCache();

        return $this;
    }

    /**
     * Update the quiz question.
     *
     * @param UpdateProductRequest $request
     * @return self
     */
    public function updateProduct(UpdateProductRequest $request): self
    {
        $validatedRequest = $request->validated();

        $quizQuestion = $this->getProduct();
        $quizQuestion->update($validatedRequest);

        if (!$validatedRequest['is_binary']) {
            $quizQuestion->answers()->delete();
            $quizQuestion->answers()->createMany($validatedRequest['answers']);
        }

        $this->setProduct($quizQuestion);

        CacheService::clearQuestionsCache();

        return $this;
    }
}
