<?php


namespace App\Http\Controllers\api\v1;
use App\Http\Controllers\api\v1\BaseController as BaseController;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['order'] =  Order::all();
        return $this->sendResponse($data, 'All Order List');
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
    public function store(Request $request)
    {
        $data['order'] =Order::create($request->only(
            'customer_name',
            'customer_mobile',
            'address',
            'district',
            'total_price',
            'user_id',
        ));
        foreach ($request->products as $product_id => $product) {
            OrderItem::create([
                'order_id'=>$data['order']->id,
                'product_id'=>$product_id,
                'price'=>$product["price"],
                'quantity'=>$product["quantity"],
            ]);
        }


        return $this->sendResponse($data, 'Order Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
