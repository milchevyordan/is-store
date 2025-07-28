<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class CacheService
{
    public function clearProductCache(): void
    {
        Cache::forget('products.offerings');

        foreach (['products.paginated', 'products.by_category'] as $tracker) {
            $this->clearByTracker($tracker);
        }
    }

    private function clearByTracker(string $tracker): void
    {
        $keys = Cache::get($tracker, []);

        foreach ($keys as $key) {
            Cache::forget($key);
        }

        Cache::forget($tracker);
    }
}
