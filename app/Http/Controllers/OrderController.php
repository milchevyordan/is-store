<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order;
use App\Services\ChangeLogService;
use App\Services\OrderService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;
use Throwable;

class OrderController extends Controller
{
    public OrderService $service;

    public function __construct()
    {
        $this->service = new OrderService();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('orders/Index', [
            'dataTable'         => fn () => $this->service->getIndexMethodDatatable(),
            'changeLogsLimited' => ChangeLogService::getChangeLogsLimited(Order::class),
            'changeLogs'        => Inertia::lazy(fn () => ChangeLogService::getChangeLogsDataTable(Order::class)),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  Order    $order
     * @return Response
     */
    public function show(Order $order): Response
    {
        $order->load(['changeLogsLimited', 'products']);

        return Inertia::render('orders/Show', [
            'order'      => $order,
            'changeLogs' => Inertia::lazy(fn () => ChangeLogService::getChangeLogsDataTable($order)),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Order    $order
     * @return Response
     */
    public function edit(Order $order): Response
    {
        $order->load(['changeLogsLimited', 'products']);

        return Inertia::render('orders/Edit', [
            'order'      => $order,
            'changeLogs' => Inertia::lazy(fn () => ChangeLogService::getChangeLogsDataTable($order)),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateOrderRequest $request
     * @param  Order              $order
     * @return RedirectResponse
     */
    public function update(UpdateOrderRequest $request, Order $order): RedirectResponse
    {
        DB::beginTransaction();

        try {
            $this->service->setOrder($order)->updateOrder($request->validated());

            DB::commit();

            return back()->with('success', 'Записа беше актуализиран успешно.');
        } catch (Throwable $th) {
            DB::rollBack();

            Log::error($th->getMessage(), ['exception' => $th]);

            return redirect()->back()->withErrors(['Error updating record.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Order            $order
     * @return RedirectResponse
     */
    public function destroy(Order $order): RedirectResponse
    {
        try {
            $order->delete();

            return redirect()->back()->with('success', 'The record has been successfully deleted.');
        } catch (Throwable $th) {
            Log::error($th->getMessage(), ['exception' => $th]);

            return redirect()->back()->withErrors(['Error deleting record.']);
        }
    }
}
