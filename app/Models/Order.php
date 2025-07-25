<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\OrderStatus;
use App\Traits\HasChangeLogs;
use App\Traits\HasCreator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasCreator;
    use HasChangeLogs;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'status',
        'name',
        'phone',
        'email',
        'delivery_address',
        'additional_requirements',
        'total_price',
        'delivery_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status'        => OrderStatus::class,
        'delivery_date' => 'datetime:Y-m-d',
    ];

    /**
     * Return relation to order products.
     *
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(OrderProduct::class)->with('product');
    }
}
