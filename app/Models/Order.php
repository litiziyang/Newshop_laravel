<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Order
 *
 * @property int                             $id             ID
 * @property string                          $no             订单流水号
 * @property int                             $user_id        下单用户ID
 * @property mixed                           $address        JSON格式的收货地址
 * @property string                          $total_amount   订单总金额
 * @property string|null                     $remark         订单备注
 * @property string|null                     $paid_at        支付时间
 * @property string|null                     $payment_method 支付方式
 * @property string|null                     $payment_no     支付平台订单号
 * @property string                          $refund_status  退款状态
 * @property string|null                     $refund_no      退款单号
 * @property int                             $closed         订单是否已关闭
 * @property int                             $reviewed       订单是否已评价
 * @property string                          $ship_status    物流状态
 * @property string|null                     $ship_data      物流数据
 * @property string|null                     $extra          其他额外的数据
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User           $user
 * @method static \Illuminate\Database\Eloquent\Builder|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereClosed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereExtra($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaidAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaymentNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereRefundNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereRefundStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereReviewed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereShipData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereShipStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUserId($value)
 * @mixin \Eloquent
 */
class Order extends Model
{
    const REFUND_STATUS_PENDING    = 'pending';     // 未退款
    const REFUND_STATUS_APPLIED    = 'applied';     // 已申请退款
    const REFUND_STATUS_PROCESSING = 'processing';  // 退款中
    const REFUND_STATUS_SUCCESS    = 'success';     // 退款成功
    const REFUND_STATUS_FAILED     = 'failed';      // 退款失败

    const SHIP_STATUS_PENDING   = 'pending';     // 未发货
    const SHIP_STATUS_DELIVERED = 'delivered';   // 已发货
    const SHIP_STATUS_RECEIVED  = 'received';    // 已收货

    const TYPE_NORMAL       = 'normal';         // 普通商品订单
    const TYPE_CROWDFUNDING = 'crowdfunding';   // 众筹商品订单
    const TYPE_SECKILL      = 'seckill';        // 秒杀商品订单

    public static $refundStatusMap = [
        self::REFUND_STATUS_PENDING    => '未退款',
        self::REFUND_STATUS_APPLIED    => '已申请退款',
        self::REFUND_STATUS_PROCESSING => '退款中',
        self::REFUND_STATUS_SUCCESS    => '退款成功',
        self::REFUND_STATUS_FAILED     => '退款失败',
    ];

    public static $shipStatusMap = [
        self::SHIP_STATUS_PENDING   => '未发货',
        self::SHIP_STATUS_DELIVERED => '已发货',
        self::SHIP_STATUS_RECEIVED  => '已收货',
    ];

    public static $typeMap = [
        self::TYPE_NORMAL       => '普通商品订单',
        self::TYPE_CROWDFUNDING => '众筹商品订单',
        self::TYPE_SECKILL      => '秒杀商品订单'
    ];

    /**
     * 可以被批量赋值的属性
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'no',
        'address',
        'total_amount',
        'remark',
        'paid_at',
        'payment_method',
        'payment_no',
        'refund_status',
        'refund_no',
        'closed',
        'reviewed',
        'ship_status',
        'ship_data',
        'extra',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(
            function ($model) {
                if ($model->no) {
                    $model->no = self::findAvailableNo();
                }
                if (!$model->no) {
                    return false;
                }
            }
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function product()
    {

    }

    public function findAvailableNo()
    {
        $prefix = date('YmdHis');
        for ($i = 0; $i < 10; $i++) {
            // 随机生成 6 位的数字
            $no = $prefix . str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            // 判断是否已经存在
            if (!static::query()->where('no', $no)->exists()) {
                return $no;
            }
        }
        \Log::warning('find order no failed');

        return false;
    }
}
