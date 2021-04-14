<?php

namespace App\Jobs;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Redis;

class CloseOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Order $order, $delay)
    {
        $this->order = $order;
        $this->delay($delay);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //判断订单是否被支付
        //如果已经支付 直接返回
        if ($this->order->paid_at) {
            return;
        }
        \DB::transaction(
            function () {
                //将close字段标记为true
                $this->order->update(['closed' => true]);
                foreach ($this->order->items as $item) {
                    $item->productSku->addStock($item->amount);
                    if ($item->order->type === Order::TYPE_SECKILL && $item->product->on_sale && !$item->product->seckill->is_after_end) {
                        Redis::incr('seckill_sku_' . $item->productSku->id);
                    }
                }
            }
        );

    }
}
