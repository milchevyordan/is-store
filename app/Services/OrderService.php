<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Services\DataTable\DataTable;

class OrderService
{
    /**
     * Context product.
     *
     * @var Order
     */
    private Order $model;

    /**
     * Get the value of model.
     *
     * @return Order
     */
    public function getOrder(): Order
    {
        return $this->model;
    }

    /**
     * Set the value of model.
     *
     * @param  Order $model
     * @return self
     */
    public function setOrder(Order $model): self
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Create a new OrderService instance.
     */
    public function __construct()
    {
        $this->setOrder(new Order());
    }

    /**
     * Get all orders.
     *
     * @return DataTable
     */
    public function getIndexMethodDatatable(): DataTable
    {
        return (new DataTable(
            Order::query()
        ))
            ->setColumn('action', 'Action')
            ->setColumn('id', '#', true, true)
            ->setColumn('status', 'Status', true, true)
            ->setColumn('name', 'Name', true, true)
            ->setColumn('phone', 'Phone', true, true)
            ->setColumn('created_at', 'Created', true, true)
            ->setDateColumn('created_at', 'dd.mm.YYYY H:i')
            ->setEnumColumn('status', OrderStatus::class)
            ->run();
    }

    /**
     * Update order in admin.
     *
     * @param  array $validatedRequest
     * @return $this
     */
    public function updateOrder(array $validatedRequest): static
    {
        $order = $this->getOrder();

        $changeLoggerService = new ChangeLoggerService($order);

        $order->update($validatedRequest);
        $order->save();

        $this->setOrder($order);

        $changeLoggerService->logChanges($order);

        return $this;
    }
}
