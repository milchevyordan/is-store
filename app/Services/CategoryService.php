<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Services\DataTable\DataTable;

class CategoryService
{
    /**
     * Context model.
     *
     * @var Category
     */
    private Category $model;

    /**
     * Get the value of model.
     *
     * @return Category
     */
    public function getCategory(): Category
    {
        return $this->model;
    }

    /**
     * Set the value of model.
     *
     * @param  Category $model
     * @return self
     */
    public function setCategory(Category $model): self
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Create a new CategoryService instance.
     */
    public function __construct()
    {
        $this->setCategory(new Category());
    }

    /**
     * Create a new CategoryService instance.
     *
     * @return DataTable
     */
    public function getIndexMethodDatatable(): DataTable
    {
        return (new DataTable(
            Category::query()
        ))
            ->setColumn('action', 'Action')
            ->setColumn('id', '#', true, true)
            ->setColumn('title', 'Title', true, true)
            ->setColumn('created_at', 'Created', true, true)
            ->setDateColumn('created_at', 'dd.mm.YYYY H:i')
            ->run();
    }

    /**
     * Create the quiz question.
     *
     * @param  StoreCategoryRequest $request
     * @return self
     */
    public function createCategory(StoreCategoryRequest $request): self
    {
        $validatedRequest = $request->validated();

        $category = new Category();
        $category->fill($validatedRequest);
        $category->creator_id = auth()->id();
        $category->save();

        $this->setCategory($category);

        return $this;
    }

    /**
     * Update the quiz question.
     *
     * @param  UpdateCategoryRequest $request
     * @return self
     */
    public function updateCategory(UpdateCategoryRequest $request): self
    {
        $validatedRequest = $request->validated();

        $category = $this->getCategory();
        $changeLoggerService = new ChangeLoggerService($category);

        $category->update($validatedRequest);

        $changeLoggerService->logChanges($category);
        $this->setCategory($category);

        return $this;
    }
}
