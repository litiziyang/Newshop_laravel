<?php


namespace App\Request;


use App\Models\CrowdfundingProduct;
use App\Models\Product;
use App\Models\ProductSku;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use phpDocumentor\Reflection\Types\Integer;

class CrowdFundingRequest extends Request
{
    /**
     * 获取应用于请求的验证规则.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'sku_id' => [
                'required', function ($attritube, $value, $fail) {
                    if (!$sku = ProductSku::find($value)) {
                        return $fail('该商品不存在');
                    }
                    if ($sku->product->type !== Product::TYPE_CROWDFUNDING) {
                        return $fail('该商品未开始众筹');
                    }
                    if (!$sku->product->on_sale) {
                        return $fail('该商品未上架');
                    }
                    if ($sku->product->crowdfunding->status !== CrowdfundingProduct::STATUS_FUNDING) {
                        return $fail('商品已经结束众筹');
                    }
                    if ($sku->stock = 0) {
                        return $fail('该商品库存已出售完');
                    }
                    if ($this->input('amount') > 0 && $sku->stock < $this->input('amount')) {
                        return $fail('库存不足');
                    }

                }
            ],
            'amount'=>['required','Integer','min:1' ],
            'address_id'=>[
                'required',
                Rule::exists('user_addresses','id')->where('user_id', $this->user()->id),
            ]
        ];
    }


}
