<?php

namespace App\Models;

use App\Exceptions\TestException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ProductSku
 *
 * @property int                             $id          ID
 * @property string                          $title       SKU 名称
 * @property string                          $description SKU 描述
 * @property string                          $price       SKU 价格
 * @property int                             $stock       库存
 * @property int                             $product_id  所属商品 id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product        $product
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSku newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSku newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSku query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSku whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSku whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSku whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSku wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSku whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSku whereStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSku whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSku whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ProductSku extends Model
{


    protected $fillable = ['title', 'description', 'price', 'stock', 'product_id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function orderItem()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * 减库存
     *
     * @param $amount
     * @return bool|int
     * @throws TestException
     */
    public function decreaseStock($amount)
    {
        if ($amount < 0) {
            throw new TestException('抱歉，不能为0');
        }
        return $this->where('id', $this->id)->where('stock', '>=', $amount)->decrement('stock', $amount);
    }

    /**
     * 增加库存
     *
     * @param $amount
     * @throws TestException
     */
    public function addStock($amount)
    {
        if ($amount < 0) {
            throw new TestException('加库存不可以小于0');
        }

        $this->increment('stock', $amount);
    }
}
