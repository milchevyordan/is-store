<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table
                ->foreignId('creator_id')
                ->nullable()
                ->constrained('users');

            $table->foreignId('category_id')
                ->nullable()
                ->constrained('categories');

            $table->string('image')->nullable();

            $table->string('slug');
            $table->string('title');
            $table->text('description')->nullable();

            $table->decimal('price')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
