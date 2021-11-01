<?php

namespace App\Http\Controllers\api\v1;
use App\Http\Controllers\api\v1\BaseController as BaseController;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Services\ProductServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data =  Product::all();
        return $this->sendResponse($data, 'All Product List');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request, ProductServices $productServices)
    {
        if (is_null($this->user) || !$this->user->can('product.store')) {
            abort(403, 'Sorry !! You are Unauthorized to store any product !');
        }

        $image = $productServices->image($request);
        $data['product'] = Product::create(array_merge($request->all(), $image));
        return $this->sendResponse($data, 'Product Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $data['product'] =$product;
        return $this->sendResponse($data, 'Product Show Successfully');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product, ProductServices $productServices)
    {
        if (is_null($this->user) || !$this->user->can('product.update')) {
            abort(403, 'Sorry !! You are Unauthorized to update any product !');
        }
        $image = $productServices->image($request);
        $data['product'] = $product->update(array_merge($request->all(), $image));
        return $this->sendResponse($data, 'Product Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, ProductServices $productService)
    {
        if (is_null($this->user) || !$this->user->can('product.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete any product !');
        }
        $productService->imageDelete($product->image);
        $product->delete();
        return $this->sendResponse('Deleted', 'Product Deleted Successfully');
    }
}
