<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CrowdfundingProduct
 *
 * @property int    $id            ID
 * @property int    $product_id    商品ID
 * @property string $target_amount 众筹目标金额
 * @property string $total_amount  当前已筹金额
 * @property int    $user_count    当前参与众筹用户数
 * @property string $end_at        众筹结束时间
 * @property string $status        当前众筹的状态
 * @method static \Illuminate\Database\Eloquent\Builder|CrowdfundingProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CrowdfundingProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CrowdfundingProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder|CrowdfundingProduct whereEndAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrowdfundingProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrowdfundingProduct whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrowdfundingProduct whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrowdfundingProduct whereTargetAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrowdfundingProduct whereTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrowdfundingProduct whereUserCount($value)
 * @mixin \Eloquent
 * @property-read mixed $percent
 * @property-read \App\Models\Product $product
 */
class CrowdfundingProduct extends Model
{
    // 定义众筹的 3 中状态
    const STATUS_FUNDING = 'funding';
    const STATUS_SUCCESS = 'success';
    const STATUS_FAIL    = 'fail';

    public static $statusMap = [
        self::STATUS_FUNDING => '众筹中',
        self::STATUS_SUCCESS => '众筹成功',
        self::STATUS_FAIL    => '众筹失败',
    ];

    protected $fillable = [
        'product_id', 'target_amount', 'total_amount', 'user_count', 'status'
    ];

    /**
     * 获取商品
     *
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getPercentAttribute()
    {
       $value= $this->attributes['total_amount']/$this->attributes['target_amount'];
    }

}
