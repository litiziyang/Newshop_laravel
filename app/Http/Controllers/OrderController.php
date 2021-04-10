<?php


namespace App\Http\Controllers;



use App\Models\ProductSku;
use App\Models\UserAddress;
use App\Request\CrowdFundingRequest;
use App\Services\OrderService;

class OrderController extends Controller
{

    /**
     * @param CrowdFundingRequest $request
     * @param OrderService        $orderService
     */
    public function crowdfunding(CrowdFundingRequest $request, OrderService $orderService){
        $user=$request->user();
        $sku=ProductSku::find($request->input('sku_id'));
        $amount=$request->input('amount');
        $userAddress = UserAddress::find($request->input('address_id'));
        return $orderService->CrowdFunding($user,$sku,$amount,$userAddress);
    }
}
