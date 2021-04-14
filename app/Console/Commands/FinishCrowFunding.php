<?php

namespace App\Console\Commands;

use App\Models\CrowdfundingProduct;
use Carbon\Carbon;
use Illuminate\Console\Command;

class FinishCrowFunding extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:finish-crowfunding';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '结束众筹';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        CrowdfundingProduct::query()
                           ->where('end_at', '<=', Carbon::now())
                           ->where('status', CrowdfundingProduct::STATUS_FUNDING)
                           ->get()
                           ->each(
                               function (CrowdfundingProduct $crowdfundingProduct) {
                                   if ($crowdfundingProduct->target_amount > $crowdfundingProduct->total_amount) {
                                       $this->crowFundingFailed($crowdfundingProduct);
                                   } else {
                                       $this->crowFundingSuccess($crowdfundingProduct);
                                   }
                               }
                           );

    }

    /**
     * 众筹成功
     *
     * @param CrowdfundingProduct $crowdfundingProduct
     */
    protected function crowFundingSuccess(CrowdfundingProduct $crowdfundingProduct)
    {
        //修改众筹状态
        $crowdfundingProduct->update([
            'satatus' => CrowdfundingProduct::STATUS_SUCCESS
        ]);
    }

    /**
     * 众筹失败
     *
     * @param CrowdfundingProduct $crowdfundingProduct
     */
    protected function crowFundingFailed(CrowdfundingProduct $crowdfundingProduct)
    {
        //修改众筹状态
        $crowdfundingProduct->update([
            'status' => CrowdfundingProduct::STATUS_FAIL
        ]);

        //dispatch(new )
    }
}
