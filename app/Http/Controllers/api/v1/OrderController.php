<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\api\v1\BaseController as BaseController;
use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\OrderServices;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
class OrderController extends BaseController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (is_null($this->user) || !$this->user->can('order.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any Order !');
        }
        $data = Order::with('orderItems', 'orderItems.products')->get();
        return $this->sendResponse($data, 'All Order List', Response::HTTP_CREATED);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderRequest $request, OrderServices $orderServices)
    {
        if (is_null($this->user) || !$this->user->can('order.store')) {
            abort(403, 'Sorry !! You are Unauthorized to Store any Order !');
        }

        $order = Order::create($request->only('customer_name', 'customer_mobile', 'address', 'district', 'total_price', 'user_id'));

        return $this->sendResponse($order, 'Order Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {

        if (is_null($this->user) || !$this->user->can('order.show')) {
            abort(403, 'Sorry !! You are Unauthorized to show any Order !');
        }
        $data['order'] = $order->with('orderItems', 'orderItems.products')->first();
        return $this->sendResponse($data, 'All Order List');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {

        if (is_null($this->user) || !$this->user->can('order.update')) {
            abort(403, 'Sorry !! You are Unauthorized to update any Order !');
        }

        $order->update($request->only('customer_name', 'customer_mobile', 'address', 'district', 'total_price'));
        return $this->sendResponse($order, 'Order Update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        if (is_null($this->user) || !$this->user->can('order.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete any Order !');
        }
        $order->delete();
        return $this->sendResponse('Deleted', 'Order Deleted Successfully');
    }

    public function status(Order $order, Request $request)
    {
        if (is_null($this->user) || !$this->user->can('order.approve')) {
            abort(403, 'Sorry !! You are Unauthorized to delete any Order !');
        }
        $results = Order::with(['orderItems', 'orderItems.products'])->where('id', '=', $order->id)->first();
        $results->status = $request->status;
        $results->save();

        if ($results->status == "Delivered") {
            foreach ($results->orderItems as $key => $op) {
                $productId = $op->product_id;
                $productOrderQuantity = $op->quantity;

                $products = Product::find($productId);
                $productUpdateStock = $products->quantity - $productOrderQuantity;
                $products->update([
                    'quantity' => $productUpdateStock,
                ]);

            }
        }

        return $this->sendResponse($order, 'Order Status updated');
    }
}
