<?php

namespace App\Observers;

use App\Jobs\OrderCreateJob;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Log;

class OrderOvserver
{
    protected $request;

    public function __construct()
    {
        $this->request = app('request');
    }
    /**
     * Handle the Order "created" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function created(Order $order)
    {

        foreach ($this->request->products as $product) {
            $orderItem=[
                'order_id'=>$order->id,
                'product_id'=>$product['product']['id'],
                'price'=>$product['product']['price'],
                'quantity'=>$product['product']['quantity'],
            ];
            Log::debug($orderItem);
            OrderItem::create($orderItem);
        }
        dispatch(new OrderCreateJob($order));
    }

    /**
     * Handle the Order "updated" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function updated(Order $order)
    {
        //
    }

    /**
     * Handle the Order "deleted" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function deleted(Order $order)
    {
        //
    }

    /**
     * Handle the Order "restored" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function restored(Order $order)
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function forceDeleted(Order $order)
    {
        //
    }
}
