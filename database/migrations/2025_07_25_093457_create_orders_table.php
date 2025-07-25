<?php

declare(strict_types=1);

use App\Enums\OrderStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->enum('status', OrderStatus::values())->default(OrderStatus::New->value);

            $table->string('phone');
            $table->string('additional_requirements')->nullable();
            $table->text('delivery_address')->nullable();
            $table->date('delivery_date')->nullable();

            $table->string('name');
            $table->string('email')->nullable();
            $table->decimal('total_price')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
