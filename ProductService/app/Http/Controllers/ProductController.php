<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index()
    {
        return $this->data(Product::all());
    }

    public function store(Request $request)
    {
        try {
            /**TODO Apply some validation in the future. */
            $product = Product::create($request->all());
            return $this->data(['id' => $product->id]);
        } catch (\Exception $e) {
            return $this->failed();
        }
    }

    public function show(Product $product)
    {
        return $this->data($product);
    }

    public function update(Request $request, Product $product)
    {
        /**TODO Do some sort of validation. */
        try {
            $product->update($request->all());
            return $this->success();
        } catch (\Exception $e) {
            return $this->failed();
        }
    }

    public function destroy(Product $product)
    {
        try {
            /** Apply some sort of checking policy */
            $product->delete();
            return $this->success();
        } catch (\Exception $e) {
            return $this->failed();
        }
    }
}
