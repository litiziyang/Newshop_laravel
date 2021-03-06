<?php


namespace App\Services;


use App\Exceptions\TestException;
use App\Jobs\CloseOrder;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductSku;
use App\Models\User;
use App\Models\UserAddress;
use Carbon\Carbon;

class OrderService
{
    public function CrowdFunding(User $user, ProductSku $productSku, $amount, UserAddress $userAddress)
    {
        $order = \DB::transaction(
            function () use ($amount, $productSku, $user, $userAddress) {
                $userAddress->update(['last_used_at' => Carbon::now()]);
                $order = Order::create([
                    'address'      => [
                        // 将地址信息放入订单中
                        'address'       => $userAddress->full_address,
                        'zip'           => $userAddress->zip,
                        'contact_name'  => $userAddress->contact_name,
                        'contact_phone' => $userAddress->contact_phone,
                    ],
                    'remark'       => '',
                    'total_amount' => $productSku->price * $amount,
                    'type'         => Order::TYPE_CROWDFUNDING,
                ]);

                $order->user()->associate($user);
                $order->save();
                $item = $order->items()->make(
                    [
                        'amount' => $amount,
                        'price'  => $productSku->price,
                    ]
                );
                $item->product()->associate($productSku->product_id);
                $item->productSku()->associate($productSku);
                $item->save();
                if ($productSku->decreaseStock($amount) <= 0) {
                    throw new TestException('抱歉 库存不足');
                }
                return $order;

            }
        );
        //众筹时间计算
        $crowFundingTime = $productSku->product->crowdfunding->end_at - time();
        //剩余秒数与默认订单关闭时间取较小值作为订单关闭时间
        dispatch(new CloseOrder($order, min(config('app.order_ttl', 18000), $crowFundingTime)));

        return $order;
    }
}
