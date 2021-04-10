<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\OrderItem
 *
 * @property int         $id             ID
 * @property int         $order_id       订单ID
 * @property int         $product_id     商品ID
 * @property int         $product_sku_id 商品SKU ID
 * @property int         $amount         数量
 * @property string      $price          单价
 * @property int|null    $rating         用户打分
 * @property string|null $review         用户评价
 * @property string|null $reviewed_at    评价时间
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereProductSkuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereReview($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereReviewedAt($value)
 * @mixin \Eloquent
 */
class OrderItem extends Model
{
    /**
     * 可以被批量赋值的属性
     *
     * @var array
     */
    protected $fillable = [
        'amount',
        'price',
        'rating',
        'review',
        'reviewed_at'
    ];

    /**
     * 可以被批量赋值的属性
     *
     * @var array
     */
    protected $dates = ['reviewed_at'];

    /**
     * 指示是否自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * 商品信息
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * 商品SKU信息
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function productSku()
    {
        return $this->belongsTo(ProductSku::class);
    }

    /**
     * 订单信息
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
