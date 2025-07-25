<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Services\CategoryService;
use App\Services\ChangeLogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;
use Throwable;

class CategoryController extends Controller
{
    public CategoryService $service;

    public function __construct()
    {
        $this->service = new CategoryService();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('categories/Index', [
            'dataTable'         => $this->service->getIndexMethodDatatable(),
            'changeLogsLimited' => ChangeLogService::getChangeLogsLimited(Category::class),
            'changeLogs'        => Inertia::lazy(fn () => ChangeLogService::getChangeLogsDataTable(Category::class)),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('categories/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCategoryRequest $request
     */
    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        DB::beginTransaction();

        try {
            $this->service->createCategory($request);

            DB::commit();

            return redirect()->route('admin.categories.edit', ['category' => $this->service->getCategory()->id])->with('success', 'Record successfully created.');
        } catch (Throwable $th) {
            DB::rollBack();

            Log::error($th->getMessage(), ['exception' => $th]);

            return redirect()->back()->withErrors(['Error creating record.']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Category $category
     */
    public function show(Category $category)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Category $category
     */
    public function edit(Category $category): Response
    {
        $category->load(['changeLogsLimited', 'creator']);

        return Inertia::render('categories/Edit', [
            'category' => $category,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCategoryRequest $request
     * @param Category              $category
     */
    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        DB::beginTransaction();

        try {
            $this->service->setCategory($category)->updateCategory($request);

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
     *
     * @param Category $category
     */
    public function destroy(Category $category)
    {
    }
}
