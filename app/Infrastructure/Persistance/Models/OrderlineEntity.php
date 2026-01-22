<?php

namespace App\Infrastructure\Persistance\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * @property string $id
 * @property string $product_id
 * @property int    $quantity
 * @property string $order_id
 * @property-read OrderEntity $order
 *
 * @mixin \Eloquent
 */
class OrderlineEntity extends Model
{
    /**
     * The table
     *
     * @var string
     */
    protected $table = 'orderlines';

    protected $fillable = [
        'id',
        'productId',
        'quantity',
        'order_id',
    ];

    /**
     * The storage format of the model's date columns.
     *
     * @var string
    */
    protected $dateFormat = 'd/m/Y H:i:s';

    public function order()
    {
        return $this->belongsTo(OrderEntity::class, 'order_id', 'id');
    }
}
