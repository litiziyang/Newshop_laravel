<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Product
 *
 * @property int                                                                    $id           ID
 * @property string                                                                 $title        商品名称
 * @property string                                                                 $description  商品详情
 * @property string                                                                 $image        商品封面图片文件路径
 * @property int                                                                    $on_sale      商品是否正在售卖
 * @property string                                                                 $rating       商品平均评分
 * @property int                                                                    $sold_count   销量
 * @property int                                                                    $review_count 评价数量
 * @property string                                                                 $price        SKU 最低价格
 * @property \Illuminate\Support\Carbon|null                                        $created_at
 * @property \Illuminate\Support\Carbon|null                                        $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereOnSale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereReviewCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSoldCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\CrowdfundingProduct|null                              $crowdfunding
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProductSku[] $skus
 * @property-read int|null                                                          $skus_count
 * @property string                                                                 $type         商品类型
 * @property int|null                                                               $category_id  类目ID
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereType($value)
 */
class Product extends Model
{
    //use HasFactory;

    const TYPE_NORMAL       = 'normal';
    const TYPE_CROWDFUNDING = 'crowdfunding';
    const TYPE_SECKILL      = 'seckill';

    public static $typeMap = [
        self::TYPE_NORMAL       => '普通商品',
        self::TYPE_CROWDFUNDING => '众筹商品',
        self::TYPE_SECKILL      => '秒杀商品',
    ];


    protected $fillable = [
        'title', 'description', 'image', 'on_sale', 'sold_count', 'review_count', 'price'
    ];


    /**
     * 获取众筹商品
     */
    public function crowdfunding()
    {
        return $this->hasOne(CrowdfundingProduct::class);
    }

    /**
     * 获取商品规格
     */
    public function skus()
    {
        return $this->hasMany(ProductSku::class);
    }

    public function orderItem()
    {
        return $this->hasMany(OrderItem::class);
    }

}
